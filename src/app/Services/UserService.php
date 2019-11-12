<?php
/**
 * 用户状态service
 * @date: 2018年11月19日 下午5:05:46
 * @author: wongwuchiu
 */
namespace App\Services;
use App\Services\BaseService;
use App\User;

class UserService extends BaseService
{
    function __construct(User $user){
        $this->model = $user;
    }
    
    function getUsersByRole($role){
        $users = $this->model->where("user_role",$role)->get();
        return $users;
    }    
    
}

?>