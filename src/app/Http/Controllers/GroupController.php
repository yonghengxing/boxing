<?php
/**
 * User: shoubin@iscas.ac.cn
 * Date: 2018/10/14
 * Time: 17:17
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\View;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Services\GroupService;
use Illuminate\Support\Facades\Auth;



class GroupController extends BaseController
{
    
    
    function __construct(GroupService $groupService){
        $this->middleware('auth');
        $this->groupService=$groupService;
        //此时的的 $this->userService相当于实例化了服务容器：UserService
    }
    
    public function group_list()
    {  
        $groups =  $this->groupService->getAll();
        $isAdmin = $this->isAdmin();
        return view('group/list',compact('groups','isAdmin'));
    }
    
    public function group_new()
    {
        $isAdmin = $this->isAdmin();
        if (!$isAdmin && Auth::user()->user_role != 3000){
            $url="group/list";
            $msg = "无权新建公司";
            return view('error', compact("url","msg"));
        }
        return view('group/new');
    }
    
    //2018_10_30,创建新公司
    public function group_new_do(Request $request)
    {
        $isAdmin = $this->isAdmin();
        if (!$isAdmin && Auth::user()->user_role != 3000){
            $url="group/list";
            $msg = "无权新建公司";
            return view('error', compact("url","msg"));
        }
        $group_name = $request->get("group_name");
        $group_intro = $request->get("group_intro");
        
        $mGroup = new Group();
        $mGroup->group_name = $group_name;
        $mGroup->group_desc = $group_intro;
        $ret = $this->groupService->append($mGroup);
        $url="group/list";
        if($ret){
            return view('success', compact("url"));
        }else{
            $msg = "新建公司错误";
            return view('error', compact("url","msg"));
        }
    }
    
    //2018_10_30，删除公司
    public function group_delete($group_id){
        $isAdmin = $this->isAdmin();
        if (!$isAdmin){
            $url="group/list";
            $msg = "无权删除公司";
            return view('error', compact("url","msg"));
        }
        $ret = $this->groupService->delete($group_id);
        $url="group/list";
        if($ret){
            return view('success', compact("url"));
        }else{
            $url="group/list";
            $msg = "删除公司错误";
            return view('error', compact("url","msg"));
        }
    }
    
    public function group_edit($group_id)
    {
        $isAdmin = $this->isAdmin();
        if (!$isAdmin){
            $url="group/list";
            $msg = "无权编辑公司";
            return view('error', compact("url","msg"));
        }
        $group = $this->groupService->getById($group_id);
        return view('group/edit',compact('group'));
    }
    
    public function group_info($group_id)
    {
        $group = $this->groupService->getById($group_id);
        return view('group/info',compact('group'));
    }
    
    
    //2018_10_30.更新公司信息
    public function group_update($group_id,Request $request)
    {
        $isAdmin = $this->isAdmin();
        if (!$isAdmin){
            $url="group/list";
            $msg = "无权编辑公司";
            return view('error', compact("url","msg"));
        }
        $group_name = $request->get("group_name");
        $group_decs = $request->get("group_intro");
        $mGroup = $this->groupService->getById($group_id);
        $mGroup->group_name = $group_name;
        $mGroup->group_desc = $group_decs;
        $ret = $this->groupService->update($mGroup);
        $url="group/list";
        if($ret){
            return view('success', compact("url"));
        }else{
            return view('error', compact("url"));
        }
    }
    
    public function isAdmin(){
        if(Auth::check()){
            return Auth::user()->admin || config('app.admin_mode',false);
        }else {
            return false;
        }
    }
}
