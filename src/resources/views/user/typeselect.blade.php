@extends('template') @section('content')
			<script src="{{asset('lib/js/jquery-3.3.1.min.js')}}"></script> 
			<script src="{{asset('lib/js/jquery.cxselect.js')}}"></script> 
            <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">人员列表</div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body am-fr">
                            	<div class="am-form-group">
                                        <div class="am-u-sm-9">
                                            <select data-am-selected="{searchBox: 1}" style="display: none;"
                            							name="user_type" id="user_type">
                            					<option name="type" value="0" selected="selected">显示全部人员类型</option>
                                				@foreach(config('app.user_role') as $id=> $role)
                                					@if($id == $select_role)
                                						<option name="role" value="{{ $id }}" selected="selected">{{$role }}</option>
                                					@else
                                						<option name="role" value="{{ $id }}">{{ $role }}</option>
                                					@endif
                                				@endforeach
                            				</select>
                            				<select data-am-selected="{searchBox: 1}" style="display: none;"
                            							name="group_choose" id="group_choose">
                            					<option name="type" value="0" selected="selected">显示全部所属公司</option>
                                				@foreach($groups as $group)
                                					@if($group->id == $select_group)
                                						<option name="type" value="{{ $group->id }}" selected="selected">{{$group->group_name }}</option>
                                					@else
                                						<option name="type" value="{{ $group->id }}">{{ $group->group_name }}</option>
                                					@endif
                                				@endforeach
                            				</select>
                                        </div>
                                 </div>
                            </div>
<!--                             <div class="tpl-content-wrapper">@yield('showlist')</div> -->
							                                <div class="am-u-sm-12">
                                    <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                        	    <th>真实姓名</th>
                                        	    <th>用户名</th>
                                                <th>所属单位</th>
                                                <th>类型</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr class="gradeX">
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->true_name }}</td>
                                                @if($user->group_id != 0)
                                                	<td>{{ $user->group->group_name }}</td>
                                                @else
                                                	<td>	</td>
                                                @endif
                                                <td>{{  config("app.user_role")[ $user->user_role] }}</td>
                                                <td>
                                                @if(Auth::user()->admin || config('app.admin_mode',false))
                                                    <div class="tpl-table-black-operation">
                                                    	<a href="{{ asset('authority/userlist')}}/{{$user->id }}">
                                                            <i class="am-icon-pencil"></i> 授权
                                                        </a>
                                                        <a href="{{ asset('user/info')}}/{{$user->id }}">
                                                            <i class="am-icon-pencil"></i> 编辑
                                                        </a>
                                                        <a href="{{ asset('user/delete')}}/{{$user->id }}" class="tpl-table-black-operation-del" onclick="return del()" >
                                                            <i class="am-icon-trash"></i> 删除
                                                            <script> 
																function del(){
																	if(confirm("确定要删除吗？")){
																		alert('删除成功！');
																		return true;
																	}else{
																		return false; 
																	}
																} 
															</script> 
                                                        </a>
                                                    </div>
                                                @endif
                                                </td>
                                            </tr>
                                         @endforeach
                                            
                                            <!-- more data -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="am-u-lg-12 am-cf">
            						<div class="am-fr">
            							<link rel="stylesheet" href="{{asset('css/app.css')}}">
            							{{ $users->links() }}
            						</div>
            					</div>
                                    
                                  
                                
							<script type="text/javascript">
    							$(function(){
    								$("#user_type").change(function(){
    									var group_val = document.getElementById("group_choose").value;
    									var value = $(this).val();
    									var str1 = "{{asset('user/role')}}";
    									var url = str1 + '/' + value + '/' + group_val;
    									window.location.href= url;
    								});
    								$("#group_choose").change(function(){
    									var user_val = document.getElementById("user_type").value;
    									var value = $(this).val();
    									var str1 = "{{asset('user/role')}}";
    									var url = str1 + '/' + user_val + '/' + value;
    									window.location.href= url;
    								});
    							});
							</script>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
@stop
