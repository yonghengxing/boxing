<?php
/**
* 处理用户登录和登出
* @date: 2018年11月14日 下午7:08:13
* @author: wongwuchiu
*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Requests;
use Auth;
use Redirect;
use Illuminate\Http\Request;


class BXUserController extends Controller{
    
    /**
    * 用户登录
    * @date: 2018年11月14日 下午7:08:52
    * @author: wongwuchiu
    * @param:Request 
    * @return: 登陆成功后跳转主页，否则继续登录
    */
    public function bxLogin(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = $this->validateLogin($request->input());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            if (Auth::guard('web')->attempt($this->validateUser($request->input()))) {
                return Redirect::to('/index');
            }else {
                return back()->with('error', '账号或密码错误')->withInput();
            }
        }
        return view('auth.login');
    }
    
    /**
     * 验证器：用以验证输入的用户名和密码
     * @date: 2018年11月14日 下午7:08:52
     * @author: wongwuchiu
     * @param:输入数据 $data
     * @return: 验证器
     */
    protected function validateLogin(array $data)
    {
        return Validator::make($data, [
            'email' => 'required',
            'password' => 'required',
        ], [
            'required' => ':attribute 为必填项',
            'min' => ':attribute 长度不符合要求'
        ], [
            'email' => '邮箱',
            'password' => '密码'
        ]);
    }
    
    /**
     * 验证输入的用户名和密码
     * @date: 2018年11月14日 下午7:08:52
     * @author: wongwuchiu
     * @param:输入数据 $data
     * @return: 验证结果
     */
    protected function validateUser(array $data)
    {
        return [
            'email' => $data['email'],
            'password' => $data['password']
        ];
    }
   
    /**
    * 用户登出
    * @date: 2018年11月14日 下午7:11:43
    * @author: wongwuchiu
    * @param: null
    * @return: 返回首页
    */
    public function bxLogout()
    {
        if(Auth::check()){
            Auth::logout();
            return Redirect::to('/login');
        }
        //echo '退出方法错误！！！';
    }
    
}