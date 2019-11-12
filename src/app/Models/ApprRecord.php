<?php
/**
 * 审批记录模型
 * @date: 2018年11月19日 下午4:09:01
 * @author: wongwuchiu
 */
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ApprRecord extends Model
{
    protected $table = 'apprrecord';
    
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
    * 记录对应的审批人
    * @date: 2018年11月23日 下午6:55:29
    * @author: wongwuchiu
    * @param: null
    * @return: 所属审批人
    */
    public function Appruser(){
        return $this->belongsTo('App\User','approver','id');
    }
    
    /**
    * 记录对应的审批节点
    * @date: 2018年11月23日 下午6:57:53
    * @author: wongwuchiu
    * @param: null
    * @return: 所属审批节点
    */
    public function ApprNode(){
        return $this->belongsTo('App\Models\ApprNode','appr_node','id');
    }
    
    /**
    * 记录对应的审批事件
    * @date: 2018年11月23日 下午7:22:33
    * @author: wongwuchiu
    * @param: null
    * @return: 所属审批事件
    */
    public function ApprEvent(){
        return $this->belongsTo('App\Models\Event','appr_event','id');
    }
}

?>