@extends('template') @section('content')
<script src="{{asset('lib/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('lib/js/jquery.cxselect.js')}}"></script>
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">为组件 {{$component->comp_name}} 增加可访问用户</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action="{{ asset('authority/compappend')}}/{{$component->id}}" method="post"
						enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="hidden" name="user_num" id="user_num" value="1" />
							<div class="widget-body am-fr" id="showUser">
								<div class="am-form-group" index="1" id="user1">
									<label class="am-u-sm-3 am-form-label">用户(1)</label>
									<div class="am-u-sm-9">
										<select data-am-selected="{searchBox: 1}" id="user_1"
											name="user_1">
											@foreach($users as $user)
												<option value="{{ $user->id }}">{{ $user->true_name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								
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
										class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
									</div>
								</div>
							</div>



							<script type="text/javascript">
								
								var userIndex = 1;
								function addUser()
 								{
									userIndex++;
									var str = '<div class="am-form-group" index="'+
									 userIndex + '" id="user'+
									 userIndex + '"><label class="am-u-sm-3 am-form-label">用户('+
									 userIndex + ')</label><div class="am-u-sm-9"><select data-am-selected="{searchBox: 1}" id="user_'+
									 userIndex + '" name="user_'+
									 userIndex + '">@foreach($users as $user)<option value="{{ $user->id }}">{{ $user->true_name }}</option>@endforeach</select></div></div>';
									$("#showUser").append(str);
									var user_num = document.getElementById("user_num");
									user_num.value = userIndex;
                                }
								function deleteUser()
								{
									if(userIndex < 1){
									return;
									}
									$("#user"+userIndex).remove();
									userIndex--;
									var user_num = document.getElementById("user_num");
									user_num.value = userIndex;
								}
							</script>
						</div>

							
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
