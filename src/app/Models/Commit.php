<?php
/**
 * Created by ZenStudio
 * User: shoubin@iscas.ac.cn
 * Date: 2018/06/14
 * Time: 17:17
 */
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    protected $table = 'commit';

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
    
    /**
     * related project 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function Project()
    {
        return $this->belongsTo('App\Models\Project','project_id','id');
    }
    
    /**
     * related group
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function Group()
    {
        return $this->belongsTo('App\Models\Group','group_id','id');
    }
    
    /**
     * related person
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function User()
    {
        return $this->belongsTo('App\Models\User','user_email','email');
    }
    

}