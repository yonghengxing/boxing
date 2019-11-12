@extends('template') @section('content')
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title  am-cf">事件列表</div>
				</div>
				<div class="widget-body  am-fr">
					<div class="am-u-sm-12">
						<table width="100%"
							class="am-table am-table-compact am-table-striped tpl-table-black "
							id="example-r">
							<thead>
								<tr>
									<th>组件</th>
									<th>版本号</th>
									<th>描述</th>
									<th>状态</th>
									<th>申请时间</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								@foreach($events as $event)
								<tr class="gradeX">
									<td>{{ $event->component->comp_name }}</td>
									<td>{{ $event->ver_num }}</td>
									<td>{{ str_limit($event->preevent->description ,150,"...") }}</td>
									<td>{{ config("app.test_assigned2")[$event->status] }}</td>
									<td>{{ $event->created_at }}</td>
									<td>
										<div class="tpl-table-black-operation">
											@if($event->has_assigned == 0) 
											<a href="{{asset('/tester/request')}}/{{$event->id}}"> <i class="am-icon-pencil"></i> 领取测试</a>
											@endif
										</div>
									</td> 
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
