<?php
/**
 * Created by ZenStudio
 * User: shoubin@iscas.ac.cn
 * Date: 2018/06/14
 * Time: 17:17
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * define a $primaryKey property to override this convention.
     * the primary key is an incrementing integer value
     *
     * @var int
     */
    protected $primaryKey = 'id';
    
    public function Owner(){
        return $this->belongsTo('App\Models\User', 'creator_id','id');
    }
    
    /**
     * 一个项目只属于一个组
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Group()
    {
        return $this->belongsTo('App\Models\Group', 'group_id','id');
    }
    
    /**
     * 一个项目有多个commit
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Commits()
    {
        return $this->hasMany('App\Models\Commit','project_id','id');
    }
    
    
    /**
     * 一个项目有多个commit
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Issues()
    {
        return $this->hasMany('App\Models\Issue','project_id','id');
    }
   
}