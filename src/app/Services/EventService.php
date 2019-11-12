<?php
/**
 * 用户状态service
 * @date: 2018年11月19日 下午5:05:46
 * @author: wongwuchiu
 */
namespace App\Services;
use App\Services\BaseService;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Event;
use Illuminate\Http\Request;

class EventService extends BaseService
{
    function __construct(Event $event){
        $this->model = $event;
    }
    
//     function getByUser($user_id,$perPage,Request $request){
//         $currentPage = $request->input('page', 1);
//         $offset = ($currentPage - 1) * $perPage;
//         $total = $this->model->count();
//         $result = $this->model->where('user_id',$user_id)->orderBy('updated_at','desc')->offset($offset)->limit($perPage)->get();
//         $models = new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
//             'path' => Paginator::resolveCurrentPath(),
//             'pageName' => 'page']);
//         return $models;
//     }
    
    function getByUserPage($user_id,$perPage,Request $request){
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $this->model->count();
        $result = $this->model->where('user_id',$user_id)->orderBy('updated_at','desc')->offset($offset)->limit($perPage)->get();
        $models = new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return $models;
    }
    
    
    function getByApprPage($comp_id,$perPage,Request $request){
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $this->model->count();
        $result = $this->model->where('comp_id',$comp_id)->where('type' , '>' ,10000)->orderBy('has_assigned')->orderBy('updated_at','desc')->offset($offset)->limit($perPage)->get();
        $models = new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return $models;
    }
    
    function getByTestPage($comp_id,$perPage,Request $request){
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $this->model->count();
        $result = $this->model->where('comp_id',$comp_id)->where('type' , 2000)->orderBy('has_assigned')->orderBy('updated_at','desc')->offset($offset)->limit($perPage)->get();
        $models = new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return $models;
    }

    function getByTesterPage($user_id,$perPage,Request $request){
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $this->model->count();
        $result = $this->model->where('user_id',$user_id)->where('type' , 2000)->orderBy('updated_at','desc')->offset($offset)->limit($perPage)->get();
        $models = new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return $models;
    }
    
    function getByDevPage($user_id,$perPage,Request $request){
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $this->model->count();
        $result = $this->model->where('user_id',$user_id)->where('type' , 1000)->orderBy('updated_at','desc')->offset($offset)->limit($perPage)->get();
        $models = new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return $models;
    }
    
    function getByApprStatus($comp_id){
        $result = $this->model->where('comp_id',$comp_id)->where('type' , '>' ,10000)->where('has_assigned',0)->get();
        return $result;
    }
    
}

?>