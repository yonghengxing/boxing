<?php
/**
 * ��Ʒ�����������
* User: danqi@iscas.ac.cn
* Date: 2018/12/10
* Time: 11:15
*/

namespace App\Models;
use App\Models\ItechsProduct;

use Illuminate\Database\Eloquent\Model;

class ProcToComp extends Model
{
    protected $table = 'proctocomp';
    protected $primaryKey = 'id';
    
    public $timestamps = true;
    
    /**
     * 获取该条记录下相关的文件
     * @date: 2018年11月22日 上午10:39:07
     * @author: wongwuchiu
     * @param: null
     * @return: Events
     */
    public function Files(){
        return $this->hasMany('App\Models\ItechsProduct', 'p2cid', 'id');
    }
    
}

?>