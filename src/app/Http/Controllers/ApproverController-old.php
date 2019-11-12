<?php
/**
 * 处理开发方相关操作
 * @date: 2018年11月19日 下午7:55:52
 * @author: wongwuchiu
 */
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Group;
use App\Models\Version;
use App\Models\ApprRecord;
use App\Models\Event;
use App\Models\Component;
use Illuminate\Http\Request;
use App\Services\VersionService;
use App\Services\UserService;
use App\Services\GroupService;
use App\Services\EventService;
use App\Services\ApprGroupService;
use App\Services\ApprNodeService;
use App\Services\ApprRecordService;
use App\Services\ComponentService;
use App\Services\CompAuthorityService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\DocBlock\Description;

class ApproverController extends BaseController
{
    
    function __construct(GroupService $groupService,VersionService $versionService, ApprRecordService $apprRecordService,ApprGroupService $apprGroupService, ApprNodeService $apprNodeService, EventService $eventService, ComponentService $componentService,CompAuthorityService $compAuthorityService, UserService $userService)
    {
        $this->middleware('auth');
        $this->componentService = $componentService;
        $this->apprGroupService = $apprGroupService;
        $this->groupService = $groupService;
        $this->apprNodeService = $apprNodeService;
        $this->versionService = $versionService;
        $this->apprRecordService = $apprRecordService;
        $this->eventService = $eventService;
        $this->compAuthorityService = $compAuthorityService;
        $this->userService = $userService;
        // 此时的的 $this->userService相当于实例化了服务容器：UserService
    }
    
