<?php
/**
 * Created by ZenStudio
 * User: shoubin@iscas.ac.cn
 * Date: 2018/06/14
 * Time: 17:17
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Input;
use App\Repositories\AttendanceRepository;
use App\Repositories\CheckRepository;
use App\Models\User;


class CodeController extends BaseController
{
    
    public function index()
    {
           //Project
           //Commit
           
    }
    
    /**
     * 用户A 按时间分布展示 代码提交量、commit 提交次数。 数据合计：用户合计提交代码次数，合计提交commit次数，过去一周内的平均值。
     * @return unknown
     */
    public function user()
    {
     //   $c = \App\Models\Commit::find(1);
     //   echo $c->user->id ." <br/>";
        $user = User::find(1);
        //var_dump($user);
        foreach ( $user->Commits as $p){
            //echo ($p->commit_info)." <br/>";;
        }
       
        return view('code.user');
    }
    
    /**
     *  用户A 数据详细展示，按照项目展示上面的这个图表
     * @return unknown
     */
    public function userInfo()
    {
        
        return view('code.userinfo');
    }
    
    
    /**
     * 项目P 按时间分布展示 代码提交量、commit 提交次数。 数据合计：项目合计提交代码次数，合计提交commit次数，过去一周内的平均值。
     * @return unknown
     */
    public function project()
    {
        return  view("code.project");
    }
    
    /**
     * 项目P  数据详细展示，按照项目展示上面的这个图表
     * @return unknown
     */
    public function projectInfo()
    {
        return view('code.projectinfo');
    }
    
}