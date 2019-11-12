<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'user';
    
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
    * 获取用户有权限访问的组件
    * @date: 2018年11月21日 下午9:20:37
    * @author: wongwuchiu
    * @param: 组件列表
    * @return: 
    */
    public function Component(){
        return $this->belongsToMany('App\Models\Component', 'compauthority', 'user_id', 'comp_id');
    }

    
    /**
    * 获取用户所属公司
    * @date: 2018年11月21日 下午9:20:37
    * @author: wongwuchiu
    * @param: 所属公司id
    * @return: 
    */
    public function Group(){
        return $this->belongsTo('App\Models\Group', 'group_id', 'id');
    }
    
    /**
    * 所属审批节点
    * @date: 2018年11月22日 上午10:39:55
    * @author: wongwuchiu
    * @param: null
    * @return: 获取所属的审批节点
    */
    public function ApprGroup(){
        return $this->hasMany("App\Models\ApprGroup","approver_id","id");
    }
    
    /**
    * 所拥有的审批记录
    * @date: 2018年11月23日 下午8:19:49
    * @author: wongwuchiu
    * @param: variable
    * @return: 获取用户审批过的事件
    */
    public function ApprRecords(){
        return $this->hasMany("App\Models\ApprRecord","approver","id");
    }
    
    /**
     * 所拥有的权限记录
     * @date: 2018年11月23日 下午8:19:49
     * @author: wongwuchiu
     * @param: variable
     * @return: 获取用户审批过的事件
     */
    public function Authorities(){
        return $this->hasMany("App\Models\CompAuthority","user_id","id");
    }
    
}
