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
use App\Models\Component;
use Illuminate\Http\Request;
use App\Services\GroupService;
use App\Services\UserService;
use App\Services\CompAuthorityService;
use App\Services\ComponentService;
use App\Services\EventService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\ItechsProduct;


class ComponentController extends BaseController
{
    
    function __construct(GroupService $groupService, EventService $eventService,CompAuthorityService $compAuthorityService, UserService $userService, ComponentService $componentService)
    {
        $this->middleware('auth');
        $this->compAuthorityService = $compAuthorityService;
        $this->userService = $userService;
        $this->groupService = $groupService;
        $this->eventService = $eventService;
        $this->componentService = $componentService;
        // 此时的的 $this->userService相当于实例化了服务容器：UserService
    }
    
    
    /**
     * 显示所有组件的列表
     * @date: 2018年11月21日 下午4:50:48
     * @author: wongwuchiu
     * @param: null
     * @return: 进入有权限访问的组件的列表页面
     */
    public function comp_list($select_type,$select_group,Request $request)
    {
        //         $currentUser = Auth::user();
        //         $components = $currentUser->Component;
        //         return view('developer/complist', compact('components'));
        $mComponents = null;
        $groups = $this->groupService->getAll();
        if($select_type != 0 && $select_group != 0){
            $mComponents = $this->componentService->getAll()->where('comp_type',$select_type)->where('group_id',$select_group);
        } else if($select_type != 0 && $select_group == 0){
            $mComponents = $this->componentService->getAll()->where('comp_type',$select_type);
        } else if($select_group != 0 && $select_type == 0){
            $mComponents = $this->componentService->getAll()->where('group_id',$select_group);
        } else {
            $mComponents = $this->componentService->getAll();
        }
        //         $mComponents = $user->Component;
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mComponents->count();
        $result = $mComponents->sortByDesc("appr_status")->sortByDesc("appr_updated")->forPage($currentPage, $perPage);
        $components= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return view('component/list', compact('components','select_type','select_group','groups'));
    }

    /**
    * 打开创建组件页面
    * @date: 2018年11月28日 下午1:49:29
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function comp_new()
    {
        $groups = $this->groupService->getAll();
        return view('component/new', compact('groups'));
    }
    
    /**
     * 创建组件数据处理
     * @date: 2018年11月28日 下午1:49:29
     * @author: wongwuchiu
     * @param: variable
     * @return:
     */
    public function comp_new_do(Request $request)
    {
        $compName = $request->get("comp_name");
        $compDesc = $request->get("comp_desc");
        $compType = $request->get("comp_type");
        $groupId = $request->get("group_id");
        $mComponent = new Component();
        $mComponent->comp_name = $compName;
        $mComponent->comp_type = $compType;
        $mComponent->comp_desc = $compDesc;
        $mComponent->group_id = $groupId;
        $comp_id = $this->componentService->appendID($mComponent);       
        if ($comp_id == 0){
            $url = "component/list/0/0";
            $msg = "新建组件错误！";
            return view('error', compact("url","msg"));
        } else {
            $url = "authority/adddever/" . $comp_id . "/0";
//             //组件id进产品库
//             $mProduct = new ItechsProduct();
//             $mProduct->proid = $proall_id;
//             $mProduct->comp_id = $comp_id;
            return view('success', compact("url"));
        }
    }
    
    /**
    * 打开修改组件信息的页面
    * @date: 2018年11月29日 上午9:44:50
    * @author: wongwuchiu
    * @param: 组件comp_id，http的request
    * @return: 
    */
    public function comp_info($comp_id){
        $component = $this->componentService->getById($comp_id);
        $groups = $this->groupService->getAll();
        return view('component/info', compact("component","groups"));
    }
    
    /**
    * 修改组件信息的数据处理
    * @date: 2018年11月29日 上午9:33:56
    * @author: wongwuchiu
    * @param: 组件comp_id，http的request
    * @return: 
    */
    public function comp_info_do($comp_id,Request $request)
    {
        $compName = $request->get("comp_name");
        $compDesc = $request->get("comp_desc");
        $compType = $request->get("comp_type");
        $groupId = $request->get("group_id");
        $mComponent = $this->componentService->getById($comp_id);
        $mComponent->comp_name = $compName;
        $mComponent->comp_type = $compType;
        $mComponent->comp_desc = $compDesc;
        $mComponent->group_id = $groupId;
        $updateRet = $this->componentService->update($mComponent);
        if (!$updateRet){
            $url = "component/list/0/0";
            $msg = "编辑组件错误！";
            return view('error', compact("url","msg"));
        } else {
            $url = "component/list/0/0";
            return view('success', compact("url"));
        }
    }
    
    /**
    * 获取组件相关所有
    * @date: 2018年11月29日 上午9:44:06
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function comp_eventlist($comp_id,Request $request)
    {
        $component = $this->componentService->getById($comp_id);
        $mEvents = $component->Events;
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mEvents->count();
        $result = $mEvents->sortByDesc("updated_at")->forPage($currentPage, $perPage);
        $events= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return view('component/eventlist', compact('events'));
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