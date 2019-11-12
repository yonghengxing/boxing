<?php
//产品组件关联service

namespace App\Services;
use App\Services\BaseService;
use App\Models\ItechsProduct;

class ItechsProductService extends BaseService{
    function __construct(ItechsProduct $itechsProduct){
        $this->model = $itechsProduct;
    }
}