@extends('template') 
@section('content')
           <div class="row-content am-cf">
                <div class="row">
                
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">用户详细信息</div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body am-fr">

                                <form class="am-form tpl-form-border-form" action="{{ asset('/user/info')}}/{{$user->id }}" method="post" onsubmit="return checkForm()">
                                	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                	<div class="am-form-group">
                                        <label  class="am-u-sm-3 am-form-label">用户名<span class="tpl-form-line-small-title">  User Name</span></label>
                                        <div class="am-u-sm-9">
                                             {{$user->username}}
                                        </div>
                                    </div>
                                	<div class="am-form-group">
                                        <label  class="am-u-sm-3 am-form-label">真实姓名 <span class="tpl-form-line-small-title">  True Name</span></label>
                                        <div class="am-u-sm-9">
                                             <input type="text" class="tpl-form-input" id="truename" name="truename" placeholder="请输入人员真实姓名 " value="{{$user->true_name}}">
                                            <small>中文、字母</small>
                                        </div>
                                    </div>
									<div class="am-form-group">
                                        <label  class="am-u-sm-3 am-form-label">人员属性 <span class="tpl-form-line-small-title">  Role</span></label>
                                        <div class="am-u-sm-9">
											@foreach(config('app.user_role') as $id=> $role)
                                         		<label class="am-radio-inline">
                                         			@if($user->user_role == $id)                                            			
                                            			<input type="radio"  name="role" value="{{ $id }}" data-am-ucheck checked>{{ $role }}
                                            		@else
                                            			<input type="radio"  name="role" value="{{ $id }}" data-am-ucheck>{{ $role }}
                                            		@endif
                                         		</label>
                                         	@endforeach
                                        </div>
                                    </div>
                                    <div class="am-form-group" id="pre_app" >
                                        <label  class="am-u-sm-3 am-form-label">所在公司<span class="tpl-form-line-small-title">  Group</span></label>
                                        <div class="am-u-sm-9">
                                            <select data-am-selected="{searchBox: 1}" style="display: none;" id="group_id" name="group_id">
                                            	@foreach($groups as $id=> $group)
                                            	@if($group->id == $user->group_id)
                                            		<option value="{{ $group->id }}" selected = "selected">{{ $group->group_name }}</option>
                                            	@else
                                            		<option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                            	@endif
                                            	@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label  class="am-u-sm-3 am-form-label">密码 <span class="tpl-form-line-small-title">  Password</span></label>
                                        <div class="am-u-sm-9">
                                             <input type="password" class="tpl-form-input" id="pwd" name="pwd" placeholder="请输入密码">
                                            <small>请填写 密码10-20字左右</small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label  class="am-u-sm-3 am-form-label">重复密码<span class="tpl-form-line-small-title">  Repeat</span></label>
                                        <div class="am-u-sm-9">
                                             <input type="password" class="tpl-form-input" id="pwd2" name="pwd2" placeholder="请再次输入密码">
                                            <small>请填写 密码10-20字左右</small>
                                        </div>
                                    </div>

                                    <div class="am-form-group">
                                        <div class="am-u-sm-12 am-u-sm-push-12">
                                            <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">修改</button>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
										function checkForm(){
											var nameText = document.getElementById("username").value;
											if ( nameText == "" || nameText == null ){
													alert("请输入用户名！");
													return false;
											}
											var roleCheck=$('input:radio[name="role"]:checked').val();
								            if(roleCheck == null){
								                alert("请选中人员属性!");
								                return false;
								            }
											var pwdText1 = document.getElementById("pwd").value;
											var pwdText2 = document.getElementById("pwd2").value;
											if ( pwdText1 == "" || pwdText1 == null ){
												alert("请输入密码！");
												return false;
											}
											if (pwdText1.length<10 || pwdText1.length>20){
												alert("密码请控制在10~20位！");
												return false;
											}
											if ( pwdText1!= pwdText2 ){
												alert("两次输入密码不一致！");
												return false;
											}
											return true;
										}
									</script>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
@stop
