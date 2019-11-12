@extends('template') @section('content')
<script src="{{asset('lib/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('lib/js/jquery.cxselect.js')}}"></script>
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">产品模板编辑</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action="" method="post" enctype="multipart/form-data">
						<div class="widget-body  am-fr">
							<div class="am-u-sm-9">
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
											<th>产品名称</th>
											<th>产品描述</th>
											<th>所属公司</th>
											<th>创建日期</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										@foreach($proalls as $proall)
										<tr class="gradeX">
											<td>{{ $proall->proname }}</td>
											<td>{{ str_limit($proall->prodespt,100,"...") }}</td>
											<td>{{ $proall->group->group_name }}</td>
											<td>{{ $proall->created_at }}</td>
											<td>
												<div class="tpl-table-black-operation">
													<a href="{{asset('/product/message')}}/{{$proall->id}}"> <i
														class="am-icon-pencil"></i> 编辑产品模板
													<a href="{{asset('product/procfileshow')}}/{{$proall->id}}"> <i
														class="am-icon-pencil"></i> 查看产品文件
									            </div>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							<div class="am-u-lg-12 am-cf">
        						<div class="am-fr">
        							<link rel="stylesheet" href="{{asset('css/app.css')}}">
        							{{ $proalls->links() }}
        						</div>
        					</div>
        					<script type="text/javascript">
            					$(function(){
            						$("#group_choose").change(function(){
            							var value = $(this).val();
            							var str1 = "{{asset('product/proceditlist')}}";
            							var url = str1 + '/' + value;
            							window.location.href= url;
            						});
            					});
        					</script>
						</div>
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
