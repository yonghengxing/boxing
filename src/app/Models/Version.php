<?php
/**
 * Created by ZenStudio
 * User: shoubin@iscas.ac.cn
 * Date: 2018/06/14
 * Time: 17:17
 */
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $table = 'version';
    
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
     * related project
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function Project()
    {
        return $this->belongsTo('App\Models\Project','project_id','id');
    }
    
    public function component()
    {
        return $this->hasMany('App\Models\Component','id','comp_id');
    }
    
}

?>