@extends('template') @section('content')
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title  am-cf">组件列表</div>
				</div>
				<div class="widget-body  am-fr">
					<div class="am-u-sm-9">
						<select data-am-selected="{searchBox: 1}" style="display: none;"
							name="comp_type" id="comp_type">
							<option name="type" value="0" selected="selected">显示全部组件类型</option>
						 @foreach(config('app.comp_type') as $id=> $type)
						 	@if($id == $select_type)
								<option name="type" value="{{ $id }}" selected="selected">{{$type }}</option>
							@else
								<option name="type" value="{{ $id }}">{{ $type }}</option>
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
				<div class="widget-body  am-fr">
					<div class="am-u-sm-12">
						<table width="100%"
							class="am-table am-table-compact am-table-striped tpl-table-black "
							id="example-r">
							<thead>
								<tr>
									<th>名称</th>
									<th>描述</th>
									<th>类型</th>
									<th>所属公司</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								@foreach($components as $component)
								<tr class="gradeX">
									<td>{{ $component->comp_name }}</td>
									<td>{{ str_limit($component->comp_desc ,100,"...") }}</td>
									<td>{{ config("app.comp_type")[$component->comp_type] }}</td>
									<td>{{ $component->group->group_name }}</td>
									<td>
										<div class="tpl-table-black-operation">
											<a href="{{ asset('/product/choosecomp/')}}/{{$proid}}/{{$component->id}}" onclick="return chooseConfirm()" >
												<i class="am-icon-pencil"></i> 选择
											</a>
            								<script> 
            									function chooseConfirm(){
            										if(confirm("确定要选择吗？")){
            											alert('选择成功！');
            											return true;
            											//return window.location.href="{{asset('')}}";
            										}else{
            											return false; 
            										}
            									} 
            								</script> 
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
							{{ $components->links() }}
						</div>
					</div>
					<script type="text/javascript">
    					$(function(){
    						$("#comp_type").change(function(){
    							var group_val = document.getElementById("group_choose").value;
    							var value = $(this).val();
    							var str1 = "{{asset('product/complist')}}";
    							var pid = {{$proid}};
    							var url = str1 + '/' + pid + '/' + value + '/' + group_val;
    							window.location.href= url;
    						});
    						$("#group_choose").change(function(){
    							var comp_val = document.getElementById("comp_type").value;
    							var value = $(this).val();
    							var str1 = "{{asset('product/complist')}}";
    							var pid = {{$proid}};
    							var url = str1 + '/' + pid + '/' + comp_val + '/' + value;
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
