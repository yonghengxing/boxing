<?php
// /**
// * User: danqi@iscas.ac.cn
// * Date: 2018/11/28
// * Time: 125:28
// */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDevices extends Model
{
    protected $table = 'productdevices';
    protected $primaryKey = 'id';
    
    public $timestamps = true;
    
//     function devToProc()
//     {
//         return $this->hasMany('App\Models\ItechsProductIndex','id','proid');
//     }
    
}

?>