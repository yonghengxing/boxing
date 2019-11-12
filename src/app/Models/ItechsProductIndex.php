<?php

// /**
// * User: danqi@iscas.ac.cn
// * Date: 2018/11/28
// * Time: 12:48
// */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItechsProductIndex extends Model
{
    protected $table = 'productindex';
    protected $primaryKey = 'id';
    
    public $timestamps = true;
    
    public function Group(){
        return $this->belongsTo("App\Models\Group","group_id","id");
    }
}