@extends('template') @section('content')
<script src="{{asset('lib/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('lib/js/jquery.cxselect.js')}}"></script>
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">审批模板展示</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action="" method="post" enctype="multipart/form-data">
						<div class="am-form-group">
							<label class="am-u-sm-3 am-form-label">选择组件类型 <span
								class="tpl-form-line-small-title"> Type</span></label>
							<div class="am-u-sm-9">
								<select data-am-selected="{searchBox: 1}" style="display: none;"
									name="comp_type" id="comp_type">
									@foreach(config('app.comp_type') as $id=> $type) @if($id ==
									$select_type)
									<option name="type" value="{{ $id }}" selected="selected">{{
										$type }}</option> @else
									<option name="type" value="{{ $id }}">{{ $type }}</option>
									@endif @endforeach
								</select>
								@if($nodes->count() != 0)
								<button type="button"  onclick="return del()"
									class="am-btn am-btn-danger tpl-btn-bg-color-success">删除模板</button>
								<script> 
									function del(){
										if(confirm("确定要删除吗？")){
											alert('删除成功！');
											return window.location.href="{{asset('/template/delete')}}/{{$select_type}}";
										}else{
											return false; 
										}
									} 
								</script> 
								@endif
							</div>
						</div>
						@if($nodes->count() != 0)
						<div class="widget-body  am-fr">
							<div class="am-u-sm-12">
								<table width="100%"
									class="am-table am-table-compact am-table-striped tpl-table-black "
									id="example-r">
									<thead>
										<tr>
											<th>节点层次</th>
											<th>节点名</th>
											<th>最高层次</th>
											<th>创建日期</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										@foreach($nodes as $node)
										<tr class="gradeX">
											<td>{{ $node->level }}</td>
											<td>{{ $node->node_name }}</td>
											<td>{{ $node->max_level }}</td>
											<td>{{ $node->created_at }}</td>
											<td>
												<div class="tpl-table-black-operation">
													<a href="{{asset('/template/node')}}/{{$node->id}}"> <i
														class="am-icon-pencil"></i> 详情 
												
												</div>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						@else
						<div class="widget-body am-fr">
							<div class="am-form-group" id="pre_app">
								<label class="am-u-sm-3 am-form-label">组件没有模板，请 <span
									class="tpl-form-line-small-title"></span></label>
								<div
									class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
									<a href="{{asset('/template/new')}}/{{$select_type}}"
										class="am-btn am-btn-default am-btn-success"><span
										class="am-icon-plus"></span> 新增模板</a>
								</div>
							</div>
						</div>
						@endif
					</form>
				</div>
				<script type="text/javascript">
					$(function(){
						$("#comp_type").change(function(){
							var value = $(this).val();
							var str1 = "{{asset('template/show')}}";
							var url = str1 + '/' + value;
							window.location.href= url;
						});
					})
				</script>
			</div>
		</div>
	</div>
</div>


</div>
@stop
