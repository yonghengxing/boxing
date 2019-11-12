<?php
/**
 * User: shoubin@iscas.ac.cn
 * Date: 2018/10/14
 * Time: 17:17
 */
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Services\IssueService;
use App\Services\EventService;
use App\Models\Issue;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
use Log;

class IssueController extends BaseController
{
    
    function __construct(IssueService $issueService, EventService $eventService)
    {
        $this->middleware('auth');
        $this->issueService = $issueService;
        $this->eventService = $eventService;
        // 此时的的 $this->userService相当于实例化了服务容器：UserService
    }

    /**
    * 打开新建问题页面
    * @date: 2018年11月27日 上午9:57:52
    * @author: wongwuchiu
    * @param: 测试事件event_id
    * @return: 
    */
    public function issue_new($event_id){
        $event = $this->eventService->getById($event_id);
        $preevent_id = $event->pre_event;
        $preevent = $this->eventService->getById($preevent_id);
        return view('issue/new',compact("event","preevent"));
    }
    
    /**
    * 新建问题数据处理
    * @date: 2018年11月27日 上午9:35:40
    * @author: wongwuchiu
    * @param: 问题所属事件event_id,以及http的request
    * @return: 
    */
    public function issue_new_do($event_id,Request $request){
        //Step1:获取事件信息，从Request中获取问题标题和描述
        $event = $this->eventService->getById($event_id);
        $devEvent = $event->Preevent;
        $title = $request->get("issue_title");
        $description = $request->get("issue_desc");
        if($event == null){
            $url = 'tester/complist';
            $msg = '找不到测试事件出错!';
            return view('error', compact("url","msg"));
        }
        //Step2:获取上传的测试报告
        $time = time();
        $testDoc = $request->file('testdoc');
        $fileName = $testDoc->getClientOriginalName();
        $tempPath = '/app/upload/temp/testdoc/' . $event->comp_id . '/' . $event->ver_num . '_' . $time . '/';
        $testDoc->move(storage_path() . $tempPath, $fileName);
        //Step3:新建一条问题并保存
        $issue = new Issue();
        $issue->title = $title;
        $issue->description = $description;
        $issue->status = 0;
        $issue->tester_id= Auth::user()->id;
        $issue->dev_id = $devEvent->user_id;
        $issue->comp_id = $event->comp_id;
        $issue->ver_num = $event->ver_num;
        $issue->testdoc_path = $tempPath;
        $issue->dev_event = $event->pre_event;
        $saveRet = $this->issueService->append($issue);
        if(!$saveRet){
            $url = 'tester/complist';
            $msg = '新增问题出错!';
            return view('error', compact("url","msg"));
        }
        //Step3:修改入库事件信息
        $devEvent->status = 1210;
        $devEvent->testdoc_path = $tempPath;
        $devRet = $this->eventService->update($devEvent);
        if(!$devRet){
            $url = 'tester/complist';
            $msg = '修改上传事件出错!';
            return view('error', compact("url","msg"));
        }
        //Step4:修改测试事件信息
        $event->status = 2110;
        $testRet = $this->eventService->update($event);
        if(!$testRet){
            $url = 'tester/complist';
            $msg = '修改测试事件出错!';
            return view('error', compact("url","msg"));
        }
        $url = 'tester/complist';
        return view('success', compact("url"));
    }
    
    /**
    * 依据开发方入库事件查看相关问题
    * @date: 2018年11月27日 上午9:37:45
    * @author: wongwuchiu
    * @param: 开发方入库事件event_id
    * @return: 
    */
    public function issue_event($event_id){
        $event = $this->eventService->getById($event_id);
        $issue = $event->Issue;
        return view('issue/info',compact('issue'));
    }
    
    /**
     * 依据问题id查看问题
     * @date: 2018年11月27日 上午9:37:45
     * @author: wongwuchiu
     * @param: 问题的issue_id
     * @return:
     */
    public function issue_info($issue_id){
        $issue = $this->issueService->getById($issue_id);
        return view('issue/info',compact('issue'));
    }
    
    /**
    * 修改问题的状态
    * @date: 2018年11月27日 上午9:57:30
    * @author: wongwuchiu
    * @param: 问题的issue_id,http的Request
    * @return: 
    */
    public function issue_update($issue_id,Request $request){
        $issue_status = $request->get("status");
        $issue = $this->issueService->getById($issue_id);
        $issue->status = $issue_status;
        $updateRet = $this->issueService->update($issue);
        if ($updateRet){
            $url = 'issue/list';
            return view('success', compact("url"));
        } else {
            $url = 'issue/list';
            $msg = '修改问题状态出错!';
            return view('error', compact("url","msg"));
        }
    }
    
    /**
    * 展示用户相关问题列表
    * @date: 2018年11月27日 上午10:08:06
    * @author: wongwuchiu
    * @param: null
    * @return: 展示问题列表网页
    */
    public function issue_list(Request $request){
        $user_id = Auth::user()->id;
        $issues = $this->issueService->getIssueByPage($user_id, 15, $request);
        return view('issue/list', compact("issues"));
    }
    
    public function isAdmin()
    {
        if (Auth::check()) {
            return Auth::user()->admin || config('app.admin_mode', false);
        } else {
            return false;
        }
    }
}
