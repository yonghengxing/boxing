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
									<th>类型</th>
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
									<td>{{ config("app.appr_type")[$event->type] }}</td>
									<td>{{ $event->component->comp_name }}</td>
									<td>{{ $event->ver_num }}</td>
									<td>{{ str_limit($event->description ,150,"...") }}</td>
									<td>{{ config("app.appr_status")[$event->status] }}</td>
									<td>{{ $event->created_at }}</td>
									<td>
										<div class="tpl-table-black-operation">
											@if($event->show_appr == 1 && $event->has_assigned == 0) 
											<a href="{{asset('/apprvoer/info')}}/{{$event->id}}"> <i class="am-icon-pencil"></i> 进行审批</a>
											@endif
											<a href="{{asset('/apprvoer/detail')}}/{{$event->id}}"> <i class="am-icon-pencil"></i> 审批详情</a>
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<script type="text/javascript">
						function getTest(){
							alert("已领取审核");
						}

					</script>

				</div>
			</div>
		</div>
	</div>
</div>
@stop
