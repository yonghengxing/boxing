<?php
/**
 * 公司模型
 * @date: 2018年11月19日 下午4:09:01
 * @author: wongwuchiu
 */
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
//     id 问题主键	title 问题标题	description 问题描述	status 问题状态	tester_id 提出的测试方id	dev_id 解决问题的开发方id	comp_id 组件id	ver_num 组件版本
    protected $table = 'issue';
    
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
    * 获取问题的提出人(测试方)
    * @date: 2018年11月26日 下午6:38:59
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public  function Tester(){
        return $this->belongsTo('App\User','tester_id','id');
    }
    
    /**
    * 获取问题的响应人(开发方)
    * @date: 2018年11月26日 下午6:41:21
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function Developer(){
        return $this->belongsTo('App\User','dev_id','id');
    }
    
    /**
    * 获取问题的所属的组件
    * @date: 2018年11月26日 下午6:43:06
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function Component(){
        return $this->belongsTo('App\Models\Component','comp_id','id');
    }
    
    
}

?>