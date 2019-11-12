<?php
/**
 * 处理开发方相关操作
 * @date: 2018年11月19日 下午7:55:52
 * @author: wongwuchiu
 */
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\View;
use App\Models\Group;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\GroupService;
use App\Services\ApprGroupService;
use App\Services\UserService;
use App\Services\CompAuthorityService;
use App\Services\ComponentService;
use App\Services\EventService;
use App\Services\ApprNodeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Requests;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;


class DeveloperController extends BaseController
{

    function __construct(ApprGroupService $apprGroupService,ApprNodeService $apprNodeService,GroupService $groupService,EventService $eventService,CompAuthorityService $compAuthorityService, UserService $userService, ComponentService $componentService)
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
    
    /**
    * 显示开发人员相关事件的状态
    * @date: 2018年11月21日 下午4:50:06
    * @author: wongwuchiu
    * @param: null
    * @return: 进入相关事件页面
    */
    public function dev_eventlist(Request $request)
    {
        $currentUser = Auth::user()->id;
        $events = $this->eventService->getByDevPage($currentUser, 15, $request);
        if ($request->get("test") != null) 
        {
            $event = json_decode($request->get("event"));
            $destPath = '/app/upload/ShouKong/' . $event->comp_id . '/' . $event->ver_num . '/';
            $descPath = '/app/upload/DescDoc/' . $event->comp_id . '/' . $event->ver_num . '/';
            $testEvent = new Event();
            $testEvent->type = 2000;
            $testEvent->user_id = 0;
            $testEvent->description = null;
            $testEvent->comp_id = $event->comp_id;
            $testEvent->comp_ver = $event->comp_ver;
            $testEvent->ver_num = $event->ver_num;
            $testEvent->status = 2100;
            $testEvent->has_assigned = 0;
            $testEvent->file_path = $destPath;
            $testEvent->descdoc_path = $descPath;
            $testEvent->testdoc_path = null;
            $testEvent->pre_event = $event->id;
            $testEvent->appr_level = 0;
            //1.18：添加当前审批节点信息
            $testEvent->appr_node = 0;
            $testID = $this->eventService->appendID($testEvent);
            if ($testID == 0){
                $url = 'approver/complist/0';
                $msg = '新增测试方测试版本事件出错!';
                return view('error', compact("url","msg"));
            }
            $testRet = $this->componentService->testNew($event->comp_id);
            if(!$testRet){
                $url = "approver/complist/0";
                $msg = "修改组件审批信息出错！";
                return view('error', compact("url","msg"));
            }
            //新增测试事件后修改前驱事件的状态为测试申请成功
            $preEvent = $this->eventService->getById($event->id);
            $preEvent->status = 1102;
            $updateRet = $this->eventService->update($preEvent);            
        }
        
        return view('developer/eventlist',compact('events'));
    }

    /**
    * 显示开发人员可以入库的组件
    * @date: 2018年11月21日 下午4:50:48
    * @author: wongwuchiu
    * @param: null
    * @return: 进入有权限访问的组件的列表页面
    */
    public function dev_complist($select_type,$select_group,$import_status,Request $request)
    {
//         $currentUser = Auth::user();
//         $components = $currentUser->Component;
//         return view('developer/complist', compact('components'));
        $user = Auth::user();
        $mComponents = null;
        $groups = $this->groupService->getAll();
        if ($this->isAdmin()){
            if($select_type != 0 && $select_group != 0){
                $mComponents = $this->componentService->getAll()->where('comp_type',$select_type)->where('group_id',$select_group)->where('dev_import',$import_status);
            } else if($select_type != 0 && $select_group == 0){
                $mComponents = $this->componentService->getAll()->where('comp_type',$select_type)->where('dev_import',$import_status);
            } else if($select_group != 0 && $select_type == 0){
                $mComponents = $this->componentService->getAll()->where('group_id',$select_group)->where('dev_import',$import_status);
            } else {
                $mComponents = $this->componentService->getAll()->where('dev_import',$import_status);
            }
        } else {
            if($select_type != 0 && $select_group != 0){
                $mComponents = $user->Component->where('comp_type',$select_type)->where('group_id',$select_group)->where('dev_import',$import_status);
            } else if($select_type != 0 && $select_group == 0){
                $mComponents = $user->Component->where('comp_type',$select_type)->where('dev_import',$import_status);
            } else if($select_group != 0 && $select_type == 0){
                $mComponents = $user->Component->where('group_id',$select_group)->where('dev_import',$import_status);
            } else {
                $mComponents = $user->Component->where('dev_import',$import_status);
            }
        }
//         $mComponents = $user->Component;
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mComponents->count();
        $result = $mComponents->sortByDesc("dev_import")->forPage($currentPage, $perPage);
        $components= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
//         dd($components);
        return view('developer/complist', compact('components','groups','select_type','select_group','import_status'));
    }
    
