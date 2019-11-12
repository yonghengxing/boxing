<?php
/**
 * User: shoubin@iscas.ac.cn
 * Date: 2018/10/14
 * Time: 17:17
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use \App\Services\ProjectService;
use \App\Services\GroupService;
use Log;
use Carbon\Carbon;
use App\Models\Project;

class ApplicationController extends BaseController
{
    function __construct(ProjectService $appService,GroupService $groupService){
        $this->appService=$appService;
        $this->groupService=$groupService;
        //此时的的 $this->userService相当于实例化了服务容器：UserService
        
        //echo Carbon::parse('2016-10-15 00:10:25')->toDateTimeString(); 
    }
    

    /**
     * 产品列表
     * @return unknown
     */
    public function app_list()
    { 
        $projects =  $this->appService->getProjectList();
        return view('application/list',compact('projects'));
    }
    
    /**
     * 创建新产品
     * @return unknown
     */
    public function app_new()
    {
        $groups =  $this->groupService->getGroupList();
        return view('application/new',compact('groups'));
    }
    
    /**
     * 删除产品
     * @return unknown
     */
    public function app_delete($app_id)
    {
        Log::debug('delete app.id = ' . $app_id);
        $ret = $this->appService->deleteProject($app_id);
        $url="app/list";
        if($ret){
            return view('success', compact("url"));
        }else{
            return view('error', compact("url"));
        }
    }
    
    /**
     * 创建产品 Post响应存储
     * @return unknown
     */
    public function app_new_do(Request $request)
    {
        Log::debug('app.name: ' . $request->get("app_name"));
        Log::debug('app.desc: ' . $request->get('app_desc'));
        Log::debug('app.group_id: ' . $request->get("group_id"));
        $app_name = $request->get("app_name");
        $app_desc = $request->get("app_desc");
        $app_group_id= $request->get("group_id");
        
        $creator_id = 28;
        
        
        $project = new Project();
        $project->name = $app_name;
        $project->description= $app_desc;
        $project->group_id = $app_group_id;
        $project->created_at = Carbon::now();
        $project->creator_id= $creator_id;
        $ret = $this->appService->addProject($project);
        $url="app/list";
        if($ret){
            return view('success', compact("url"));
        }else{
            return view('error', compact("url"));
        }
    }
    
    
    /**
     * 出库申请
     * @return unknown
     */
    public function app_request_new()
    {
        
        return view('application/request');
    }
    
     
    
    /**
     *  入库
     * @return unknown
     */
    public function app_import()
    {
        return view('application/import');
    }
    
    /**
     * 入库请求后端处理
     * @param Request $request
     * @return boolean[]|string[]|number[]
     */
    public function app_import_do(Request $request)
    {
        //upload more than one file
        $file = $request->file('appfile');
        Log::debug('app.file : ' . $file->getClientOriginalName());
//         $allowed_extensions = ["png", "jpg", "gif"];
//         if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
//             return Response::json(['success' => false,'error' => '你只能上传png,jpg或者gif']);
//         }
        $destinationPath = 'uploads/';
        $extension = $file->getClientOriginalExtension();
        $fileName =  $file->getClientOriginalName();
        $file->move($destinationPath, $fileName);
        $id = 1;
        return 
            [
                'success' => true,
                'pic' => asset($destinationPath.$fileName),
                'id' => $id
            ]
            ;
    }
    
    /**
     * 入库请求列表
     * @return unknown
     */
    public function app_import_list()
    {
        return view('application/importlist');
    }
    
    /**
     * 发起入库申请
     * @param unknown $request_type
     * @return unknown
     */
    public function app_request($request_type)
    {
        $projects =  $this->appService->getProjectList();
        $title = '';
        if ($request_type == "import"){
            $title = '产品入库申请';
            return view('application/request',compact('title','projects'));
        }else if ($request_type == "export"){
            $title = '产品出库申请'; //requestexport
            return view('application/requestexport',compact('title','projects'));
        }
    }
    
    
    /**
     * 出库列表
     * @param unknown $request_type
     * @return unknown
     */
    public function app_export_list()
    {
        return view('application/exportlist');
    }
    
    public function app_request_list()
    {
        return view('application/requestlist');
    }
    
    public function app_request_deal()
    {
        return view('application/requestdealwith');
    }

}
