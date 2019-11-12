@extends('template') @section('content')
<script src="{{asset('lib/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('lib/js/jquery.cxselect.js')}}"></script>
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">为用户 {{$user->true_name}} 增加可访问的组件</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action="{{ asset('authority/userappend')}}/{{$user->id}}" method="post"
						enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="hidden" name="comp_num" id="comp_num" value="1" />
							<div class="widget-body am-fr" id="showComp">
								<div class="am-form-group" index="1" id="comp1">
									<label class="am-u-sm-3 am-form-label">组件(1)</label>
									<div class="am-u-sm-9">
										<select data-am-selected="{searchBox: 1}" id="comp_1"
											name="comp_1">
											@foreach($components as $component)
												<option value="{{ $component->id }}">{{ $component->comp_name }}</option>
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
													onclick="addComp();">
													<span class="am-icon-plus"></span> 追加组件
												</button>
												<button type="button"
													class="am-btn am-btn-default am-btn-danger"
													onclick="deleteComp();">
													<span class="am-icon-trash-o"></span> 删除组件
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
								
								var compIndex = 1;
								function addComp()
 								{
									compIndex++;
									var str = '<div class="am-form-group" index="'+
									 compIndex + '" id="comp'+
									 compIndex + '"><label class="am-u-sm-3 am-form-label">组件('+
									 compIndex + ')</label><div class="am-u-sm-9"><select data-am-selected="{searchBox: 1}" id="comp_'+
									 compIndex + '" name="comp_'+
									 compIndex + '">@foreach($components as $component)<option value="{{ $component->id }}">{{ $component->comp_name }}</option>@endforeach</select></div></div>';
									$("#showComp").append(str);
									var comp_num = document.getElementById("comp_num");
									comp_num.value = compIndex;
                                }
								function deleteComp()
								{
									if(compIndex < 1){
									return;
									}
									$("#comp"+compIndex).remove();
									compIndex--;
									var comp_num = document.getElementById("comp_num");
									comp_num.value = compIndex;
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
