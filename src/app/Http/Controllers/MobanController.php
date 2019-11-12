<?php
/**
 * 处理审批模板的相关操作
 * @date: 2018年11月19日 下午7:55:52
 * @author: wongwuchiu
 */
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\View;
use App\Models\Group;
use App\Models\Event;
use App\Models\CompAuthority;
use App\Models\ApprNode;
use Illuminate\Http\Request;
use App\Services\GroupService;
use App\Services\UserService;
use App\Services\CompAuthorityService;
use App\Services\ComponentService;
use App\Services\EventService;
use App\Services\MobanService;
use App\Services\ApprGroupService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\ApprGroup;
use App\Models\Moban;


class MobanController extends BaseController
{
    
    function __construct(MobanService $mobanService, ApprGroupService $apprGroupService,CompAuthorityService $compAuthorityService, UserService $userService, ComponentService $componentService)
    {
        $this->middleware('auth');
        $this->compAuthorityService = $compAuthorityService;
        $this->userService = $userService;
        $this->apprGroupService = $apprGroupService;
        $this->componentService = $componentService;
        $this->mobanService = $mobanService;
        // 此时的的 $this->userService相当于实例化了服务容器：UserService
    }
    
    /**
     * 依据组件类型获取模板
     * @date: 2018年11月27日 下午4:28:42
     * @author: wongwuchiu
     * @param: 组件类型comp_type
     * @return:
     */
    public function moban_show($comp_type,$action_type){
        //1.18：修改
        $nodes = $this->mobanService->getActiveNodeList($comp_type, $action_type)->sortBy("level");
        $select_type = $comp_type;
        $select_action = $action_type;
        return view('moban/show', compact('nodes','select_type','select_action'));
    }
    
    /**
     * 打开新建类型审批模板页面
     * @date: 2018年11月27日 下午4:28:42
     * @author: wongwuchiu
     * @param: 组件类型comp_type
     * @return:
     */
    public function moban_new($comp_type,$action_type,$level){
        //1.18：修改
        $nodes = $this->mobanService->getActiveNodeList($comp_type,$action_type)->sortBy("level");
        if ($nodes->count() != 0){
            $url = 'moban/show/' . $comp_type . '/' . $action_type;
            $msg = '存在现有模板，请先删除!';
            return view('error', compact("url","msg"));
        }
        return view('moban/new', compact('comp_type','action_type','level'));
    }
    
    public function moban_getusers(){
        $test = array();
        $user_type = $_POST['user_type'];
        //1.18：修改
        $users = $this->userService->getUsersByRole($user_type);
        $test = [];
        foreach ($users as $user)
        {
            $test[]= $user;
        }
        echo json_encode($test);
    }
    
    
    public function moban_new_do2($comp_type,$action_type,$level,Request $request){
//         $res = $request->all();
//         dd($res);
        $user_type = $request->get("user_type");
        $user_num = $request->get("user_num");
        $append_finish = $request->get("append_finish");
        $node_name = $request->get("node_name");
        $mNode = new Moban();
        $mNode->comp_type = $comp_type;
        $mNode->user_type = $user_type;
        $mNode->node_name = $node_name;
        $mNode->action_type = $action_type;
        $mNode->level = $level;
        $mNode->max_level = -1;
        $mNode->next_node = -1;
        $mNode->active = -2;
        //$saveRet = $this->mobanService->append($mNode);
        $newID = $this->mobanService->appendID($mNode);
        if($newID == 0){
            $url = 'moban/show/' . $comp_type . '/' . $action_type;
            $msg = '储存新节点出错!';
            return view('error', compact("url","msg"));
        }
        //Step3:获取本次追加的产品并计入数组
        $userAppend = array();
        for ($idx=1; $idx <= $user_num; $idx++){
            $userKey = "user_" . $idx;
            if (!$request->has($userKey)){
                break;
            }
            $userAppend[] = $request->get($userKey);
        }
        $userAppend = array_unique($userAppend);        //去重
        //Step4:遍历每个将要添加的产品
        foreach ($userAppend as $user_id) {
            $mGroup = new ApprGroup();
            $mGroup->node_id = $newID;
            $mGroup->approver_id = $user_id;
            $saveRet = $this->apprGroupService->append($mGroup);
            if (!$saveRet){
                $url = 'moban/show/' . $comp_type . '/' . $action_type;
                $msg = "为审批节点添加用户失败！";
                return view('error', compact("url","msg"));
            }
        }
        if ($append_finish == "0"){
            $nextLevel = $level + 1;
            $url = 'moban/new/' . $comp_type . '/' . $action_type . '/' . $nextLevel;
            return view('success', compact("url"));
        } else {
            $nodeList = $this->mobanService->getInitNodeList($comp_type, $action_type)->sortByDesc("level");
            $next_node = -1;
            foreach ($nodeList as $node){
                $node->max_level = $level;
                $node->next_node = $next_node;
                $node->active = 1;
                $saveRet = $this->mobanService->update($node);
                if (!$saveRet){
                    $url = 'moban/show/' . $comp_type . '/' . $action_type;
                    $msg = "更新审批节点信息失败";
                    return view('error', compact("url","msg"));
                }
                $next_node = $node->id;
            }
            $url = 'moban/show/' . $comp_type . '/' . $action_type;
            return view('success', compact("url"));
        }
    }
    
