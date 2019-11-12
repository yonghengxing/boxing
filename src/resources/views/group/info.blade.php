@extends('template') @section('content')
           <div class="row-content am-cf">
                <div class="row">
                
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">{{$group->name}} 详细信息</div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body am-fr">
                                <form class="am-form tpl-form-border-form">
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-12 am-form-label am-text-left">名称<span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-12">
                                            <input type="text" class="tpl-form-input am-margin-top-xs" id="user-name" placeholder="请输入名称" value="{{$group->name}}" />
                                            <small>请填写用户名10-20字左右。</small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-12 am-u-sm-push-12">
                                            <button type="button" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                                        </div>
                                    </div>
                                 <div class="widget-head am-cf">
                                    <div class="widget-title am-fl">人员列表</div>
                                </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-12 am-form-label am-text-left"></label>
                                     <div class="am-u-sm-12">
                                     <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                        	    <th>ID</th>
                                                <th>用户</th>
                                                <th>类型</th>
                                                <th>邮箱</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($group->users as $user)
                                            <tr class="gradeX">
                                            	<td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{  config("app.user_role")[ $user->user_role] }}</td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                         @endforeach
                                        </tbody>
                                    </table>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
	@stop