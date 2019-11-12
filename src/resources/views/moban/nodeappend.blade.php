@extends('template') @section('content')
<script src="{{asset('lib/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('lib/js/jquery.cxselect.js')}}"></script>
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">为节点 {{$node->node_name}} 增加可访问人员</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action="{{ asset('moban/nodeappend')}}/{{$node->id}}" method="post"
						enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="hidden" name="approver_num" id="approver_num" value="1" />
							<div class="widget-body am-fr" id="showApprover">
								<div class="am-form-group" index="1" id="approver1">
									<label class="am-u-sm-3 am-form-label">用户(1)</label>
									<div class="am-u-sm-9">
										<select data-am-selected="{searchBox: 1}" id="approver_1"
											name="approver_1">
											@foreach($approvers as $approver)
												<option value="{{ $approver->id }}">{{ $approver->true_name }}</option>
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
													onclick="addApprover();">
													<span class="am-icon-plus"></span> 追加用户
												</button>
												<button type="button"
													class="am-btn am-btn-default am-btn-danger"
													onclick="deleteApprover();">
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
								
								var approverIndex = 1;
								function addApprover()
 								{
									approverIndex++;
									var str = '<div class="am-form-group" index="1" id="approver'+
									approverIndex + '"><label class="am-u-sm-3 am-form-label">用户('+
									approverIndex + ')</label><div class="am-u-sm-9"><select data-am-selected="{searchBox: 1}" id="approver_'+
									approverIndex + '"name="approver_'+
									approverIndex + '">@foreach($approvers as $approver)<option value="{{ $approver->id }}">{{ $approver->true_name }}</option>@endforeach</select></div></div>';
									$("#showApprover").append(str);
									var approver_num = document.getElementById("approver_num");
									approver_num.value = approverIndex;
                                }
								function deleteApprover()
								{
									if(approverIndex < 1){
									return;
									}
									$("#approver"+approverIndex).remove();
									approverIndex--;
									var approver_num = document.getElementById("approver_num");
									approver_num.value = approverIndex;
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
