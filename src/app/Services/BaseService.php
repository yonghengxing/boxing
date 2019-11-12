<?php
namespace App\Services;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

abstract class BaseService {
	/**
	 * The Model instance.
	 *
	 * @var Illuminate\Database\Eloquent\Model
	 */
	protected $model;
	/**
	 * Get number of records.
	 *
	 * @return array
	 */
	public function getNumber()
	{
		$total = $this->model->count();
		$new = $this->model->whereSeen(0)->count();
		return compact('total', 'new');
	}
	/**
	 * Destroy a model.
	 *
	 * @param  int $id
	 * @return void
	 */
	public function delete($id)
	{
		$ret = $this->getById($id)->delete();
		return $ret;      //18_10_30。增加删除返回值
	}
	/**
	 * Get Model by id.
	 *
	 * @param  int  $id
	 * @return App\Models\Model
	 */
	public function getById($id)
	{
		return $this->model->findOrFail($id);
	}
	
	public function getAll()
	{
	    $models=  $this->model->all();
	    return $models;
	}
	
	/**
	* 向数据库追加记录
	* @date: 2018年11月21日 下午8:10:52
	* @author: wongwuchiu
	* @param: 要追加的model
	* @return: 添加是否成功结果
	*/
	public function append($tModel)
	{
	    $ret=  $tModel->save();
	    return $ret;
	}
	
	/**
	 * 向数据库更新记录
	 * @date: 2018年11月21日 下午8:10:52
	 * @author: wongwuchiu
	 * @param: 要更新的model
	 * @return: 更新是否成功结果
	 */
	public function update($tModel)
	{
	    $ret=  $tModel->save();
	    return $ret;
	}
	
	/**
	 * 向数据库按更新时间倒序获取模型
	 * @date: 2018年11月21日 下午8:10:52
	 * @author: wongwuchiu
	 * @param: 一页显示条数perPage,http的request
	 * @return: 一页显示的model
	 */
	public function getAllByPage($perPage,Request $request)
	{
	    $currentPage = $request->input('page', 1);
	    $offset = ($currentPage - 1) * $perPage;
	    $total = $this->model->count();
	    $result = $this->model->orderBy('updated_at','desc')->offset($offset)->limit($perPage)->get();
	    $models = new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
	        'path' => Paginator::resolveCurrentPath(),
	        'pageName' => 'page']);
	    return $models;
	}
	
	/**
	 * 向数据库追加记录并获取添加后的id
	 * @date: 2018年11月21日 下午8:10:52
	 * @author: wongwuchiu
	 * @param: 要追加的model
	 * @return: 添加成功返回id，否则返回0
	 */
	public function appendID($tModel)
	{
	    $res =  $tModel->save();
	    $id = 0;
	    if($res){
	        $id = $tModel->id;
	    }
	    return $id;
	}
}
?>