    /**
     * 新建类型审批模板的数据处理
     * @date: 2018年11月27日 下午8:00:14
     * @author: wongwuchiu
     * @param: 组件类型comp_type,http的Request
     * @return:
     */
    public function moban_new_do($comp_type,Request $request){
        //Step1:从post的Request获取信息
        $nodeCount = $request->get("node_num");
        //Step2:依照次序逐个建立节点
        //         for ($idx = 1;$idx <= $nodeCount;$idx++){
        //             $nodeKey = "node_" . $idx;
        //             if(!$request->has($nodeKey)){
        //                 $url = 'template/show/' . $comp_type;
        //                 $msg = '新建模板缺少节点!';
        //                 return view('error', compact("url","msg"));
        //             }
        //             $nodeName = $request->get($nodeKey);
        //             $mNode = new ApprNode();
        //             $mNode->comp_type = $comp_type;
        //             $mNode->node_name = $nodeName;
        //             $mNode->level = $idx;
        //             $mNode->max_level = $nodeCount;
        //             $saveRet = $this->mobanService->append($mNode);
        //             if(!$saveRet){
        //                 $url = 'template/show/' . $comp_type;
        //                 $msg = '储存新节点出错!';
        //                 return view('error', compact("url","msg"));
        //             }
        //         }
        
        //1.18修改倒序添加+激活
        $next_node = -1;
        for ($idx = $nodeCount;$idx >= 1;$idx--){
            $nodeKey = "node_" . $idx;
            if(!$request->has($nodeKey)){
                $url = 'template/show/' . $comp_type;
                $msg = '新建模板缺少节点!';
                return view('error', compact("url","msg"));
            }
            $nodeName = $request->get($nodeKey);
            $mNode = new ApprNode();
            $mNode->comp_type = $comp_type;
            $mNode->node_name = $nodeName;
            $mNode->level = $idx;
            $mNode->max_level = $nodeCount;
            $mNode->next_node = $next_node;
            $mNode->active = 1;
            //$saveRet = $this->mobanService->append($mNode);
            $newID = $this->mobanService->appendID($mNode);
            if($newID == 0){
                $url = 'template/show/' . $comp_type;
                $msg = '储存新节点出错!';
                return view('error', compact("url","msg"));
            }
            $next_node = $newID;
        }
        $url = 'template/show/' . $comp_type;
        return view('success', compact("url"));
    }
    
    /**
     * 获取审批节点的人员
     * @date: 2018年11月27日 下午8:34:11
     * @author: wongwuchiu
     * @param: 审批节点node_id
     * @return:
     */
    public function moban_node($node_id,Request $request){
        $node = $this->mobanService->getById($node_id);
        $mNodeusers = $node->Nodeuser;
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mNodeusers->count();
        $result = $mNodeusers->sortByDesc("created_at")->forPage($currentPage, $perPage);
        $nodeusers= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return view('moban/node', compact("nodeusers","node_id"));
    }
    
