<?php
/**
 * Created by ZenStudio
 * User: shoubin@iscas.ac.cn
 * Date: 2018/06/14
 * Time: 17:17
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

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
     * related group
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function Group()
    {
        return $this->belongsTo('App\Models\Group','group_id','id');
    }
}