<?php
// /**
// * User: danqi@iscas.ac.cn
// * Date: 2018/11/28
// * Time: 125:28
// */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItechsProduct extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id';
    
    public $timestamps = true;
    
    public function version()
    {
        return $this->hasMany('App\Models\Version','comp_id','comp_id');
    }
    
    public function product()
    {
        return $this->belongsTo('App\Models\ItechsProductIndex','proid','id');
    }
    
    public function component()
    {
        return $this->belongsTo('App\Models\Component','comp_id','id');
    }
}