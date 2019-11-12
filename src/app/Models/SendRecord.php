<?php
/**
 * 设备推送记录
 * @date: 2018年11月19日 下午4:09:01
 * @author: wongwuchiu
 */
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\ItechsProductIndex;

class SendRecord extends Model
{
    protected $table = 'sendrecord';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;      //10_30，开启时间戳
    
    /**
     * define a $primaryKey property to override this convention.
     * the primary key is an incrementing integer value
     *
     * @var int
     */
    protected $primaryKey = 'id';
    
    public function Product(){
        return $this->belongsTo("App\Models\ItechsProductIndex","proid","id");
    }
    
}

?>