    /**
    * 显示开发人员上传入库界面
    * @date: 2018年11月21日 下午4:51:13
    * @author: wongwuchiu
    * @param: 入库组件的id
    * @return: 进入组件入库页面
    */
    public function dev_import($comp_id)
    {
        $component = $this->componentService->getById($comp_id);
        $latestVer = $component->latest_vernum;
        $verNums = explode(".", $latestVer);
        $verCount = count($verNums);
        $num1 = 1;
        $num2 = 0;
        $num3 = 0;
        if ($verCount == 3){
            $num1 = ((int)$verNums[0]);
            $num2 = ((int)$verNums[1]);
            $num3 = ((int)$verNums[2]);
        }
        return view('developer/import',compact('component','num1','num2','num3'));
    }
    
    /**
    * 开发方上传数据处理
    * @date: 2018年11月21日 下午4:55:28
    * @author: wongwuchiu
    * @param: 入库的组件$comp_id,http的Request
    * @return: 
    */
    public function dev_import_do($comp_id,Request $request){
        //Step1:从request和组件中获取信息
        $currentUser = Auth::user()->id;
        $version_input = $request->get('version_input');
        $importFile = $request->file('doc_form_file');
        $description = $request->get('description');
        $relative_path = $request->get('relative_path');
        $descFile = $request->file('descdoc');
        $component = $this->componentService->getById($comp_id);
        $comp_type = $component->comp_type;
        //Step2:接受上传的文件夹至本地
        $tempComp = '/app/upload/temp/component/' . $comp_id . '/' . $version_input . '/';
        $tempDesc = '/app/upload/temp/descdoc/' . $comp_id . '/' . $version_input . '/';
        $path_array = explode("#$#", $relative_path);
        $idx = 0;
        foreach ($importFile as $key => $value) {
            // 判断文件上传中是否出错
            if (!$value->isValid()) {
                exit("上传文件出错，请重试！");
            }
            if(!empty($value)){
                //此处防止没有多文件上传的情况
                //$extension = $value->getClientOriginalExtension();   // 上传文件后缀
                $fileName = $value->getClientOriginalName();
                //移动上传文件至目录下
                $mpath = $path_array[$idx];
                $pos= strrpos($mpath,"/");
                $dir = substr($mpath,0,$pos + 1);
                $value->move(storage_path() . $tempComp . $dir, $fileName);
                $idx++;
            }
        }
        $dFileName = $descFile->getClientOriginalName();
        $descFile->move(storage_path() . $tempDesc, $dFileName);
        //Step3:对上传的文件做检验，检验通过继续入库，否则跳转至错误页面
        if (!$this->dev_check($tempComp)){
            $url = 'developer/complist/0/0/1001';
            $msg = '上传文件检验未通过!';
            return view('error', compact("url","msg"));
        }
        //Step4:向event写入开发方入库事件
        $devEvent = new Event();
        $devEvent->type = 1000;
        $devEvent->user_id = $currentUser;
        $devEvent->description = $description;
        $devEvent->comp_id = $comp_id;
        $devEvent->comp_ver = 0;
        $devEvent->ver_num = $version_input;
        $devEvent->status = 1100;
        $devEvent->has_assigned = 1;
        $devEvent->file_path = $tempComp;
        $devEvent->descdoc_path = $tempDesc;
        $devEvent->testdoc_path = null;
        $devEvent->pre_event = 0;
        $devEvent->appr_level = 0;
        $devEvent->appr_node = 0;
        $devID = $this->eventService->appendID($devEvent);
        if ($devID == 0){
            $url = 'developer/complist/0/0/1001';
            $msg = '新增开发方上传事件出错!';
            return view('error', compact("url","msg"));
        }
        //Step5:向event写入机关审批开发方入库事件
        $appr_node = $this->apprNodeService->getFirstActiveNode($comp_type);
        $apprEvent = new Event();
        $apprEvent->type = 11000;
        $apprEvent->user_id = 0;
        $apprEvent->description = $description;
        $apprEvent->comp_id = $comp_id;
        $apprEvent->comp_ver = 0;
        $apprEvent->ver_num = $version_input;
        $apprEvent->status = 11000;
        //2-25:新增推进判断
        if(!$this->checkNextStep($comp_id, $appr_node)){
            $apprEvent->status = 11101;
        }
        $apprEvent->has_assigned = 0;
        $apprEvent->file_path = $tempComp;
        $apprEvent->descdoc_path = $tempDesc;
        $apprEvent->testdoc_path = null;
        $apprEvent->pre_event = $devID;
        $apprEvent->appr_level = 1;
        //1.18：添加当前审批节点信息
        $apprEvent->appr_node = $appr_node;
        $retAppr = $this->eventService->append($apprEvent);
        if (!$retAppr){
            $url = 'developer/complist/0/0/1001';
            $msg = '新增审批事件出错!';
            return view('error', compact("url","msg"));
        }
        //Step6:修改组件状态compstatus，禁止入库+组件提醒有新审核事件
        $upDev = $this->componentService->devLock($comp_id);
        $upAppr = $this->componentService->apprNew($comp_id);
        if ($upDev && $upAppr){
            $url = 'developer/complist/0/0/1001';
            return view('success', compact("url"));
        } else {
            $url = 'developer/complist/0/0/1001';
            $msg = '更新组件状态出错!';
            return view('error', compact("url","msg"));
        }
    }
    
