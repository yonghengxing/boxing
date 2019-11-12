<?php
/**
 * 组件模型
 * @date: 2018年11月19日 下午4:09:01
 * @author: wongwuchiu
 */
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    
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
    * 获取组件相关的事件Event
    * @date: 2018年11月22日 上午10:39:07
    * @author: wongwuchiu
    * @param: null
    * @return: Events
    */
    public function Component(){
        return $this->belongsTo('App\Models\Component', 'comp_id', 'id');
    }
    
    /**
    * 获取事件的用户
    * @date: 2018年11月22日 下午7:44:34
    * @author: wongwuchiu
    * @param: null
    * @return: 
    */
    public function User(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    
    /**
    * 获取审批时间的审批记录ApprRecord
    * @date: 2018年11月23日 下午6:43:44
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function ApprRecords(){
        return $this->hasMany('App\Models\ApprRecord','appr_event','id');
    }
    
    /**
     * 获取事件的前置事件
     * @date: 2018年11月23日 下午6:43:44
     * @author: wongwuchiu
     * @param: variable
     * @return:
     */
    public function Preevent(){
        return $this->belongsTo('App\Models\Event','pre_event','id');
    }
    
    /**
    * 获取事件的问题
    * @date: 2018年11月26日 下午9:30:40
    * @author: wongwuchiu
    * @param: null
    * @return: 
    */
    public function Issue(){
        return $this->hasOne('App\Models\Issue','dev_event','id');
    }
}

?>