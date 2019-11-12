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
use App\Http\Controllers\DownloadController;
use App\Models\Group;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\GroupService;
use App\Services\UserService;
use App\Services\EventService;
use App\Services\CompAuthorityService;
use App\Services\ComponentService;
use App\Services\ApprNodeService;
use App\Services\ApprGroupService;
use App\Models\Component;
use Illuminate\Support\Facades\Auth;
use Chumper\Zipper\Zipper;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;



class TesterController extends BaseController
{
    
    function __construct(ApprGroupService $apprGroupService,ApprNodeService $apprNodeService,GroupService $groupService,ComponentService $componentService, EventService $eventService, CompAuthorityService $compAuthorityService, UserService $userService)
    {
        $this->middleware('auth');
        $this->groupService = $groupService;
        $this->compAuthorityService = $compAuthorityService;
        $this->userService = $userService;
        $this->eventService = $eventService;
        $this->componentService = $componentService;
        $this->apprNodeService = $apprNodeService;
        $this->apprGroupService = $apprGroupService;
        // 此时的的 $this->userService相当于实例化了服务容器：UserService
    }
    
    public function test_complist($select_type,$select_group,Request $request)
    {
//         $user = Auth::user();
//         $components = $user->Component;
//         return view('tester/complist', compact('components'));
        $user = Auth::user();
        $mComponents = null;
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
        $mComponents = $this->getCompsList($select_type, $select_group);
//         $mComponents = $user->Component;
        $perPage = 15;
        
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mComponents->count();
//         $result = $mComponents->sortByDesc("test_status")->sortByDesc("test_updated")->forPage($currentPage, $perPage);
        $results = $mComponents->forPage($currentPage, $perPage);
        foreach ($results as $result)
        {
            $result->group_name = $this->groupService->getById($result->group_id)->group_name;
        }
        $components= new LengthAwarePaginator($results,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return view('tester/complist', compact('components','select_type','select_group','groups'));
    }
    
    public function getCompsList($select_type,$select_group){
        $user = Auth::user();
        $mComponents = null;
        if ($this->isAdmin()){
            if($select_type != 0 && $select_group != 0){
                $mComponents = Component::where('comp_type',$select_type)->where('group_id',$select_group)->orderBy('test_status', 'desc')
                ->orderBy('test_updated', 'asc')->get();
            } else if($select_type != 0 && $select_group == 0){
                $mComponents = Component::where('comp_type',$select_type)->orderBy('test_status', 'desc')
                ->orderBy('test_updated', 'asc')->get();
            } else if($select_group != 0 && $select_type == 0){
                $mComponents = Component::where('group_id',$select_group)->orderBy('test_status', 'desc')
                ->orderBy('test_updated', 'asc')->get();
            } else {
                $mComponents = Component::orderBy('test_status', 'desc')
                ->orderBy('test_updated', 'asc')->get();
            }
        } else {
            if($select_type != 0 && $select_group != 0){
                $mComponents = DB::table('compauthority')
                ->where('user_id',$user->id)
                ->leftJoin('component', 'compauthority.comp_id', '=', 'component.id')
                ->select('component.*')
                ->where('component.comp_type',$select_type)
                ->where('component.group_id',$select_group)
                ->orderBy('component.test_status', 'desc')
                ->orderBy('component.test_updated', 'asc')
                ->get();
            } else if($select_type != 0 && $select_group == 0){
                $mComponents = DB::table('compauthority')
                ->where('user_id',$user->id)
                ->leftJoin('component', 'compauthority.comp_id', '=', 'component.id')
                ->select('component.*')
                ->where('component.comp_type',$select_type)
                ->orderBy('component.test_status', 'desc')
                ->orderBy('component.test_updated', 'asc')
                ->get();
            } else if($select_group != 0 && $select_type == 0){
                $mComponents = DB::table('compauthority')
                ->where('user_id',$user->id)
                ->leftJoin('component', 'compauthority.comp_id', '=', 'component.id')
                ->select('component.*')
                ->where('component.group_id',$select_group)
                ->orderBy('component.test_status', 'desc')
                ->orderBy('component.test_updated', 'asc')
                ->get();
            } else {
                $mComponents = DB::table('compauthority')
                ->where('user_id',$user->id)
                ->leftJoin('component', 'compauthority.comp_id', '=', 'component.id')
                ->select('component.*')
                ->orderBy('component.test_status', 'desc')
                ->orderBy('component.test_updated', 'asc')
                ->get();
            }
        }
        return $mComponents;
    }
    
    
    /**
    * 测试通过，打开申请入产品库界面
    * @date: 2018年11月26日 上午10:40:01
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function test_import($event_id)
    {
        $event = $this->eventService->getById($event_id);
        if ($event == null){
            $url = "tester/complist/0/0";
            $msg = "获取测试事件出错！";
            return view('error', compact("url","msg"));
        }
        return view('tester/import',compact("event"));
    }
    
    /**
    * 申请入产品库的数处理
    * @date: 2018年11月26日 上午10:43:47
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function test_import_do($event_id,Request $request)
    {
        //Step1:从request中获取上传的描述和测试文档
        $currentUser = Auth::user()->id;
        $importDesc = $request->get('import_desc');
        $testDoc = $request->file('testdoc');
        $event = $this->eventService->getById($event_id);
        $component = $this->componentService->getById($event->comp_id);
        $comp_type = $component->comp_type;
        $apprNode = $this->apprNodeService->getFirstActiveNode($comp_type);
        //Step2:处理上传的文件
        $time = time();
        $fileName = $testDoc->getClientOriginalName();
        $tempPath = '/app/upload/temp/testdoc/' . $event->comp_id . '/' . $event->ver_num . '_' . $time . '/';
        $testDoc->move(storage_path() . $tempPath, $fileName);
        //Step3:新建审批事件
        $apprEvent = new Event();
        $apprEvent->type = 13000;
        $apprEvent->user_id = 0;
        $apprEvent->description = $importDesc;
        $apprEvent->comp_id = $event->comp_id;
        $apprEvent->comp_ver = 0;
        $apprEvent->ver_num = $event->ver_num;
        $apprEvent->status = 31000;
        //2-25:新增推进判断
        if(!$this->checkNextStep($event->comp_id, $apprNode)){
            $apprEvent->status = 31101;
        }
        $apprEvent->has_assigned = 0;
        $apprEvent->file_path = null;
        $apprEvent->descdoc_path = null;
        $apprEvent->testdoc_path = $tempPath;
        $apprEvent->pre_event = $event_id;
        $apprEvent->appr_level = 1;
        //1.18:添加当前审批节点
        $apprEvent->appr_node = $apprNode;
        $retAppr = $this->eventService->append($apprEvent);
        if (!$retAppr){
            $url = 'tester/complist/0/0';
            $msg = '新增审批事件出错!';
            return view('error', compact("url","msg"));
        }
        //Step4:修改组件的审批状态
        $apprRet = $this->componentService->apprNew($event->comp_id);
        if (!$apprRet){
            $url = 'tester/complist/0/0';
            $msg = '修改组件状态出错!';
            return view('error', compact("url","msg"));
        }
        //Step5:修改前置入库事件的状态
        $devEvent = $event->Preevent;
        if($devEvent == null){
            $url = 'tester/complist/0/0';
            $msg = '获取开发方前置事件出错!';
            return view('error', compact("url","msg"));
        }
        $devEvent->status = 1201;
        $devEvent->testdoc_path = $tempPath;
        $devRet = $this->eventService->update($devEvent);
        if (!$devRet){
            $url = 'tester/complist/0/0';
            $msg = '修改开发方前置事件出错!';
            return view('error', compact("url","msg"));
        }
        //Step6:修改测试事件状态
        $event->status = 2104;
        $testRet = $this->eventService->update($event);
        if (!$testRet){
            $url = 'tester/complist/0/0';
            $msg = '修改测试事件出错!';
            return view('error', compact("url","msg"));
        }
        $url = 'tester/complist/0/0';
        return view('success', compact("url","msg"));
    }
    
    
    /**
    * 展示用户相关的事件列表
    * @date: 2018年11月26日 上午10:40:36
    * @author: wongwuchiu
    * @param: Http的Request
    * @return: 用户相关事件页面
    */
    public function test_eventlist(Request $request)
    {
        $currentUser = Auth::user()->id;
        $events = $this->eventService->getByTesterPage($currentUser, 15, $request);
        return view('tester/eventlist',compact('events'));
    }
    
    /**
     * 获取用户相关的事件列表
     * @date: 2018年11月26日 上午10:40:36
     * @author: wongwuchiu
     * @param: Http的Request
     * @return:
     */
    public function test_versionlist($comp_id, Request $request)
    {
        $events = $this->eventService->getByTestPage($comp_id, 15, $request);
        return view('tester/versionlist',compact("events"));
    }
    
    /**
    * 下载文件
    * @date: 2018年11月25日 下午8:57:18
    * @author: wongwuchiu
    * @param: 测试事件event_id
    * @return: 
    */
    public function test_download($event_id){
        //Step1:获取测试事件信息，并判断当前用户是否有权下载
        $event = $this->eventService->getById($event_id);
        if ($event == null){
            $url = "tester/complist/0";
            $msg = "获取测试事件出错！";
            return view('error', compact("url","msg"));
        }
        $user_id = Auth::user()->id;
        $comp_id = $event->comp_id;
        $ret = $this->compAuthorityService->checkAuthority($user_id, $comp_id);
        if (!$ret || ($event->status != 2102 && $event->status != 2111)){
            $url = "tester/complist/0";
            $msg = "没有权限下载组件！";
            return view('error', compact("url","msg"));
        }
        //Step2:修改测试事件信息
        $event->status = 2103;
        $updateRet = $this->eventService->update($event);
        if (!$updateRet){
            $url = "tester/complist/0";
            $msg = "修改事件状态出错！";
            return view('error', compact("url","msg"));
        }
        //Step3:修改前置入库事件信息
        $devEvent = $event->Preevent;
        $devEvent->status = 1200;
        $devRet = $this->eventService->update($devEvent);
        if (!$devRet){
            $url = "approver/complist";
            $msg = "修改开发入库事件状态出错！";
            return view('error', compact("url","msg"));
        }
        //Step4:从测试事件获取组件文件和描述文件的路径位置
        $time = time();
        $zipName = $event->ver_num . '_' . $time . '.zip';
        $filePath = storage_path() . $event->file_path;
        $descPath = storage_path() . $event->descdoc_path;
        //Step5:将组件文件和器描述文档打包并进行下载
        $zipper=new Zipper();
        $tempPath = storage_path() . '/app/temp/';
        $zipPath = $tempPath . $zipName;
        $zipper->make($zipPath)->add($filePath)->add($descPath);
        $zipper->close();
        return response()->download($zipPath);
    }
    
    /**
     * 进入测试组件页面
     * @date: 2018年11月22日 上午10:49:02
     * @author: wongwuchiu
     * @param: variable
     * @return:
     */
    public function test_info($event_id)
    {
        //Step1:获取当前审批事件ID，以及前置事件信息
        $event = $this->eventService->getById($event_id);
        $preevent_id = $event->pre_event;
        $preevent = $this->eventService->getById($preevent_id);
        return view('tester/info',compact("event","preevent"));
    }
    
    /**
     * 申请测试界面
     * @date: 2018年11月22日 上午10:49:02
     * @author: wongwuchiu
     * @param: variable
     * @return:
     */
    public function test_request($event_id)
    {
        //Step1:获取当前审批事件ID，以及前置事件信息
        $event = $this->eventService->getById($event_id);
//         dd($event_id);
        $preevent_id = $event->pre_event;
        $preevent = $this->eventService->getById($preevent_id);
        return view('tester/request',compact("event","preevent"));
    }
    
    /**
     * 申请测试数据处理
     * @date: 2018年11月22日 上午10:49:02
     * @author: wongwuchiu
     * @param: variable
     * @return:
     */
    public function test_request_do($event_id,Request $request)
    {
        //Step1:从request中获取post的信息
        $test_desc = $request->get("test_desc");
        //Step2:修改现有的测试事件，设置为已分配和新的描述
        $event = $this->eventService->getById($event_id);
        if ($event == null){
            $url = "tester/complist/0";
            $msg = "测试事件不存在！";
            return view('error', compact("url","msg"));
        }
        $comp_id = $event->comp_id;
        $component = $this->componentService->getById($comp_id);
        $comp_type = $component->comp_type;
        $apprNode = $this->apprNodeService->getFirstActiveNode($comp_type);
        if ($event->has_assigned == 1){
            $url = "tester/complist/0";
            $msg = "测试事件已分配！";
            return view('error', compact("url","msg"));
        }
        $event->user_id = Auth::user()->id;
        $event->description = $test_desc;
        $event->has_assigned = 1;
        $event->status = 2101;
        $updateRet = $this->eventService->update($event);
        if (!$updateRet){
            $url = "tester/complist/0";
            $msg = "修改测试事件出错！";
            return view('error', compact("url","msg"));
        }
        //Step3:修改组件状态
        $testerRet = $this->componentService->testDone($comp_id);
        if (!$testerRet){
            $url = "tester/complist/0";
            $msg = "修改组件测试状态出错！";
            return view('error', compact("url","msg"));
        }
        //Step4:新增审核出库事件
        $apprEvent = new Event();
        $apprEvent->type = 12000;
        $apprEvent->user_id = 0;
        $apprEvent->description = $test_desc;
        $apprEvent->comp_id = $comp_id;
        $apprEvent->comp_ver = 0;
        $apprEvent->ver_num = $event->ver_num;
        $apprEvent->status = 21000;
        //2-25:新增推进判断
        if(!$this->checkNextStep($comp_id, $apprNode)){
            $apprEvent->status = 21101;
        }
        $apprEvent->has_assigned = 0;
        $apprEvent->file_path = null;
        $apprEvent->descdoc_path = null;
        $apprEvent->testdoc_path = null;
        $apprEvent->pre_event = $event_id;
        $apprEvent->appr_level = 1;
        //1.18：添加当前审批节点
        $apprEvent->appr_node = $apprNode;
        $retAppr = $this->eventService->append($apprEvent);
        if (!$retAppr){
            $url = 'tester/complist/0/0';
            $msg = '新增审批事件出错!';
            return view('error', compact("url","msg"));
        }
        //Step5:修改组件审核状态
        $apprRet = $this->componentService->apprNew($comp_id);
        if (!$apprRet){
            $url = 'tester/complist/0/0';
            $msg = '修改组件审批状态出错!';
            return view('error', compact("url","msg"));
        }
        $url = 'tester/complist/0/0';
        return view('success', compact("url"));
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