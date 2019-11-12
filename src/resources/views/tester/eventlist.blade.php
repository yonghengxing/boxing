@extends('template') @section('content')
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title  am-cf">我的事件列表</div>
				</div>
				<div class="widget-body  am-fr">
					<div class="am-u-sm-12">
						<table width="100%"
							class="am-table am-table-compact am-table-striped tpl-table-black "
							id="example-r">
							<thead>
								<tr>
									<th>组件名称</th>
									<th>类型</th>
									<th>版本</th>
									<th>描述</th>
									<th>状态</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								@foreach($events as $event)
								<tr class="gradeX">
									<td>{{ $event->component->comp_name }}</td>
									<td>{{ config("app.comp_type")[$event->component->comp_type] }}</td>
									<td>{{ $event->ver_num }}</td>
									<td>{{ str_limit($event->description ,100,"...") }}</td>
									<td>{{ config("app.test_show")[$event->status] }}</td>
									<td>
										<div class="tpl-table-black-operation">
											@if($event->status == 2102 || $event->status == 2111) <a href="{{asset('/tester/info')}}/{{$event->id}}"> <i
												class="am-icon-pencil"></i> 下载文件
											</a> 
											@elseif($event->status == 2103)
												<a href="{{asset('/tester/info')}}/{{$event->id}}"> <i
												class="am-icon-pencil"></i> 完成测试
											@else
												<a href="{{asset('/tester/info')}}/{{$event->id}}"> <i
												class="am-icon-pencil"></i> 详情
											@endif
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
							{{ $events->links() }}
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@stop
