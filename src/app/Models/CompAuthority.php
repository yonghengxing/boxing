<?php
/**
 * 组件模型
 * @date: 2018年11月19日 下午4:09:01
 * @author: wongwuchiu
 */
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CompAuthority extends Model
{
    protected $table = 'compauthority';
    
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
    * 授权对应所属组件
    * @date: 2018年11月27日 下午2:40:15
    * @author: wongwuchiu
    * @param: variable
    * @return: 
    */
    public function Component(){
        return $this->belongsTo("App\Models\Component","comp_id","id");
    }
    
    /**
     * 授权对应的用户
     * @date: 2018年11月27日 下午2:40:15
     * @author: wongwuchiu
     * @param: variable
     * @return:
     */
    public function User(){
        return $this->belongsTo("App\User","user_id","id");
    }
    
}

?>