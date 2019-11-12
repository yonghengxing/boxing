<?php
/**
 * 公司service
 * @date: 2018年11月19日 下午5:05:46
 * @author: wongwuchiu
 */
namespace App\Services;
use App\Services\BaseService;
use App\Models\Group;

class GroupService extends BaseService
{
    function __construct(Group $group){
        $this->model = $group;
    }
    
}

?>