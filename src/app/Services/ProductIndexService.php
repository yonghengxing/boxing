<?php
//设备产品关联

namespace App\Services;
use App\Services\BaseService;
use App\Models\ItechsProductIndex;

class ProductIndexService extends BaseService{
    function __construct(ItechsProductIndex $itechsProductIndex){
        $this->model = $itechsProductIndex;
    }
}