    /**
     * 打开节点追加审批人页面
     * @date: 2018年11月27日 下午9:13:08
     * @author: wongwuchiu
     * @param: 审批节点node_id
     * @return:
     */
    public function moban_nodeappend($node_id){
        $node = $this->mobanService->getById($node_id);
        $user_type = $node->user_type;
        $approvers = $this->userService->getUsersByRole($user_type);
        return view('moban/nodeappend', compact("approvers","node"));
    }
    
    /**
     * 节点添加审批人员的数据处理
     * @date: 2018年11月27日 下午9:13:08
     * @author: wongwuchiu
     * @param: 审批节点node_id
     * @return:
     */
    public function moban_nodeappend_do($node_id,Request $request){
        //Step1:获取post的数据和节点信息
        $node = $this->mobanService->getById($node_id);
        $nodeusers = $node->Nodeuser;
        //Step2:获取节点所有的审批人并计入数组
        $approverOld = array();
        foreach ($nodeusers as $nodeuser){
            $approverId = $nodeuser->approver_id;
            $approverOld[] = $approverId;
        }
        //Step3:获取本次追加的产品并计入数组
        $approverAppend = array();
        $appendNum = $request->get("approver_num");
        for ($idx=1; $idx <= $appendNum; $idx++){
            $approverKey = "approver_" . $idx;
            if (!$request->has($approverKey)){
                break;
            }
            $approverAppend[] = $request->get($approverKey);
        }
        $approverAppend = array_unique($approverAppend);        //去重
        //Step4:遍历每个将要添加的产品
        foreach ($approverAppend as $mApprover) {
            if (!in_array($mApprover, $approverOld)){
                //如果之前已授权这次就不追加，追加没有的
                $mGroup = new ApprGroup();
                $mGroup->node_id = $node_id;
                $mGroup->approver_id = $mApprover;
                $saveRet = $this->apprGroupService->append($mGroup);
                if (!$saveRet){
                    $url = 'template/node/' . $node_id;
                    $msg = "为审批节点添加用户失败！";
                    return view('error', compact("url","msg"));
                }
            }
        }
        
        $url = "moban/node/" . $node_id;
        return view('success', compact("url"));
    }
    
    /**
     * 依据组建类型删除审批模板
     * @date: 2018年11月28日 上午9:46:50
     * @author: wongwuchiu
     * @param: 组件类型comp_type
     * @return:
     */
    public function moban_delete($comp_type,$action_type){
        //1.18:修改
//         echo "1";
        $nodes = $this->mobanService->getActiveNodeList($comp_type, $action_type);
        if ($nodes->count() == 0){
            $url = 'moban/show/' . $comp_type . '/' . $action_type;
            $msg = "审批模板为空，删除失败！";
            return view('error', compact("url","msg"));
        }
        foreach ($nodes as $node){
            //1.18:将激活位设置为0
            //             $deleteRet = $this->mobanService->delete($node->id);
            $node->active = 0;
            $deleteRet = $this->mobanService->update($node);
            if (!$deleteRet){
                $url = 'moban/show/' . $comp_type . '/' . $action_type;
                $msg = "删除节点失败！";
                return view('error', compact("url","msg"));
            }
        }
        $url = 'moban/show/' . $comp_type . '/' . $action_type;
        return view('success', compact("url"));
    }
    
    /**
     * 依据组建类型删除审批模板
     * @date: 2018年11月28日 上午9:46:50
     * @author: wongwuchiu
     * @param: 组件类型comp_type
     * @return:
     */
    public function moban_deleteappr($apprgroup_id){
        $apprgroup = $this->apprGroupService->getById($apprgroup_id);
        $nodeId = $apprgroup->node_id;
        $deleteRet = $this->apprGroupService->delete($apprgroup_id);
        if (!$deleteRet){
            $url = 'moban/node/'. $nodeId;
            $msg = "删除节点人员失败！";
            return view('error', compact("url","msg"));
        } else {
            $url = 'moban/node/'. $nodeId;
            return view('success', compact("url"));
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