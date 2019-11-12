<?php
/**
 * 组件状态service
 * @date: 2018年11月19日 下午5:05:46
 * @author: wongwuchiu
 */
namespace App\Services;
use App\Services\BaseService;
use App\Models\CompAuthority;

class CompAuthorityService extends BaseService
{
    function __construct(CompAuthority $compauthority){
        $this->model = $compauthority;
    }
    
    /**
    * 测试用户是否有权访问组件
    * @date: 2018年11月25日 下午8:11:29
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    function checkAuthority($user_id,$comp_id){
        $ret = $this->model->where('user_id',$user_id)->where('comp_id',$comp_id)->first();
        if($ret == null){
            return false;
        } else {
            return true;
        }
        
    }
    
    function getAuthUsers($comp_id){
        $users = $this->model->where('comp_id',$comp_id)->get();
        $userList = array();
        foreach ($users as $user){
            $user_id = $user->user_id;
            $userList[] = $user_id;
        }
        return $userList;
    }
    
}

?>