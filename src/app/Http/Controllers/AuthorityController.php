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
use App\Models\CompAuthority;
use Illuminate\Http\Request;
use App\Services\GroupService;
use App\Services\UserService;
use App\Services\CompAuthorityService;
use App\Services\ComponentService;
use App\Services\EventService;
use App\Services\ApprNodeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class AuthorityController extends BaseController
{
    
    function __construct(ApprNodeService $apprNodeService,EventService $eventService,CompAuthorityService $compAuthorityService, UserService $userService, ComponentService $componentService)
    {
        $this->middleware('auth');
        $this->compAuthorityService = $compAuthorityService;
        $this->userService = $userService;
        $this->eventService = $eventService;
        $this->componentService = $componentService;
        $this->apprNodeService = $apprNodeService;
        // 此时的的 $this->userService相当于实例化了服务容器：UserService
    }
    
    /**
     * 显示人员有权访问的组件列表
     * @date: 2018年11月21日 下午4:50:06
     * @author: wongwuchiu
     * @param: 用户user_id，http的request
     * @return: 进入相关事件页面
     */
    public function auth_userlist($user_id,Request $request){
        $user = $this->userService->getById($user_id);
        $mAuthorities = $user->Authorities;
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mAuthorities->count();
        $result = $mAuthorities->forPage($currentPage, $perPage);
        $authorities= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return view('authority/userlist', compact('authorities','user'));
    }
    
    /**
    * 打开用户追加组件权限页面
    * @date: 2018年11月27日 下午3:07:36
    * @author: wongwuchiu
    * @param: 用户user_id
    * @return: 
    */
    public function auth_userappend($user_id){
        $user = $this->userService->getById($user_id);
        $components = $this->componentService->getAll();
        return view('authority/userappend', compact('components','user'));
    }
    
    /**
    * 处理用户追加权限
    * @date: 2018年11月27日 下午3:32:26
    * @author: wongwuchiu
    * @param: 用户user_id,http的request
    * @return: 
    */
    public function auth_userappend_do($user_id,Request $request){
        //Step1:获取post的数据和用户信息
        $user = $this->userService->getById($user_id);
        $authorities = $user->Authorities;
        //Step2:获取用户所有有授权的产品并计入数组
        $compOld = array();
        foreach ($authorities as $authority){
            $compId = $authority->comp_id;
            $compOld[] = $compId;
        }
        //Step3:获取本次追加的产品并计入数组
        $compAppend = array();
        $appendNum = $request->get("comp_num");
        for ($idx=1; $idx <= $appendNum; $idx++){
            $compKey = "comp_" . $idx;
            if (!$request->has($compKey)){
                break;
            }
            $compAppend[] = $request->get($compKey);
        }
        $compAppend = array_unique($compAppend);        //去重
        //Step4:遍历每个将要添加的产品
        foreach ($compAppend as $mComp) {
            if (!in_array($mComp, $compOld)){
                //如果之前已授权这次就不追加，追加没有的
                $mAuthority = new CompAuthority();
                $mAuthority->user_id = $user_id;
                $mAuthority->comp_id = $mComp;
                $saveRet = $this->compAuthorityService->append($mAuthority);
                if (!$saveRet){
                    $url = "user/list";
                    $msg = "用户储存授权信息错误！";
                    return view('error', compact("url","msg"));
                }
            }
        }
        
        $url = "user/list";
        return view('success', compact("url"));
    }
    
    /**
     * 显示组件有权访问的人员列表
     * @date: 2018年11月21日 下午4:50:06
     * @author: wongwuchiu
     * @param: 组件comp_id，http的request
     * @return: 进入相关事件页面
     */
    public function auth_complist($comp_id,Request $request){
        $component = $this->componentService->getById($comp_id);
        $mAuthorities = $component->Authorities;
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mAuthorities->count();
        $result = $mAuthorities->forPage($currentPage, $perPage);
        $authorities= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return view('authority/complist', compact('authorities','component'));
    }
    
    /**
     * 打开用户追加组件权限页面
     * @date: 2018年11月27日 下午3:07:36
     * @author: wongwuchiu
     * @param: 用户user_id
     * @return:
     */
    public function auth_compappend($comp_id){
        $component = $this->componentService->getById($comp_id);
        $users = $this->userService->getAll();
        return view('authority/compappend', compact('component','users'));
    }
    
    /**
     * 处理用户追加权限
     * @date: 2018年11月27日 下午3:32:26
     * @author: wongwuchiu
     * @param: 用户user_id,http的request
     * @return:
     */
    public function auth_compappend_do($comp_id,Request $request){
        //Step1:获取post的数据和用户信息
        $component = $this->componentService->getById($comp_id);
        $authorities= $component->Authorities;
        //Step2:获取用户所有有授权的产品并计入数组
        $userOld = array();
        foreach ($authorities as $authority){
            $userId = $authority->user_id;
            $userOld[] = $userId;
        }
        //Step3:获取本次追加的产品并计入数组
        $userAppend = array();
        $appendNum = $request->get("user_num");
        for ($idx=1; $idx <= $appendNum; $idx++){
            $userKey = "user_" . $idx;
            if (!$request->has($userKey)){
                $url = "authority/complist/" . $comp_id;
                $msg = "上传信息缺失错误！";
                return view('error', compact("url","msg"));
                break;
            }
            $userAppend[] = $request->get($userKey);
        }
        $userAppend = array_unique($userAppend);        //去重
        //Step4:遍历每个将要添加的产品
        foreach ($userAppend as $mUser) {
            if (!in_array($mUser, $userOld)){
                //如果之前已授权这次就不追加，追加没有的
                $mAuthority = new CompAuthority();
                $mAuthority->user_id = $mUser;
                $mAuthority->comp_id = $comp_id;
                $saveRet = $this->compAuthorityService->append($mAuthority);
                if (!$saveRet){
                    $url = "authority/complist/" . $comp_id;
                    $msg = "用户储存授权信息错误！";
                    return view('error', compact("url","msg"));
                }
            }
        }
        $url = "authority/complist/" . $comp_id;
        return view('success', compact("url"));
    }
    
    /**
    * 删除组件授权
    * @date: 2018年11月28日 下午12:35:08
    * @author: wongwuchiu
    * @param: 组件授权主键compauthority_id
    * @return: 
    */
    public function auth_delete($compauthority_id){
        $deleteRet = $this->compAuthorityService->delete($compauthority_id);
        if (!$deleteRet){
            $url = "index";
            $msg = "删除错误！";
            return view('error', compact("url","msg"));
        } else {
            $url = "index";
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
    
    /**
    * 打开增加开发方人员页面
    * @date: 2019年1月20日 下午2:23:44
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function auth_adddever($comp_id,$pro_id){
        $component = $this->componentService->getById($comp_id);
        $users = $this->userService->getUsersByRole(1000);
        return view('authority/adddever', compact('component','users','pro_id'));
    }
    
    /**
    * 处理增加开发方人员的数据
    * @date: 2019年1月20日 下午2:24:13
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function auth_adddever_do($comp_id,$pro_id,Request $request){
        //Step1:获取post的数据和用户信息
        $component = $this->componentService->getById($comp_id);
        $authorities= $component->Authorities;
        //Step2:获取用户所有有授权的产品并计入数组
        $userOld = array();
        foreach ($authorities as $authority){
            $userId = $authority->user_id;
            $userOld[] = $userId;
        }
        //Step3:获取本次追加的产品并计入数组
        $userAppend = array();
        $appendNum = $request->get("user_num");
        for ($idx=1; $idx <= $appendNum; $idx++){
            $userKey = "user_" . $idx;
            if (!$request->has($userKey)){
                $url = "authority/complist/" . $comp_id;
                $msg = "上传信息缺失错误！";
                return view('error', compact("url","msg"));
                break;
            }
            $userAppend[] = $request->get($userKey);
        }
        $userAppend = array_unique($userAppend);        //去重
        //Step4:遍历每个将要添加的产品
        foreach ($userAppend as $mUser) {
            if (!in_array($mUser, $userOld)){
                //如果之前已授权这次就不追加，追加没有的
                $mAuthority = new CompAuthority();
                $mAuthority->user_id = $mUser;
                $mAuthority->comp_id = $comp_id;
                $saveRet = $this->compAuthorityService->append($mAuthority);
                if (!$saveRet){
                    $url = "authority/complist/" . $comp_id;
                    $msg = "用户储存授权信息错误！";
                    return view('error', compact("url","msg"));
                }
            }
        }
        $url = "authority/addtester/" . $comp_id . "/" . $pro_id;
        return view('success', compact("url"));
    }
    
    /**
    * 打开增加测试方人员页面
    * @date: 2019年1月20日 下午2:25:18
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function auth_addtester($comp_id,$pro_id){
        $component = $this->componentService->getById($comp_id);
        $users = $this->userService->getUsersByRole(2000);
        return view('authority/addtester', compact('component','users','pro_id'));
    }
    
    /**
    * 对增加的测试方人员进行数据处理
    * @date: 2019年1月20日 下午2:26:33
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function auth_addtester_do($comp_id,$pro_id,Request $request){
        //Step1:获取post的数据和用户信息
        $component = $this->componentService->getById($comp_id);
        $authorities= $component->Authorities;
        //Step2:获取用户所有有授权的产品并计入数组
        $userOld = array();
        foreach ($authorities as $authority){
            $userId = $authority->user_id;
            $userOld[] = $userId;
        }
        //Step3:获取本次追加的产品并计入数组
        $userAppend = array();
        $appendNum = $request->get("user_num");
        for ($idx=1; $idx <= $appendNum; $idx++){
            $userKey = "user_" . $idx;
            if (!$request->has($userKey)){
                $url = "authority/complist/" . $comp_id;
                $msg = "上传信息缺失错误！";
                return view('error', compact("url","msg"));
                break;
            }
            $userAppend[] = $request->get($userKey);
        }
        $userAppend = array_unique($userAppend);        //去重
        //Step4:遍历每个将要添加的产品
        foreach ($userAppend as $mUser) {
            if (!in_array($mUser, $userOld)){
                //如果之前已授权这次就不追加，追加没有的
                $mAuthority = new CompAuthority();
                $mAuthority->user_id = $mUser;
                $mAuthority->comp_id = $comp_id;
                $saveRet = $this->compAuthorityService->append($mAuthority);
                if (!$saveRet){
                    $url = "authority/complist/" . $comp_id;
                    $msg = "用户储存授权信息错误！";
                    return view('error', compact("url","msg"));
                }
            }
        }
        $url = "authority/addapprer/" . $comp_id . "/" . $pro_id;
        return view('success', compact("url"));
    }
    
    /**
    * 添加机关方人员页面展示
    * @date: 2019年1月20日 下午2:44:37
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function auth_addapprer($comp_id,$pro_id){
        $component = $this->componentService->getById($comp_id);
        $comp_type = $component->comp_type;
        $comp_name = $component->comp_name;
        $nodes = $this->apprNodeService->getActiveNodeList($comp_type)->sortBy("level");
        $node_users = array();
        $node_namelist = array();
        $node_count = count($nodes);
        foreach ($nodes as $node){
//             echo "节点名：" . $node->node_name . ",level:" . $node->level . "<br>";
            $apprers = $node->Nodeuser;
            $node_users[] = $apprers;
            $node_namelist[] = $node->node_name;
        }
//         for ($i = 0;$i < count($node_users);$i++){
//             echo "节点" . $i . ":" . $node_namelist[$i] . "<br>";
//             foreach ($node_users[$i] as $user){
//                 echo "机关方:" . $user . "<br>";
//             }
//         }
        return view('authority/addapprer', compact('comp_id','node_count','node_namelist','comp_name','node_users','pro_id'));
    }
    
    /**
    * 添加机关方数据处理
    * @date: 2019年1月20日 下午4:05:42
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function auth_addapprer_do($comp_id,$pro_id,Request $request){
        //Step1:获取post的数据和用户信息
        $component = $this->componentService->getById($comp_id);
        $authorities= $component->Authorities;
        //Step2:获取用户所有有授权的产品并计入数组
        $userOld = array();
        foreach ($authorities as $authority){
            $userId = $authority->user_id;
            $userOld[] = $userId;
        }
        //Step3:获取本次追加的产品并计入数组
        $userAppend = array();
        $res = $request->all();
        foreach ($res as $key => $value){
            $findRes = strpos($key,"auth_");
            if ($findRes !== false){
                if ($value == 1){
                    $appr_id = substr($key,$findRes + 5);
                    $userAppend[] = (int)$appr_id;
                }
            } else {
                continue;
            }
        }
        $userAppend = array_unique($userAppend);        //去重
        //Step4:遍历每个将要添加的产品
        foreach ($userAppend as $mUser) {
            if (!in_array($mUser, $userOld)){
                //如果之前已授权这次就不追加，追加没有的
                $mAuthority = new CompAuthority();
                $mAuthority->user_id = $mUser;
                $mAuthority->comp_id = $comp_id;
                $saveRet = $this->compAuthorityService->append($mAuthority);
                if (!$saveRet){
                    $url = "authority/complist/" . $comp_id;
                    $msg = "用户储存授权信息错误！";
                    return view('error', compact("url","msg"));
                }
            }
        }
        if($pro_id == 0){
            $url = "authority/complist/" . $comp_id;
            return view('success', compact("url"));
        } else {
            $url = "product/message/" . $pro_id;
            return view('success', compact("url"));
        }
    }
}   