    /**
    * 获取当前用户可访问的组件列表
    * @date: 2018年11月22日 上午9:20:09
    * @author: wongwuchiu
    * @param: http Request
    * @return: 分页后的组件列表页面
    */
    public function appr_complist($select_type,$select_group,Request $request)
    {
        $user = Auth::user();
        $mComponents = $this->getCompsList($select_type, $select_group);
        $groups = $this->groupService->getAll();
//         if ($this->isAdmin()){
//             if($select_type != 0 && $select_group != 0){
//                 $mComponents = $this->componentService->getAll()->where('comp_type',$select_type)->where('group_id',$select_group);
//             } else if($select_type != 0 && $select_group == 0){
//                 $mComponents = $this->componentService->getAll()->where('comp_type',$select_type);
//             } else if($select_group != 0 && $select_type == 0){
//                 $mComponents = $this->componentService->getAll()->where('group_id',$select_group);
//             } else {
//                 $mComponents = $this->componentService->getAll();
//             }
//         } else {
//             if($select_type != 0 && $select_group != 0){
//                 $mComponents = $user->Component->where('comp_type',$select_type)->where('group_id',$select_group);
//             } else if($select_type != 0 && $select_group == 0){
//                 $mComponents = $user->Component->where('comp_type',$select_type);
//             } else if($select_group != 0 && $select_type == 0){
//                 $mComponents = $user->Component->where('group_id',$select_group);
//             } else {
//                 $mComponents = $user->Component;
//             }
//         }
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mComponents->count();
//         $result = $mComponents->sortByDesc("appr_status")->sortByDesc("appr_updated")->forPage($currentPage, $perPage);
        $results = $mComponents->forPage($currentPage, $perPage);
        foreach ($results as $result)
        {
            $result->group_name = $this->groupService->getById($result->group_id)->group_name;
            $comp_id = $result->id;
            if(!$this->isAdmin() && !$this->checkHasEvent($comp_id)){
                $result->appr_status = 10000;
            }
        }
        $components= new LengthAwarePaginator($results,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return view('approver/complist', compact('components','select_type','select_group','groups'));
    }

    public function getCompsList($select_type,$select_group){
        $user = Auth::user();
        $mComponents = null;
        if ($this->isAdmin()){
            if($select_type != 0 && $select_group != 0){
                $mComponents = Component::where('comp_type',$select_type)->where('group_id',$select_group)->orderBy('appr_status', 'desc')
                ->orderBy('appr_updated', 'asc')->get();
            } else if($select_type != 0 && $select_group == 0){
                $mComponents = Component::where('comp_type',$select_type)->orderBy('appr_status', 'desc')
                ->orderBy('appr_updated', 'asc')->get();
            } else if($select_group != 0 && $select_type == 0){
                $mComponents = Component::where('group_id',$select_group)->orderBy('appr_status', 'desc')
                ->orderBy('appr_updated', 'asc')->get();
            } else {
                $mComponents = Component::orderBy('appr_status', 'desc')
                ->orderBy('appr_updated', 'asc')->get();
            }
        } else {
            if($select_type != 0 && $select_group != 0){
                $mComponents = DB::table('compauthority')
                ->where('user_id',$user->id)
                ->leftJoin('component', 'compauthority.comp_id', '=', 'component.id')
                ->select('component.*')
                ->where('component.comp_type',$select_type)
                ->where('component.group_id',$select_group)
                ->orderBy('component.appr_status', 'desc')
                ->orderBy('component.appr_updated', 'asc')
                ->get();
            } else if($select_type != 0 && $select_group == 0){
                $mComponents = DB::table('compauthority')
                ->where('user_id',$user->id)
                ->leftJoin('component', 'compauthority.comp_id', '=', 'component.id')
                ->select('component.*')
                ->where('component.comp_type',$select_type)
                ->orderBy('component.appr_status', 'desc')
                ->orderBy('component.appr_updated', 'asc')
                ->get();
            } else if($select_group != 0 && $select_type == 0){
                $mComponents = DB::table('compauthority')
                ->where('user_id',$user->id)
                ->leftJoin('component', 'compauthority.comp_id', '=', 'component.id')
                ->select('component.*')
                ->where('component.group_id',$select_group)
                ->orderBy('component.appr_status', 'desc')
                ->orderBy('component.appr_updated', 'asc')
                ->get();
            } else {
                $mComponents = DB::table('compauthority')
                ->where('user_id',$user->id)
                ->leftJoin('component', 'compauthority.comp_id', '=', 'component.id')
                ->select('component.*')
                ->orderBy('component.appr_status', 'desc')
                ->orderBy('component.appr_updated', 'asc')
                ->get();
            }
        }
        return $mComponents;
    }
    
    public function appr_detail($event_id){
        $event = $this->eventService->getById($event_id);
        $records = $event->ApprRecords;
        return view('approver/detail',compact('records'));
    }
    
    public function appr_eventlist(Request $request)
    {
        $user = Auth::user();
        $mRecords = $user->ApprRecords;
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mRecords->count();
        $result = $mRecords->sortByDesc("created_at")->forPage($currentPage, $perPage);
        $records= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return view('approver/eventlist',compact('records'));
//         return view('approver/complist', compact('components','select_type','select_group','groups'));
    }
    
    /**
    * 获取组件相关待审批事件
    * @date: 2018年11月22日 上午10:49:02
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function appr_requestlist($comp_id,Request $request)
    {
        //Step1:获取当前机关用户的所有所属分组，并计入数组
        $approver = Auth::user();
        $apprGroups = $approver->ApprGroup;
        $apprGroupList = array();
        foreach ($apprGroups as $agroup){
            $nodeId = $agroup->node_id;
            $apprGroupList[] = $nodeId;
        }
        //Step2:通过组件id组件的相关待审批申请，分页显示，对待审批申请分组
        $events = $this->eventService->getByApprPage($comp_id, 15, $request);
        //Step3:通过comp_id获得当前组件的信息
        $component = $this->componentService->getById($comp_id);
        $compType = $component->comp_type;
        //Step4:遍历要显示的申请，通过模板获取当前组号，检查该组号在不在Step1的数组中，在则有权审核
        foreach($events as $event){
//             $level = $event->appr_level;
//             $nodeId = $this->apprNodeService->getApprNode($compType,$level);
            //1.18依据当前事件审批节点判断是否有权授权
            $nodeId = $event->appr_node;
            if (in_array($nodeId,$apprGroupList) || $this->isAdmin()){
                //该组件在审批人的审批权限内
                $event->show_appr = 1;
            } else{
                //该组件不在审批人的审批权限内
                $event->show_appr = 0;
            }
        }
        
        $events->sortByDesc("show_appr")->sortByDesc("updated_at");
        //Step5:打开网页
        return view('approver/requestlist',compact("events"));
    }
    
    public function checkHasEvent($comp_id){
        //Step1:获取当前机关用户的所有所属分组，并计入数组
        $approver = Auth::user();
        $apprGroups = $approver->ApprGroup;
        $apprGroupList = array();
        foreach ($apprGroups as $agroup){
            $nodeId = $agroup->node_id;
            $apprGroupList[] = $nodeId;
        }
        //Step2:通过组件id组件的相关待审批申请，分页显示，对待审批申请分组
        $events = $this->eventService->getByApprStatus($comp_id);
        //Step4:遍历要显示的申请，通过模板获取当前组号，检查该组号在不在Step1的数组中，在则有权审核
        foreach($events as $event){
            //             $level = $event->appr_level;
            //             $nodeId = $this->apprNodeService->getApprNode($compType,$level);
            //1.18依据当前事件审批节点判断是否有权授权
            $nodeId = $event->appr_node;
//             return $nodeId;
            if (in_array($nodeId,$apprGroupList)){
                return true;
            }
        }
        return false;
//         return false;
    }
    
    /**
     * 进入审批页面
     * @date: 2018年11月22日 上午10:49:02
     * @author: wongwuchiu
     * @param: variable
     * @return:
     */
    public function appr_info($event_id)
    {
        //Step1:获取当前审批事件ID，以及前置事件信息
        $event = $this->eventService->getById($event_id);
        $preevent_id = $event->pre_event;
        $preevent = $this->eventService->getById($preevent_id);
        $records = $event->ApprRecords;
        return view('approver/info',compact("event","preevent","records"));
    }
    
    public function appr_makechoice($event_id,Request $request)
    {
        $appr_pass = $request->get("appr_pass");
        if ($appr_pass == 1){
            return $this->appr_pass($event_id,$request);
        }
        else if ($appr_pass == 0){
            return $this->appr_nopass($event_id,$request);
        } else {
            $url = "approver/complist/0/0";
            $msg = "审批选择类型出错！";
            return view('error', compact("url","msg"));
        }
    }

    /**
    * 审批通过，依据类型寻找对应处理方法
    * @date: 2018年11月23日 上午10:27:51
    * @author: wongwuchiu
    * @param: 审批事件类型type，审批事件event_id
    * @return: 各处理方法结果
    */
    public function appr_pass($event_id,Request $request){
        //Step1:获取审批事件相关信息，并判断是否可推进
        $event = $this->eventService->getById($event_id);
        $type = $event->type;
        $level = $event->appr_level;
        $compType = $event->Component->comp_type;
        $compId = $event->comp_id;
        //$nodeId = $this->apprNodeService->getApprNode($compType, $level);
        //1.18：修改使用事件的当前审批节点
        $nodeId = $event->appr_node;
        $node = $this->apprNodeService->getById($nodeId);
        $currentUser = Auth::user()->id;
        $checkOk = ($this->apprGroupService->isInNode($currentUser, $nodeId) || $this->isAdmin()) && $event->has_assigned == 0;
        if (!$checkOk){
            $url = "approver/complist/0/0";
            $msg = "审批不可允许通过！";
            return view('error', compact("url","msg"));
        }
        //Step2:获取审批的描述，并记录到审批记录中
        $appr_desc = $request->get("appr_desc");
        $apprRecord = new ApprRecord();
        $apprRecord->appr_event = $event_id;
        $apprRecord->approver = $currentUser;
        $apprRecord->appr_desc = $appr_desc;
        $apprRecord->appr_node = $nodeId;
        $apprRecord->has_passed = 1;
        $saveRet = $this->apprRecordService->append($apprRecord);
        if (!$saveRet){
            $url = "approver/complist/0/0";
            $msg = "审批记录写入！";
            return view('error', compact("url","msg"));
        }
        //Step3:判断是否审批到最高节点
        if($level == $node->max_level || $node->next_node == -1){
            //审批到达最后的节点，进行出入库工作
            switch ($type){
                case 11000:
                    return $this->pass_devimport($event_id);
                    break;
                case 12000:
                    return $this->pass_testexport($event_id);
                    break;
                case 13000:
                    return $this->pass_testimport($event_id);
                    break;
                default:
                    $url = "approver/complist/0/0";
                    $msg = "审批通过方法类型出错！";
                    return view('error', compact("url","msg"));
                    break;
            }
        } else {
            //继续推进审批
            $event->appr_level = $level + 1;
            $nextNode = $node->next_node;
            $event->appr_node = $nextNode;
            if(!$this->checkNextStep($compId, $nextNode)){
                switch ($type){
                    case 11000:
                        $event->status = 11101;
                        break;
                    case 12000:
                        $event->status = 21101;
                        break;
                    case 13000:
                        $event->status = 31101;
                        break;
                    default:
                        $event->status = 11101;
                        break;
                }
            }
            $saveRet = $this->eventService->update($event);
            if (!$saveRet){
                $url = "approver/complist/0/0";
                $msg = "审批记录储存通过！";
                return view('error', compact("url","msg"));
            }
            //返回组件列表
            $url = "approver/complist/0/0";
            return view('success', compact("url"));
        }
    }
    
    /**
    * 开发方入库申请通过
    * @date: 2018年11月23日 上午10:35:35
    * @author: wongwuchiu
    * @param: 审批事件event_id
    * @return: 结果页面
    */
    public function pass_devimport($event_id){
        //Step1:获取审批事件相关信息和前置的开发事件信息
        $event = $this->eventService->getById($event_id);
        $pre_id = $event->pre_event;
        $importEvent = $this->eventService->getById($pre_id);
        if ($importEvent == null){
            $url = "approver/complist/0/0";
            $msg = "前置入库事件不存在！";
            return view('error', compact("url","msg"));
        }
        //Step2:设定好入受控库库的相关路径，并将组件文件从临时目录复制到受控库目录并做git处理
        $tempPath = $event->file_path;
        $temp_dir = storage_path() . $tempPath;
        $destPath = '/app/upload/ShouKong/' . $event->comp_id . '/' . $event->ver_num . '/';
        $dest_dir = storage_path() . $destPath;
        //Step2.1:检查是否存在组件文件夹，若不存在则新建并建立git仓库(git init)
        $cmdPath = 'cd ' . $dest_dir . ' && ';
        if(!is_dir($dest_dir))
        {
            mkdir ($dest_dir,0777,true);
            $cmdGitInit = 'git init';
            exec($cmdPath . $cmdGitInit,$ret);
        }
        //Step2.2:复制文件并作git处理
        $this->gitcopydir($temp_dir, $dest_dir, $dest_dir);
        //Step2.3:进行git commit
        $msg = '"' . $event->description . '"';
        $cmdGitCom = 'git commit -m';
        exec($cmdPath . $cmdGitCom . $msg, $ret);
        //Step3:设定好说明文件的相关路径，并将入库的说明文件从临时目录复制到说明文件目录下
        $tempDesc = $event->descdoc_path;
        $temp_desc_dir = storage_path() . $tempDesc;
        $descPath = '/app/upload/DescDoc/' . $event->comp_id . '/' . $event->ver_num . '/';
        $dest_desc_dir = storage_path() . $descPath;
        $this->copydir($temp_desc_dir, $dest_desc_dir);
        //Step4:新建受控库版本version信息，记录版本号
        $skVersion = new Version();
        $skVersion->type = 0;
        $skVersion->comp_id = $event->comp_id;
        $skVersion->ver_num = $event->ver_num;
        $skVersion->ver_status = 1;
        $skVersion->event_import = $pre_id;
        $skVersion->file_path = $destPath;
        $skVersion->descdoc_path = $descPath;
        $skVersion->testdoc_path = null;
        $skId = $this->versionService->appendID($skVersion);
        if($skId == 0){
            $url = "approver/complist/0/0";
            $msg = "新建版本信息错误！";
            return view('error', compact("url","msg"));
        }
        //Step5:修改组件Component的最新版本号，解锁入库，修改审批事件和前置入库事件状态
        $component = $this->componentService->getById($event->comp_id);
        $component->latest_vernum = $event->ver_num;
        $component->dev_import = 1001;
        $saveRet = $this->componentService->update($component);
        if(!$saveRet){
            $url = "approver/complist/0/0";
            $msg = "修改组件信息出错！";
            return view('error', compact("url","msg"));
        }
        $apprRet = $this->componentService->apprDone($event->comp_id);
        if(!$apprRet){
            $url = "approver/complist/0/0";
            $msg = "修改组件审批信息出错！";
            return view('error', compact("url","msg"));
        }
        $event->status = 11001;
        $event->has_assigned = 1;
        $saveRet = $this->eventService->update($event);
        if(!$saveRet){
            $url = "approver/complist/0/0";
            $msg = "修改审核事件信息出错！";
            return view('error', compact("url","msg"));
        }
        $importEvent->status = 1101;
        $importEvent->comp_ver = $skId;
        $saveRet = $this->eventService->update($importEvent);
        if(!$saveRet){
            $url = "approver/complist/0/0";
            $msg = "修改入库事件信息出错！";
            return view('error', compact("url","msg"));
        }
//         //Step6:新增一条测试事件
//         $testEvent = new Event();
//         $testEvent->type = 2000;
//         $testEvent->user_id = 0;
//         $testEvent->description = null;
//         $testEvent->comp_id = $event->comp_id;
//         $testEvent->comp_ver = $skId;
//         $testEvent->ver_num = $event->ver_num;
//         $testEvent->status = 2100;
//         $testEvent->has_assigned = 0;
//         $testEvent->file_path = $destPath;
//         $testEvent->descdoc_path = $descPath;
//         $testEvent->testdoc_path = null;
//         $testEvent->pre_event = $pre_id;
//         $testEvent->appr_level = 0;
//         $testID = $this->eventService->appendID($testEvent);
//         if ($testID == 0){
//             $url = 'approver/complist/0/0';
//             $msg = '新增测试方测试版本事件出错!';
//             return view('error', compact("url","msg"));
//         }
//         $testRet = $this->componentService->testNew($event->comp_id);
//         if(!$testRet){
//             $url = "approver/complist/0/0";
//             $msg = "修改组件审批信息出错！";
//             return view('error', compact("url","msg"));
//         }
        //返回组件列表
        $url = "approver/complist/0/0";
        return view('success', compact("url"));

    }
    
    /**
     * 测试方出库申请通过
     * @date: 2018年11月23日 上午10:35:35
     * @author: wongwuchiu
     * @param: 审批事件event_id
     * @return: 结果页面
     */
    public function pass_testexport($event_id){
        //Step1:获取审批事件和前置测试事件和前置入库事件
        $apprEvent = $this->eventService->getById($event_id);
        $testEvent = $apprEvent->Preevent;
//         $devEvent = $testEvent->Preevent;
        //Step2:修改前置测试事件的状态
        $testEvent->status = 2102;
        $testRet = $this->eventService->update($testEvent);
        if (!$testRet){
            $url = "approver/complist/0/0";
            $msg = "修改前置测试事件状态出错！";
            return view('error', compact("url","msg"));
        }
        //Step3:修改审批事件状态
        $apprEvent->has_assigned = 1;
        $apprEvent->status = 21001;
        $apprRet = $this->eventService->update($apprEvent);
        if (!$apprRet){
            $url = "approver/complist/0/0";
            $msg = "修改审批事件状态出错！";
            return view('error', compact("url","msg"));
        }
        //Step4:修改前置入库事件（改为下载时修改）
//         $devEvent->status = 1200;
//         $devRet = $this->eventService->update($devEvent);
//         if (!$devRet){
//             $url = "approver/complist/0/0";
//             $msg = "修改开发入库事件状态出错！";
//             return view('error', compact("url","msg"));
//         }
        //Step5:修改组件测状态信息
        $updateRet = $this->componentService->apprDone($apprEvent->comp_id);
        if (!$updateRet){
            $url = "approver/complist/0/0";
            $msg = "修改组件状态出错！";
            return view('error', compact("url","msg"));
        }
        //返回组件列表
        $url = "approver/complist/0/0";
        return view('success', compact("url"));
    }
    
    /**
     * 测试方入库申请通过
     * @date: 2018年11月23日 上午10:35:35
     * @author: wongwuchiu
     * @param: 审批事件event_id
     * @return: 结果页面
     */
    public function pass_testimport($event_id){
        //Step1:获取审批事件相关信息和前置的开发事件信息
        $event = $this->eventService->getById($event_id);
        $testEvent = $event->Preevent;
        if ($testEvent == null){
            $url = "approver/complist/0/0";
            $msg = "前置测试事件不存在！";
            return view('error', compact("url","msg"));
        }
        $devEvent = $testEvent->Preevent;
        if ($devEvent == null){
            $url = "approver/complist/0/0";
            $msg = "前置开发事件不存在！";
            return view('error', compact("url","msg"));
        }
        //Step2:获取受控库版本，设定好入产品库的相关路径，并将组件文件从临时目录复制到受控库目录并做git操作
        $skVersion = $this->versionService->getById($testEvent->comp_ver);
        $tempPath = $skVersion->file_path;
        $temp_dir = storage_path() . $tempPath;
        $destPath = '/app/upload/ChanPing/' . $event->comp_id . '/' . $event->ver_num . '/';
        $dest_dir = storage_path() . $destPath;
        //Step2.1:检查是否存在组件文件夹，若不存在则新建并建立git仓库(git init)
        $cmdPath = 'cd ' . $dest_dir . ' && ';
        if(!is_dir($dest_dir))
        {
            mkdir ($dest_dir,0777,true);
            $cmdGitInit = 'git init';
            exec($cmdPath . $cmdGitInit,$ret);
        }
        //Step2.2:复制文件并作git处理
        $this->gitcopydir($temp_dir, $dest_dir, $dest_dir);
        //Step2.3:进行git commit
        $msg = '"' . $testEvent->description . '"';
        $cmdGitCom = 'git commit -m';
        exec($cmdPath . $cmdGitCom . $msg, $ret);
        //Step3:设定好测试文档的相关路径，并将测试文档从临时目录复制到测试文档目录下
        $tempTest = $event->testdoc_path;
        $temp_test_dir = storage_path() . $tempTest;
        $destTest = '/app/upload/TestDoc/' . $event->comp_id . '/' . $event->ver_num . '/';
        $dest_test_dir = storage_path() . $destTest;
        $this->copydir($temp_test_dir, $dest_test_dir);
        //Step4:新建产品库版本version信息，记录版本号
        $cpVersion = new Version();
        $cpVersion->type = 1;
        $cpVersion->comp_id = $event->comp_id;
        $cpVersion->ver_num = $event->ver_num;
        $cpVersion->ver_status = 1;
        $cpVersion->event_import = $skVersion->event_import;
        $cpVersion->file_path = $destPath;
        $cpVersion->descdoc_path = $skVersion->descdoc_path;
        $cpVersion->testdoc_path = $destTest;
        $cpId = $this->versionService->appendID($cpVersion);


        /**
         * TODO
         */
//        dd($dest_dir,$event,$cpId,$cpVersion,$temp_test_dir, $dest_test_dir);

        //生成组件文件指纹
        $dest_dir_format = substr($dest_dir,0,-1);
        $file_real = $this->scan_dir($dest_dir_format);
        $filr_fingerprint = $this->apprRecordService->add_fingerprint($file_real);
        Log::info("生成组件文件指纹：".$filr_fingerprint);


        //生成测试文件指纹
        $testDoc_name = glob($dest_test_dir."*")[0];
        $testDoc_fingerprint = $this->apprRecordService->add_fingerprint($testDoc_name);
        Log::info("生成组件文件指纹：".$testDoc_fingerprint);

        $comp_name = Component::select("comp_name")->where("id",$event->comp_id)->get()[0]["comp_name"];
        $verifierId = ApprRecord::select("approver")->where("appr_event",$event->id)->get()[0]["approver"];
        $testId = Event::select("user_id")->where("id",$testEvent->id)->get()[0]["user_id"];
        $developerId = Event::select("user_id")->where("id",$devEvent->id)->get()[0]["user_id"];
        $storage_arr = array(
            "moduleId"=>$event->comp_id,
            "moduleFinger"=>$filr_fingerprint,
            "moduleName"=>$comp_name,
            "productName"=>"产品名",
            "moduleVersion"=>$event->comp_ver,
            "testReportFinger"=>$testDoc_fingerprint,
            "testerId"=>$testId,
            "developerId"=>$developerId,
            "verifierId1"=>$verifierId,
            "verifierId2"=>$verifierId,
            "sore"=>"95"
        );
        $ret = $this->apprRecordService->add_storage($storage_arr);
        Log::info("组件入库结果：".$ret->msg);
        Log::info($ret->code);
//        dd($ret_json);

        /**
         *
         */

        if($cpId == 0){
            $url = "approver/complist/0/0";
            $msg = "新建版本信息错误！";
            return view('error', compact("url","msg"));
        }
        $skVersion->testdoc_path = $destTest;
        $verRet = $this->versionService->update($skVersion);
        if(!$verRet){
            $url = "approver/complist/0/0";
            $msg = "修改版本信息错误！";
            return view('error', compact("url","msg"));
        }        
        //Step5:修改组件Component的最新版本号，修改审批事件和前置入库事件状态
        $component = $this->componentService->getById($event->comp_id);
        $component->latest_ver = $cpId;
        $saveRet = $this->componentService->update($component);
        if(!$saveRet){
            $url = "approver/complist/0/0";
            $msg = "修改组件信息出错！";
            return view('error', compact("url","msg"));
        }
        $apprRet = $this->componentService->apprDone($event->comp_id);
        if(!$apprRet){
            $url = "approver/complist/0/0";
            $msg = "修改组件审批信息出错！";
            return view('error', compact("url","msg"));
        }
        $event->status = 31001;
        $event->has_assigned = 1;
        $saveRet = $this->eventService->update($event);
        if(!$saveRet){
            $url = "approver/complist/0/0";
            $msg = "修改审核事件信息出错！";
            return view('error', compact("url","msg"));
        }
        //Step6:修改测试事件和开发事件信息
        $devEvent->status = 1301;
        $devEvent->testdoc_path = $destTest;
        $devRet = $this->eventService->update($devEvent);
        if(!$devRet){
            $url = "approver/complist/0/0";
            $msg = "修改入库事件信息出错！";
            return view('error', compact("url","msg"));
        }
        $testEvent->status = 2105;
        $testRet = $this->eventService->update($testEvent);
        if(!$testRet){
            $url = "approver/complist/0/0";
            $msg = "修改入库事件信息出错！";
            return view('error', compact("url","msg"));
        }
        //返回组件列表
        $url = "approver/complist/0/0";
        return view('success', compact("url"));
    }

    /**
     * 找到文件夹下第一个文件
     * @param $file_ori
     * @return mixed
     */
    public function scan_dir($file_ori){
        $file_glob = glob($file_ori."/*");
        if(filetype($file_glob[0])=="dir"){
//            var_dump($file_glob[0],"dir");
            return $this->scan_dir($file_glob[0]);
        }else{
//            var_dump($file_glob[0]);
            return $file_glob[0];
        }
    }

    /**
     * 审批不通过，依据类型寻找对应处理方法
     * @date: 2018年11月23日 上午10:27:51
     * @author: wongwuchiu
     * @param: 审批事件类型type，审批事件event_id
     * @return: 各处理方法结果
     */
    public function appr_nopass($event_id,Request $request){
        //Step1:获取审批事件相关信息，并判断是否可推进
        $event = $this->eventService->getById($event_id);
        $pre_id = $event->pre_event;
        $type = $event->type;
        $level = $event->appr_level;
        $compType = $event->Component->comp_type;
        //$nodeId = $this->apprNodeService->getApprNode($compType, $level);
        $nodeId = $event->appr_node;
        $node = $this->apprNodeService->getById($nodeId);
        $currentUser = Auth::user()->id;
        $checkOk = $this->apprGroupService->isInNode($currentUser, $nodeId) && $event->has_assigned == 0;
        if (!$checkOk){
            $url = "approver/complist/0/0";
            $msg = "审批不可允许不通过！";
            return view('error', compact("url","msg"));
        }
        //Step2:获取审批的描述，并记录到审批记录中
        $appr_desc = $request->get("appr_desc");
        $apprRecord = new ApprRecord();
        $apprRecord->appr_event = $event_id;
        $apprRecord->approver = $currentUser;
        $apprRecord->appr_desc = $appr_desc;
        $apprRecord->appr_node = $nodeId;
        $apprRecord->has_passed = 0;
        $saveRet = $this->apprRecordService->append($apprRecord);
        if (!$saveRet){
            $url = "approver/complist/0/0";
            $msg = "审批记录写入失败！";
            return view('error', compact("url","msg"));
        }
        //Step3:修改审批事件
        $event->has_assigned = 1;
        switch ($type){
            case 11000:
                $event->status = 11100;
                break;
            case 12000:
                $event->status = 21100;
                break;
            case 13000:
                $event->status = 31100;
                break;
            default:
                $url = "approver/complist/0/0";
                $msg = "审批不通过通过方法类型出错！";
                return view('error', compact("url","msg"));
                break;
        }
        $apprRet = $this->eventService->update($event);
        if (!$apprRet){
            $url = "approver/complist/0/0";
            $msg = "修改审批事件状态出错！";
            return view('error', compact("url","msg"));
        }
        //Step4:修改组件审批状态
        $compRet = $this->componentService->apprDone($event->comp_id);
        if (!$compRet){
            $url = "approver/complist/0/0";
            $msg = "修改组件审批状态出错！";
            return view('error', compact("url","msg"));
        }
        //Step5:依据审核事件类型终止事件
        switch ($type){
            case 11000:
                return $this->nopass_devimport($pre_id);
                break;
            case 12000:
                return $this->nopass_testexport($pre_id);
                break;
            case 13000:
                return $this->nopass_testimport($pre_id);
                break;
            default:
                $url = "approver/complist/0/0";
                $msg = "审批不通过通过方法类型出错！";
                return view('error', compact("url","msg"));
                break;
        }
    }
    
    /**
    * 开发方审批不通过处理
    * @date: 2018年11月26日 下午2:47:40
    * @author: wongwuchiu
    * @param: 审批事件event_id
    * @return: 
    */
    public function nopass_devimport($event_id){
        //Step1:修改开发方入库事件状态
        $event = $this->eventService->getById($event_id);
        $event->status = 1111;
        $updateRet = $this->eventService->update($event);
        if (!$updateRet){
            $url = "approver/complist/0/0";
            $msg = "修改入库事件状态出错！";
            return view('error', compact("url","msg"));
        }
        //Step2:对应组件入库解锁
        $comp_id = $event->comp_id;
        $devRet = $this->componentService->devUnlock($comp_id);
        if (!$devRet){
            $url = "approver/complist/0/0";
            $msg = "修改组件状态出错！";
            return view('error', compact("url","msg"));
        }
        $url = "approver/complist/0/0";
        return view('success', compact("url","msg"));
    }
    
    /**
     * 测试方出库不通过处理
     * @date: 2018年11月26日 下午2:47:40
     * @author: wongwuchiu
     * @param: 审批事件event_id
     * @return:
     */
    public function nopass_testexport($event_id){
        //Step1:修改测试方出库事件状态，重新开放选取
        $event = $this->eventService->getById($event_id);
        $event->status = 2100;
        $event->has_assigned = 0;
        $updateRet = $this->eventService->update($event);
        if (!$updateRet){
            $url = "approver/complist/0/0";
            $msg = "修改入库事件状态出错！";
            return view('error', compact("url","msg"));
        }
        //Step2:新增一条测试事件动态
        $comp_id = $event->comp_id;
        $testRet = $this->componentService->testNew($comp_id);
        if (!$testRet){
            $url = "approver/complist/0/0";
            $msg = "修改组件状态出错！";
            return view('error', compact("url","msg"));
        }
        $url = "approver/complist/0/0";
        return view('success', compact("url","msg"));
    }
    
    /**
     * 测试方入库不通过处理
     * @date: 2018年11月26日 下午2:47:40
     * @author: wongwuchiu
     * @param: 审批事件event_id
     * @return:
     */
    public function nopass_testimport($event_id){
        //Step1:修改测试方入库事件状态，让其重新提交测试报告
        $event = $this->eventService->getById($event_id);
        $event->status = 2111;
        $updateRet = $this->eventService->update($event);
        if (!$updateRet){
            $url = "approver/complist/0/0";
            $msg = "修改测试事件状态出错！";
            return view('error', compact("url","msg"));
        }
        $url = "approver/complist/0/0";
        return view('success', compact("url","msg"));
    }
    
    /**
    * 复制文件夹
    * @date: 2018年11月23日 下午3:26:10
    * @author: wongwuchiu
    * @param: 源路径$source，目的路径$dest
    * @return: null
    */
    function copydir($source, $dest)
    {
        if (!file_exists($dest)) mkdir($dest,0777,true);
        $handle = opendir($source);
        while (($item = readdir($handle)) !== false) {
            if ($item == '.' || $item == '..') continue;
            $_source = $source . '/' . $item;
            $_dest = $dest . '/' . $item;
            if (is_file($_source)) copy($_source, $_dest);
            if (is_dir($_source)) $this->copydir($_source, $_dest);
        }
        closedir($handle);
    }
    
    /**
    * 带git的复制文件夹
    * @date: 2018年11月28日 下午4:04:24
    * @author: wongwuchiu
    * @param: 源路径$source，目的路径$dest
    * @return: 
    */
    function gitcopydir($source, $dest, $dest_dir)
    {
        if (!file_exists($dest)) mkdir($dest,0777,true);
        $handle = opendir($source);
        while (($item = readdir($handle)) !== false) {
            if ($item == '.' || $item == '..') continue;
            $_source = $source . '/' . $item;
            $_dest = $dest . '/' . $item;
            if (is_file($_source)){
                copy($_source, $_dest);
                $cmdGitAdd = 'git add ';
                $cmd = 'cd ' . $dest_dir . ' && ' . $cmdGitAdd . $_dest;
//                 echo "cmd:" . $cmd . "<br>";
                exec($cmd,$ret);
            }
            if (is_dir($_source) && $item != '.git'){
                $this->gitcopydir($_source, $_dest, $dest_dir);
            }
            
        }
        closedir($handle);
    }
    
    public function appr_getcomps()
    {
        $test = array();
        $select_group = $_POST['group_val'];
        $select_type = $_POST['comp_val'];
        $currentPage = $_POST['page'];
        $user = Auth::user();
        $mComponents = $this->getCompsList($select_type, $select_group);
//         if ($this->isAdmin()){
//             if($select_type != 0 && $select_group != 0){
//                 $mComponents = $this->componentService->getAll()->where('comp_type',$select_type)->where('group_id',$select_group);
//             } else if($select_type != 0 && $select_group == 0){
//                 $mComponents = $this->componentService->getAll()->where('comp_type',$select_type);
//             } else if($select_group != 0 && $select_type == 0){
//                 $mComponents = $this->componentService->getAll()->where('group_id',$select_group);
//             } else {
//                 $mComponents = $this->componentService->getAll();
//             }
//         } else {
//             if($select_type != 0 && $select_group != 0){
//                 $mComponents = $user->Component->where('comp_type',$select_type)->where('group_id',$select_group);
//             } else if($select_type != 0 && $select_group == 0){
//                 $mComponents = $user->Component->where('comp_type',$select_type);
//             } else if($select_group != 0 && $select_type == 0){
//                 $mComponents = $user->Component->where('group_id',$select_group);
//             } else {
//                 $mComponents = $user->Component;
//             }
//         }
        $perPage = 15;
        $offset = ($currentPage - 1) * $perPage;
        $total = $mComponents->count();
//         $results = $mComponents->sortByDesc("appr_status")->sortByDesc("appr_updated")->forPage($currentPage, $perPage);
        $results = $mComponents->forPage($currentPage, $perPage);
        $test = [];
        foreach ($results as $result)
        {
            $result->comp_desc = str_limit($result->comp_desc ,100,"...");
            $result->comp_type = config("app.comp_type")[$result->comp_type];
//             $result->group_name = $result->group->group_name;
            $result->group_name = $this->groupService->getById($result->group_id)->group_name;
            $comp_id = $result->id;
            if(!$this->isAdmin() && !$this->checkHasEvent($comp_id)){
                $result->appr_status = 10000;
            }
            $str = config("app.comp_status")[$result->appr_status];
            if($result->appr_status == 10001){
                $result->status_str = '<font color="#FF0000">' . $str . '</font>';
            } else {
                $result->status_str = $str;
            }
            $url = asset('/apprvoer/requestlist') . '/' . $result->id;
            $result->url = $url;
            $test[]= $result;
        }
        echo json_encode($test);
//         echo "1";
        
    }
    
    public function checkNextStep($comp_id,$node_id){
        $compUsers = $this->compAuthorityService->getAuthUsers($comp_id);
        $nodeUsers = $this->apprGroupService->getNodeUsers($node_id);
        $jiaoji = array_intersect($compUsers, $nodeUsers);  //取两者交集
        if(count($jiaoji) == 0 || $jiaoji == null){
//             echo "no";
            return false;
        } else {
//             echo "yes";
            return true;
        }
        
    }
    
    /**
     * 判断是否是管理员
     * @date: 2018年11月21日 下午4:52:00
     * @author: wongwuchiu
     * @param: null
     * @return: 是否是管理员
     */
    public function isAdmin()
    {
        if (Auth::check()) {
            return Auth::user()->admin || config('app.admin_mode', false);
        } else {
            return false;
        }
    }
}
