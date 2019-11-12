<?php
//产品组件关联service

namespace App\Services;
use App\Services\BaseService;
use App\Models\Proctocomp;

class ProctocompService extends BaseService{
    function __construct(Proctocomp $proctocomp){
        $this->model = $proctocomp;
    }
    
    public function getAllComps($proid){
        $procomps = $this->model->where("proid",$proid)->get();
        return $procomps;
    }
}