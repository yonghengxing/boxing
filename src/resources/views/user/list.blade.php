@extends('template') @section('content')
  <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title  am-cf">用户列表</div>
                            </div>
                            <div class="widget-body  am-fr">

                               
                                <div class="am-u-sm-12 am-u-md-12 am-u-lg-3">
                                    <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                                  		<a   href="{{ asset('/user/new')}}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增</a>
                                    
                                    </div>
                                </div>

                                <div class="am-u-sm-12">
                                    <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                        	    <th>ID</th>
                                        	    <th>用户名</th>
                                                <th>真实姓名</th>
                                                <th>所属单位</th>
                                                <th>类型</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr class="gradeX">
                                            	<td>{{ $user->id }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->true_name }}</td>
                                                @if($user->group_id != 0)
                                                	<td>{{ $user->group->group_name }}</td>
                                                @else
                                                	<td>    </td>
                                                @endif
                                                <td>{{  config("app.user_role")[ $user->user_role] }}</td>
                                                <td>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@stop