    /**
    * 文件检验函数
    * @date: 2018年11月21日 下午5:22:12
    * @author: wongwuchiu
    * @param: 暂存文件夹路径$dir
    * @return: 检验结果$ret
    */
    public function dev_check($dir){
        //暂无接口，恒返回真
        return true;
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

    /**
    * 为入库事件新增测试
    * @date: 2019年1月18日 下午9:34:52
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function dev_addtest($event_id){
        $event = $this->eventService->getById($event_id);
        $destPath = '/app/upload/ShouKong/' . $event->comp_id . '/' . $event->ver_num . '/';
        $descPath = '/app/upload/DescDoc/' . $event->comp_id . '/' . $event->ver_num . '/';
        $testEvent = new Event();
        $testEvent->type = 2000;
        $testEvent->user_id = 0;
        $testEvent->description = null;
        $testEvent->comp_id = $event->comp_id;
        $testEvent->comp_ver = $event->comp_ver;
        $testEvent->ver_num = $event->ver_num;
        $testEvent->status = 2100;
        $testEvent->has_assigned = 0;
        $testEvent->file_path = $destPath;
        $testEvent->descdoc_path = $descPath;
        $testEvent->testdoc_path = null;
        $testEvent->pre_event = $event->id;
        $testEvent->appr_level = 0;
        //1.18：添加当前审批节点信息
        $testEvent->appr_node = 0;
        $testID = $this->eventService->appendID($testEvent);
        if ($testID == 0){
            $url = 'developer/eventlist';
            $msg = '新增测试方测试版本事件出错!';
            return view('error', compact("url","msg"));
        }
        $testRet = $this->componentService->testNew($event->comp_id);
        if(!$testRet){
            $url = "developer/eventlist";
            $msg = "修改组件测试信息出错！";
            return view('error', compact("url","msg"));
        }
        //新增测试事件后修改前驱事件的状态为测试申请成功
        $event->status = 1102;
        $updateRet = $this->eventService->update($event);
        $url = "developer/eventlist";
        if(!$testRet){
            $msg = "修改入库事件状态出错！";
            return view('error', compact("url","msg"));
        } else {
            return view('success', compact("url"));
        }
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
}
