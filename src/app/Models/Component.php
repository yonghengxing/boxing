<?php
/**
* 组件模型
* @date: 2018年11月19日 下午4:09:01
* @author: wongwuchiu
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $table = 'component';
    
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
    
    public function Events(){
        return $this->hasMany("App\Models\Event","comp_id","id");
    }
    
    public function Group(){
        return $this->belongsTo("App\Models\Group","group_id","id");
    }

    
    /**
     * 所拥有的权限记录
     * @date: 2018年11月23日 下午8:19:49
     * @author: wongwuchiu
     * @param: variable
     * @return: 获取用户审批过的事件
     */
    public function Authorities(){
        return $this->hasMany("App\Models\CompAuthority","comp_id","id");
    }
    
    
    public function Version(){
        return $this->hasMany("App\Models\Version","comp_id","id");
    }
    
}

?>