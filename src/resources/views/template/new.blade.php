@extends('template') @section('content')
<script src="{{asset('lib/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('lib/js/jquery.cxselect.js')}}"></script>
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">为{{config("app.comp_type")[$comp_type]}}组件增加新模板</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action="{{ asset('template/new')}}/{{$comp_type}}" method="post"
						enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="hidden" name="node_num" id="node_num" value="1" />
							<div class="widget-body am-fr" id="showNode">
								<div class="am-form-group" index="1" id="node1">
									<label class="am-u-sm-3 am-form-label">审批节点(1)   名称:</label>
									<div class="am-u-sm-9">
										<input type="text" class="tpl-form-input" id="node_1"  name="node_1" placeholder="请输入新的节点名称">
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
													onclick="addNode();">
													<span class="am-icon-plus"></span> 追加审批节点
												</button>
												<button type="button"
													class="am-btn am-btn-default am-btn-danger"
													onclick="deleteNode();">
													<span class="am-icon-trash-o"></span> 删除审批节点
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
								
								var nodeIndex = 1;
								function addNode()
 								{
									nodeIndex++;
// 									var str = '<div class="am-form-group" index="1" id="node'+
// 										nodeIndex + '"><label class="am-u-sm-3 am-form-label">审批节点('+
// 										nodeIndex + ')   名称:</label><div class="am-u-sm-9"><input type="text" class="tpl-form-input" id="node_'+
// 										nodeIndex + '"  name="node_'
// 										nodeIndex + '" placeholder="请输入新的节点名称"></div></div>';
									var str = '<div class="am-form-group" index="'+
									nodeIndex + '" id="node'+
									nodeIndex + '"><label class="am-u-sm-3 am-form-label">审批节点('+
									nodeIndex + ')   名称:</label><div class="am-u-sm-9"><input type="text" class="tpl-form-input" id="node_'+
									nodeIndex + '"  name="node_'+
									nodeIndex + '" placeholder="请输入新的节点名称"></div></div>';
									$("#showNode").append(str);
									var node_num = document.getElementById("node_num");
									node_num.value = nodeIndex;
                                }
								function deleteNode()
								{
									if(nodeIndex < 1){
									return;
									}
									$("#node"+nodeIndex).remove();
									nodeIndex--;
									var node_num = document.getElementById("node_num");
									node_num.value = nodeIndex;
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
