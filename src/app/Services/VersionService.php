<?php
/**
 * 组件版本service
 * @date: 2018年11月19日 下午5:05:46
 * @author: wongwuchiu
 */
namespace App\Services;
use App\Services\BaseService;
use App\Models\Version;

class VersionService extends BaseService
{
    function __construct(Version $version){
        $this->model = $version;
    }
    
    
}

?>