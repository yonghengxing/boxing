<?php

/**
 * User: danqi@iscas.ac.cn
 * Date: 2018/11/29
 * Time: 10:56
 */

namespace App\Services;
use App\Services\BaseService;
use App\Models\Version;
use phpDocumentor\Reflection\Types\This;

class ProductServices extends BaseService
{
    function __construct(Version $version){
        $this->model = $version;
    }
    
    public function getFilePath($compID,$compver)
    {
        $filepath = $this->model->select('file_path')->
        where("comp_id",$compID)->
        where("ver_num",$compver)->
        where("type",1)->
        get();
        return $filepath;
    }
}
?>