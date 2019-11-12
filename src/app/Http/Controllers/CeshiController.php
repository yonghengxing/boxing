<?php
/**
 * User: shoubin@iscas.ac.cn
 * Date: 2018/10/14
 * Time: 17:17
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\View;

use App\Models\Group;
use App\Models\SendRecord;
use App\Services\SendRecordService;
use Illuminate\Http\Request;
use App\Services\GroupService;
use App\Services\UserService;
use App\Services\CompAuthorityService;
use Illuminate\Support\Facades\Auth;
use App\Services\ComponentService;
use App\Services\IpRecordService;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class CeshiController extends BaseController
{
    
    
    function __construct(IpRecordService $ipRecordService,ComponentService $componentService,GroupService $groupService,CompAuthorityService $compAuthorityService,UserService $userService,SendRecordService $sendRecordService){
        //$this->middleware('auth');
        $this->compAuthorityService = $compAuthorityService;
        $this->userService = $userService;
        $this->sendRecordService = $sendRecordService;
        $this->groupService = $groupService;
        $this->componentService = $componentService;
        $this->ipRecordService = $ipRecordService;
        //此时的的 $this->userService相当于实例化了服务容器：UserService
    }
    
    public function ceshi_newrecr(){
//         $ipStr = $this->ipRecordService->getUserIp(2);
//         echo $ipStr;
        $saveRes = $this->ipRecordService->setUserIp(2, "1.0.1.0");
        echo $saveRes;
        
    }
    
    public function ceshi_list()
    {
        $tempPath = "/app/upload/ShouKong/1/1.92";
        $temp_dir = storage_path() . $tempPath;
        $destPath = '/app/upload/wddwdw/abc';
        $dest_dir = storage_path() . $destPath;
        //StepA
        $cmdPath = 'cd ' . $dest_dir . ' && ';
        if(!is_dir($dest_dir))
        {
            mkdir ($dest_dir,0777,true);
            $cmdGitInit = 'git init';
            exec($cmdPath . $cmdGitInit,$ret);
        }
        if(!is_dir($dest_dir . '.git/'))
        {
            $cmdGitInit = 'git init';
            exec($cmdPath . $cmdGitInit,$ret);
        }
        $this->copydir($temp_dir, $dest_dir);
        $description = "烦烦烦啊！";
        $msg = '"' . $description . '"';
        $cmdGitCom = 'git commit -m';
        //echo '<br>执行命令:' . $cmdPath . $cmdGitCom . $msg . '<br>';
        exec($cmdPath . $cmdGitCom . $msg, $ret);
    }
        
    
    
    public function ceshi_import(){
        return view('ceshi/import');
    }
    
    public function ceshi_import_do(Request $request){
        $file = $request->file('doc_form_file');
        $relative_path = $request->get('relative_path');
        $path_array = explode("#$#", $relative_path);
        $tempPath = '/upload/test/';
        $idx = 0;
        foreach ($file as $key => $value) {
            // 判断文件上传中是否出错
            if (!$value->isValid()) {
                exit("上传文件出错，请重试！");
            }
            if(!empty($value)){
                //此处防止没有多文件上传的情况
                $extension = $value->getClientOriginalExtension();   // 上传文件后缀
                $fileName = $value->getClientOriginalName();
                //移动上传文件至目录下
                $mpath = $path_array[$idx];
                $pos= strrpos($mpath,"/");
                $dir = substr($mpath,0,$pos + 1);
                echo $dir . "<br>";
                $value->move(storage_path() . '/app' . $tempPath . $dir, $fileName);
                $idx++;
            }
        }
    }
    
    /**
     * 复制文件夹
     * @date: 2018年11月23日 下午3:26:10
     * @author: wongwuchiu
     * @param: 源路径$source，目的路径$dest
     * @return: null
     */
    function copydir($source, $dest)
    {
        if (!file_exists($dest)) mkdir($dest,0777,true);
        $handle = opendir($source);
        while (($item = readdir($handle)) !== false) {
            if ($item == '.' || $item == '..') continue;
            $_source = $source . '/' . $item;
            $_dest = $dest . '/' . $item;
            if (is_file($_source)){
                copy($_source, $_dest);
                $destPath = '/app/upload/wddwdw/abc';
                $dest_dir = storage_path() . $destPath;
                $cmdGitAdd = 'git add ';
                $cmd = 'cd ' . $dest_dir . ' && ' . $cmdGitAdd . $_dest;
                echo "cmd:" . $cmd . "<br>";
                exec($cmd,$ret);
            }
            if (is_dir($_source)){
                $this->copydir($_source, $_dest);
            }
            
        }
        closedir($handle);
    }
    
    public function duoxuan(Request $request)
    {
        $mComponents = null;
        $select_type = $request->input('type', 0);
        $select_group = $request->input('group', 0);
        $groups = $this->groupService->getAll();
        if($select_type != 0 && $select_group != 0){
            $mComponents = $this->componentService->getAll()->where('comp_type',$select_type)->where('group_id',$select_group);
        } else if($select_type != 0 && $select_group == 0){
            $mComponents = $this->componentService->getAll()->where('comp_type',$select_type);
        } else if($select_group != 0 && $select_type == 0){
            $mComponents = $this->componentService->getAll()->where('group_id',$select_group);
        } else {
            $mComponents = $this->componentService->getAll();
        }
        //         $mComponents = $user->Component;
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mComponents->count();
        $result = $mComponents->sortByDesc("dev_import")->forPage($currentPage, $perPage);
        $components= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        //         dd($components);
        $components->appends(['type'=>$select_type])->appends(['group'=>$select_group])->render();
        return view('/ceshi/duoxuan', compact('components','groups','select_type','select_group'));
    }
    
    /**
     * 获取当前用户可访问的组件列表
     * @date: 2018年11月22日 上午9:20:09
     * @author: wongwuchiu
     * @param: http Request
     * @return: 分页后的组件列表页面
     */
    public function ceshi_complist($select_type,$select_group,Request $request)
    {
        $user = Auth::user();
        $mComponents = null;
        $groups = $this->groupService->getAll();
        if (true){
            if($select_type != 0 && $select_group != 0){
                $mComponents = $this->componentService->getAll()->where('comp_type',$select_type)->where('group_id',$select_group);
            } else if($select_type != 0 && $select_group == 0){
                $mComponents = $this->componentService->getAll()->where('comp_type',$select_type);
            } else if($select_group != 0 && $select_type == 0){
                $mComponents = $this->componentService->getAll()->where('group_id',$select_group);
            } else {
                $mComponents = $this->componentService->getAll();
            }
        } else {
            if($select_type != 0 && $select_group != 0){
                $mComponents = $user->Component->where('comp_type',$select_type)->where('group_id',$select_group);
            } else if($select_type != 0 && $select_group == 0){
                $mComponents = $user->Component->where('comp_type',$select_type);
            } else if($select_group != 0 && $select_type == 0){
                $mComponents = $user->Component->where('group_id',$select_group);
            } else {
                $mComponents = $user->Component;
            }
        }
        //         $mComponents = $user->Component;
        $perPage = 15;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $mComponents->count();
        $result = $mComponents->sortByDesc("appr_status")->sortByDesc("appr_updated")->forPage($currentPage, $perPage);
        $components= new LengthAwarePaginator($result,$total,$perPage,$currentPage,[
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page']);
        return view('ceshi/importd', compact('components','select_type','select_group','groups'));
    }
    
    public function ceshi_getcomps()
    {
        $test = array();
        $select_group = $_POST['group_val'];
        $select_type = $_POST['comp_val'];
        $currentPage = $_POST['page'];
        $user = Auth::user();
        $mComponents = null;
        if (true){
            if($select_type != 0 && $select_group != 0){
                $mComponents = $this->componentService->getAll()->where('comp_type',$select_type)->where('group_id',$select_group);
            } else if($select_type != 0 && $select_group == 0){
                $mComponents = $this->componentService->getAll()->where('comp_type',$select_type);
            } else if($select_group != 0 && $select_type == 0){
                $mComponents = $this->componentService->getAll()->where('group_id',$select_group);
            } else {
                $mComponents = $this->componentService->getAll();
            }
        } else {
            if($select_type != 0 && $select_group != 0){
                $mComponents = $user->Component->where('comp_type',$select_type)->where('group_id',$select_group);
            } else if($select_type != 0 && $select_group == 0){
                $mComponents = $user->Component->where('comp_type',$select_type);
            } else if($select_group != 0 && $select_type == 0){
                $mComponents = $user->Component->where('group_id',$select_group);
            } else {
                $mComponents = $user->Component;
            }
        }
        $perPage = 15;
        $offset = ($currentPage - 1) * $perPage;
        $total = $mComponents->count();
        $results = $mComponents->sortByDesc("appr_status")->sortByDesc("appr_updated")->forPage($currentPage, $perPage);
        $test = [];
        foreach ($results as $result)
        {
            $result->comp_desc = str_limit($result->comp_desc ,100,"...");
            $result->comp_type = config("app.comp_type")[$result->comp_type];
            $result->group_name = $result->group->group_name;
            $str = config("app.comp_status")[$result->appr_status];
            if($result->appr_status == 10001){
                $result->status_str = '<font color="#FF0000">' . $str . '</font>';
            } else {
                $result->status_str = $str;
            }
            $url = asset('/apprvoer/requestlist') . '/' . $result->id;
            $result->url = $url;
            $test[]= $result;
        }
        echo json_encode($test);

    }
}
