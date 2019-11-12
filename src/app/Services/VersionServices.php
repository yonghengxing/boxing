<?php
/**
 * User: danqi@iscas.ac.cn
 * Date: 2018/11/29
 * Time: 22:56
 */

namespace App\Services;
use App\Services\BaseService;
use App\Models\Component;

class VersionServices extends BaseService
{
    function __construct(Component $component){
        $this->model = $component;
    }
    
    //获取版本号
    public function getCompVersion($compName)
    {
        $compID = $this->model->select('id')->where("comp_name",$compName)->get();
        
        $compVersion = $this->model->select('ver_num')->
        where("comp_id",$compID)->
        where("type",1)->
        get();
        return $compVersion;
    }
    
}

?>
