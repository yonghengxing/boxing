<?php
//设备产品关联

namespace App\Services;
use App\Services\BaseService;
use App\Models\ProductDevices;

class ProductdevicesService extends BaseService{
    function __construct(ProductDevices $productDevices){
        $this->model = $productDevices;
    }
}