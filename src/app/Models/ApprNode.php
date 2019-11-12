<?php
/**
 * 审批节点模型
 * @date: 2018年11月19日 下午4:09:01
 * @author: wongwuchiu
 */
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ApprNode extends Model
{
    protected $table = 'apprnode';
    
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
    * 获取节点下的人员
    * @date: 2018年11月27日 下午8:38:08
    * @author: wongwuchiu
    * @param: null
    * @return: 
    */
    public function Nodeuser(){
        return $this->hasMany("App\Models\ApprGroup","node_id","id");
    }
    
}

?>