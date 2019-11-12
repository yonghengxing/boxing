@extends('template') @section('content')
<script src="{{asset('lib/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('lib/js/jquery.cxselect.js')}}"></script>
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action="{{ asset('moban/new')}}/{{$comp_type}}/{{$action_type}}/{{$level}}" method="post"
						enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="hidden" name="user_num" id="user_num" value="1" />
							<input type="hidden" name="append_finish" id="append_finish" value="1" />
							<div class="am-form-group">
                            	<label  class="am-u-sm-3 am-form-label">节点名<span class="tpl-form-line-small-title">  User Name</span></label>
                                <div class="am-u-sm-9">
                            		<input type="text" class="tpl-form-input" id="node_name"  name="node_name" placeholder="请输入节点名字">
                                </div>
                            </div>
							<div class="am-form-group">
    							<label class="am-u-sm-3 am-form-label">选择人员类型 <span
    								class="tpl-form-line-small-title"> Type</span></label>
    							<div class="am-u-sm-9">
    								<select data-am-selected="{searchBox: 1}" style="display: none;"
    									name="user_type" id="user_type">
    									@foreach(config('app.user_role') as $id=> $type)
    										<option name="type" value="{{ $id }}">{{ $type }}</option>
    									@endforeach
    								</select>
    							</div>
    						</div>
							<div class="widget-body am-fr" id="showUser">
								
							</div>
						</div>
						<div class="am-form-group" index="1">
								<label for="user-name" class="am-u-sm-3 am-form-label"></label>
								<div class="am-u-sm-9">
									<div class="am-form-group">
										<div class="am-btn-toolbar">
											<div class="am-btn-group am-btn-group-xs">
												<button type="button"
													class="am-btn am-btn-default am-btn-success"
													onclick="addUser();">
													<span class="am-icon-plus"></span> 追加用户
												</button>
												<button type="button"
													class="am-btn am-btn-default am-btn-danger"
													onclick="deleteUser();">
													<span class="am-icon-trash-o"></span> 删除用户
												</button>
											</div>
										</div>
									</div>
								</div>
								<div class="am-form-group">
									<div class="am-u-sm-9 am-u-sm-push-3">
									
									<button type="submit"
										class="am-btn am-btn-primary tpl-btn-bg-color-success " onclick = 'return appendFinish("0")'>继续追加节点</button>
									
									<button type="submit"
										class="am-btn am-btn-danger tpl-btn-bg-color-success " onclick = 'return appendFinish("1")'>模板建立完成</button>
									
									</div>
								</div>
							</div>



							<script type="text/javascript">
								
								var userIndex = 0;
								function appendFinish(i){
									var append_finish = document.getElementById("append_finish");
									append_finish.value = i;
									return true

								}
								
								function addUser()
 								{
									var objectModel = {};
							        var user_type = document.getElementById("user_type").value;
							        objectModel["user_type"] = user_type;
							        var csrf = "_token";
	                        		var ctoken = "{{csrf_token()}}";
	                        		objectModel[csrf] = ctoken;
							        $.ajax({
							            url:"{{url('/moban/getusers')}}", //你的路由地址
							            type:"post",
							            dataType:"json",
							            data:objectModel,
							            timeout:30000,
							            success:function(data){
							                var count = data.length;
							                var i = 0;
							                var x="";
							                for(i=0;i<count;i++){
							                       x+='<option value="'+data[i].id+'">'+data[i].true_name+'</option>';
							                }
							                userIndex++;
							                var str = '<div class="am-form-group" index="1" id="user'+
											userIndex + '"><label class="am-u-sm-3 am-form-label">用户('+
											userIndex + ')</label><div class="am-u-sm-9"><select data-am-selected="{searchBox: 1}" id="user_' + 
											userIndex + '"name="user_'+
											userIndex + '">'+ x +'</select></div></div>';
											$("#showUser").append(str);
											var user_num = document.getElementById("user_num");
											user_num.value = userIndex;
							            }
							        });
                                }
								function deleteUser()
								{
									if(userIndex < 0){
									return;
									}
									$("#user"+userIndex).remove();
									userIndex--;
									var user_num = document.getElementById("user_num");
									user_num.value = userIndex;
								}
								$(function(){
									$("#user_type").change(function(){
										while(userIndex != 0){
											deleteUser();
										}
									});
								});
							</script>
						</div>

							
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
