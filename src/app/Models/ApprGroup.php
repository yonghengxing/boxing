<?php
/**
 * 公司模型
 * @date: 2018年11月19日 下午4:09:01
 * @author: wongwuchiu
 */
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ApprGroup extends Model
{
    protected $table = 'apprgroup';
    
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
    
    /**
    * 获取用户
    * @date: 2018年11月27日 下午8:40:28
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function Approver(){
        return $this->belongsTo("App\User","approver_id","id");
    }
}

?>