<?php
/**
 * User: shoubin@iscas.ac.cn
 * Date: 2018/10/14
 * Time: 17:17
 */
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\View;
use App\Services\UserService;
use App\Services\GroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Log;

class UserController extends BaseController
{

    function __construct(UserService $userService, GroupService $groupService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
        $this->groupService = $groupService;
        // 此时的的 $this->userService相当于实例化了服务容器：UserService
    }

    /**
     * 获取用户列表
     * 
     * @return unknown
     */
    public function user_list(Request $request)
    {
//         $users = null;
//         $isAdmin = $this->isAdmin();
//         if ($isAdmin) {
//             $users = $this->userService->getUserlistByNum(15);
//         } else {
//             $group_id = Auth::user()->group_id;
//             $users = $this->userService->getUserlistSameGroup($group_id, 15);
//         }
        $users = $this->userService->getAllByPage(15, $request);
        //var_dump($users);
        return view('user/list', compact('users'));
    }

    /**
     * 获取用户详细信息
     * 
     * @param unknown $user_id            
     * @return unknown
     */
    public function user_info($user_id)
    {
//         $isAdmin = $this->isAdmin();
//         if (! $isAdmin) {
//             $url = "user/list";
//             return view('error', compact("url"));
//         }
        $user = $this->userService->getById($user_id);
        $groups = $this->groupService->getAll();
        return view('user/info', compact('user', 'groups'));
    }

    /**
     * 更新用户信息 2018_10_30
     * 
     * @param unknown $user_id            
     * @return unknown
     */
    public function user_update($user_id, Request $request)
    {
        //$name = $request->get("username");
        $truename = $request->get("truename");
        $pwd = $request->get("pwd");
        $role = $request->get("role");
        $group_id = $request->get("group_id");
        $mUser = $this->userService->getById($user_id);
        $mUser->id = $user_id;
        //$mUser->name = $name;
        $mUser->true_name= $truename;
        $mUser->user_role = $role;
        $mUser->group_id = $group_id;
        $mUser->password = bcrypt($pwd);
        $ret = $this->userService->update($mUser);
        $url = "user/role/0/0";
        if ($ret) {
            return view('success', compact("url"));
        } else {
            $msg = "数据库更新用户出错！";
            return view('error', compact("url","msg"));
        }
    }

    /**
     * 创建用户
     * 
     * @return unknown
     */
    public function user_new()
    {
//         $isAdmin = $this->isAdmin();
//         if (! $isAdmin) {
//             $url = "user/list";
//             return view('error', compact("url"));
//         }
        $groups = $this->groupService->getAll();
        return view('user/new', compact('groups'));
    }

    /**
     * 创建用户
     * 
     * @return unknown
     */
    public function user_delete($user_id)
    {
//         $isAdmin = $this->isAdmin();
//         if (! $isAdmin) {
//             $url = "user/list";
//             return view('error', compact("url"));
//         }
        // echo "<script> var sure=confirm( '确认你的操作吗 '); if (1==sure){alert( '你选择了是 ')} else {alert( '你选择了否 ');}</script>";
        $ret = $this->userService->delete($user_id);
        $url = "user/role/0/0";
        if ($ret) {
            return view('success', compact("url"));
        } else {
            $msg = "数据库删除用户出错！";
            return view('error', compact("url","msg"));
        }
    }

    /**
     * 创建用户
     * 
     * @return unknown
     */
    public function user_new_do(Request $request)
    {
//         $isAdmin = $this->isAdmin();
//         if (! $isAdmin) {
//             $url = "user/list";
//             return view('error', compact("url"));
//         }
        $username = $request->get("username");
        $truename = $request->get("truename");
        $group_id = $request->get("group_id");
        $pwd = $request->get("pwd");
        $role = $request->get("role");
        // 缺少密码检查、上传密码
        
        $user = new User();
        $user->username = $username;
        $user->true_name = $truename;
        $user->user_role = $role;
        $user->created_at = Carbon::now();
        $user->group_id = $group_id;
        $user->password = bcrypt($pwd);
        
        $ret = $this->userService->append($user);
        
        $url = "user/role/0/0";
        if ($ret) {
            return view('success', compact("url"));
        } else {
            return view('error', compact("url"));
        }
    }

    public function user_role_list($select_role,$select_group,Request $request)
    {
        //$isAdmin = $this->isAdmin();
//         $users = $this->userService->getUsersByRole($user_role);
//         return view('user/typeselect', compact('users', 'user_role'));
        $mUsers = null;
        $groups = $this->groupService->getAll();
        if($select_role != 0 && $select_group != 0){
            $mUsers = $this->userService->getAll()->where('user_role',$select_role)->where('group_id',$select_group);
        } else if($select_role != 0 && $select_group == 0){
            $mUsers = $this->userService->getAll()->where('user_role',$select_role);
        } else if($select_group != 0 && $select_role == 0){
            $mUsers = $this->userService->getAll()->where('group_id',$select_group);
        } else {
            $mUsers = $this->userService->getAll();
        }
        //         $mUsers = $user->Component;
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mUsers->count();
        $result = $mUsers->sortByDesc("test_status")->sortByDesc("test_updated")->forPage($currentPage, $perPage);
        $users= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return view('user/typeselect', compact('users', 'select_role','select_group','groups'));
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
