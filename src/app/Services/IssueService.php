<?php
/**
 * 问题service
 * @date: 2018年11月19日 下午5:05:46
 * @author: wongwuchiu
 */
namespace App\Services;
use App\Services\BaseService;
use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class IssueService extends BaseService
{
    function __construct(Issue $issue){
        $this->model = $issue;
    }
    
    /**
     * 向数据库按创建时间和用户获取问题
     * @date: 2018年11月21日 下午8:10:52
     * @author: wongwuchiu
     * @param: 一页显示条数perPage,http的request
     * @return: 一页显示的issue
     */
    public function getIssueByPage($user_id,$perPage,Request $request)
    {
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $this->model->count();
        $result = $this->model->where('dev_id',$user_id)->orwhere('tester_id',$user_id)->orderBy('status')->offset($offset)->limit($perPage)->get();
        $models = new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return $models;
    }
}

?>