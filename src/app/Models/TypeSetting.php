<?php
/**
* 设置
* @date: 2019年1月21日 下午3:59:28
* @author: wongwuchiu
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeSetting extends Model
{
    protected $table = 'typesetting';
    protected $primaryKey = 'id';
    
    public $timestamps = true;
    
    
}

?>