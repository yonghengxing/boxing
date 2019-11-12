<?php
/**
 * 组件类型人员角色设置service
 * @date: 2018年11月19日 下午5:05:46
 * @author: wongwuchiu
 */
namespace App\Services;
use App\Services\BaseService;
use App\Models\TypeSetting;

class TypeSettingService extends BaseService
{
    function __construct(TypeSetting $typeSetting){
        $this->model = $typeSetting;
    }
    
    public function getCompAll(){
        return $this->model->where("type",0)->get();
    }
    
    public function getUserAll(){
        return $this->model->where("type",1)->get();
    }
}

?>