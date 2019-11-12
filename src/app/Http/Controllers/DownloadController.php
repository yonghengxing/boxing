<?php
/**
 * User: shoubin@iscas.ac.cn
 * Date: 2018/10/14
 * Time: 17:17
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\View;

use App\Services\EventService;
use App\Services\ApprGroupService;
use App\Services\ApprNodeService;
use App\Services\IssueService;
use App\Services\CompAuthorityService;

use Illuminate\Http\Request;
use Chumper\Zipper\Zipper;

use App\User;
use Carbon\Carbon;
use Log;
use Illuminate\Support\Facades\Auth;

class DownloadController extends BaseController
{
    
    function __construct(IssueService $issueService,CompAuthorityService $compAuthorityService, ApprNodeService $apprNodeService, EventService $eventService, ApprGroupService $apprGroupService){
        //$this->userService = $userService;
        $this->middleware('auth');
        $this->eventService = $eventService;
        $this->issueService = $issueService;
        $this->apprNodeService = $apprNodeService;
        $this->apprGroupService = $apprGroupService;
        $this->compAuthorityService = $compAuthorityService;
        //此时的的 $this->userService相当于实例化了服务容器：UserService
    }
    
    /**
    * 机关下载开发方上传的组件文件
    * @date: 2018年11月23日 上午10:01:05
    * @author: wongwuchiu
    * @param: 审批事件event_id
    * @return: 下载上传的组件文件
    */
    public function downloadApprFile($event_id){
        $event = $this->eventService->getById($event_id);
        $level = $event->appr_level;
        $compType = $event->Component->comp_type;
        //1.18修改下载判断使用事件的审批节点
        //$nodeId = $this->apprNodeService->getApprNode($compType, $level);
        $nodeId = $event->appr_node;
        $filePath = storage_path() . $event->file_path;
        $time = time();
        $zipName = $event->ver_num . '_' . $time . '.zip';
        $hasAuth = $this->apprGroupService->isInNode(Auth::user()->id, $nodeId) || $this->isAdmin();
        $rightStatus = $event->status == 11000 || $event->status == 11101;
        if ($hasAuth && $rightStatus){
            return $this->downloadByPath($zipName, $filePath);
        } else {
            $url = "approver/complist/0/0";
            $msg = "没有权限下载！";
            return view('error', compact("url","msg"));
        }
    }
    
    /**
     * 机关下载开发方上传的描述文件
     * @date: 2018年11月23日 上午10:01:05
     * @author: wongwuchiu
     * @param: 审批事件event_id
     * @return: 下载上传的组件文件
     */
    public function downloadApprDesc($event_id){
        $event = $this->eventService->getById($event_id);
        $level = $event->appr_level;
        $compType = $event->Component->comp_type;
        //1.18修改下载判断使用事件的审批节点
        //$nodeId = $this->apprNodeService->getApprNode($compType, $level);
        $nodeId = $event->appr_node;
        $filePath = storage_path() . $event->descdoc_path;
        $time = time();
        $zipName = $event->ver_num . '_' . $time . '.zip';
        $hasAuth = $this->apprGroupService->isInNode(Auth::user()->id, $nodeId) || $this->isAdmin();
        $rightStatus = $event->status == 11000 || $event->status == 11101;
        if ($hasAuth && $rightStatus){
            return $this->downloadByPath($zipName, $filePath);
        } else {
            $url = "approver/complist/0/0";
            $msg = "没有权限下载！";
            return view('error', compact("url","msg"));
        }
    }
    
    /**
     * 机关下载测试方上传的测试报告
     * @date: 2018年11月23日 上午10:01:05
     * @author: wongwuchiu
     * @param: 审批事件event_id
     * @return: 下载上传的测试报告
     */
    public function downloadApprTest($event_id){
        $event = $this->eventService->getById($event_id);
        $level = $event->appr_level;
        $compType = $event->Component->comp_type;
        //1.18修改下载判断使用事件的审批节点
        //$nodeId = $this->apprNodeService->getApprNode($compType, $level);
        $nodeId = $event->appr_node;
        $filePath = storage_path() . $event->testdoc_path;
        $time = time();
        $zipName = $event->ver_num . '_' . $time . '.zip';
        $hasAuth = $this->apprGroupService->isInNode(Auth::user()->id, $nodeId) || $this->isAdmin();
        $rightStatus = $event->status == 31000 || $event->status == 31101;
        if ($hasAuth && $rightStatus){
            return $this->downloadByPath($zipName, $filePath);
        } else {
            $url = "approver/complist/0/0";
            $msg = "没有权限下载！";
            return view('error', compact("url","msg"));
        }
    }
    
    /**
    * 测试方下载文件
    * @date: 2018年11月25日 下午8:09:46
    * @author: wongwuchiu
    * @param: 事件主键event_id
    * @return: 下载打包好的组件文件和描述文档
    */
    public function downloadByTester($event_id){
        $event = $this->eventService->getById($event_id);
        $user_id = Auth::user()->id;
        $comp_id = $event->comp_id;
        $ret = $this->compAuthorityService->checkAuthority($user_id, $comp_id);
        if (!$ret || $event->status != 2102){
            $url = "tester/complist/0/0";
            $msg = "没有权限下载组件！";
            return view('error', compact("url","msg"));
        }
        $zipName = $event->ver_num . '_' . $time . '.zip';
        $filePath = $event->file_path;
        $descPath = $event->descdoc_path;
        $zipper=new Zipper();
        $tempPath = storage_path() . '/app/temp/';
        $zipPath = $tempPath . $zipName;
        $zipper->make($zipPath)->add($filePath)->add($descPath);
        $zipper->close();
        return response()->download($zipPath);
        
    }
    
    /**
     * 开发方下载测试报告
     * @date: 2018年11月25日 下午8:09:46
     * @author: wongwuchiu
     * @param: 事件主键event_id
     * @return: 下载打包好的组件文件和描述文档
     */
    public function downloadByDeveloper($event_id){
        $event = $this->eventService->getById($event_id);
        $user_id = Auth::user()->id;
        $comp_id = $event->comp_id;
        $ret = $this->compAuthorityService->checkAuthority($user_id, $comp_id);
        if (!$ret || $event->status < 1201){
            $url = "tester/complist/0/0";
            $msg = "没有权限下载组件！";
            return view('error', compact("url","msg"));
        }
        $time = time();
        $zipName = $event->ver_num . '_' . $time . '.zip';
        $testPath = $event->testdoc_path;
        $filePath = storage_path() . $testPath;
        $zipper=new Zipper();
        $tempPath = storage_path() . '/app/temp/';
        $zipPath = $tempPath . $zipName;
        $zipper->make($zipPath)->add($filePath);
        $zipper->close();
        return response()->download($zipPath);
        
    }
    
    /**
     * 开发方下载测试报告
     * @date: 2018年11月25日 下午8:09:46
     * @author: wongwuchiu
     * @param: 事件主键event_id
     * @return: 下载打包好的组件文件和描述文档
     */
    public function downloadByIssue($issue_id){
        $issue = $this->issueService->getById($issue_id);
        $dev_id = $issue->dev_event;
        $devEvent = $this->eventService->getById($dev_id);
        if($devEvent->status != 1210){
            $url = "issue/list";
            $msg = "没有权限下载组件！";
            return view('error', compact("url","msg"));
        }
        $filePath = storage_path() . $issue->testdoc_path;
        $time = time();
        $zipName = $issue->ver_num . '_' . $time . '.zip';
        return $this->downloadByPath($zipName, $filePath);
        
    }
    
    /**
    * 用zip打包输入路径(文件夹)下的所有文件并返回下载
    * @date: 2018年11月26日 下午12:46:24
    * @author: wongwuchiu
    * @param: 生成的zip的名字zipName，要下载的路径filePath
    * @return: 返回下载的路径
    */
    public function downloadByPath($zipName,$filePath){
        $zipper=new Zipper();
        $tempPath = storage_path() . '/app/temp/';
        $zipPath = $tempPath . $zipName;
        $zipper->make($zipPath)->add($filePath);
        $zipper->close();
        return response()->download($zipPath);
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
