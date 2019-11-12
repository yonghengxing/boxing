@extends('template') @section('content')

<script type="text/javascript">
                	function success() {
                		document.getElementById("submit_form").submit();
                		alert("测试申请成功");
                		
                	}
</script>

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
									<td>{{ config("app.dev_status")[$event->status] }}</td>
									<td>
										<div class="tpl-table-black-operation">
											@if($event->status > 1200 && $event->status != 1210) <a href="{{asset('download/devtest')}}/{{$event->id}}"> <i
												class="am-icon-pencil"></i> 下载测试报告
											</a> @endif
											@if($event->status == 1210) <a href="{{asset('issue/event')}}/{{$event->id}}" class="tpl-table-black-operation-del" > <i
												class="am-icon-trash"></i> 查看问题
											</a> @endif
											@if($event->status == 1101)
<!-- 											<form 	action=" {{asset('/developer/eventlist')}}" method="post" id ="submit_form" -->
<!-- 													enctype="multipart/form-data"> -->
<!-- 												<input type="hidden" name="_token" value="{{ csrf_token() }}" />  -->
<!-- 												<input type="hidden" name="event" id="event" value= "{{ $event }}" /> -->
<!-- 												<input type="hidden" name="test" id="test" value= "test" /> -->
<!--													<a href = "" onclick = "success(); return false;">  -->
<!-- 													<i class="am-icon-pencil"></i> 申请测试</a> -->
<!-- 											</form> -->
											<a href="{{asset('developer/addtest')}}/{{$event->id}}"> <i
												class="am-icon-pencil"></i> 申请测试
											</a>	
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
