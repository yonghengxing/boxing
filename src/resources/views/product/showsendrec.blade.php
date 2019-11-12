@extends('template') @section('content')
<script src="{{asset('lib/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('lib/js/jquery.cxselect.js')}}"></script>
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">推送记录</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action="" method="post" enctype="multipart/form-data">
        				<div class="widget-body  am-fr">
							<div class="am-u-sm-12">
								<table width="100%"
									class="am-table am-table-compact am-table-striped tpl-table-black "
									id="example-r">
									<thead>
										<tr>
											<th>推送日期</th>
											<th>设备名称</th>
											<th>设备编号</th>
											<th>产品名</th>
											<th>状态</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										@foreach($records as $record)
										<tr class="gradeX">
											<td>{{ $record->created_at }}</td>
											<td>{{ $record->device_name }}</td>
											<td>{{ $record->device_id }}</td>
											<td>{{ $record->product->proname }}</td>
											<td>{{ config("app.device_status")[$record->status] }}</td>
											<td>
												@if($record->status == 901)
    												<div class="tpl-table-black-operation">
    													<a href="{{asset('/product/genauthfile')}}/{{$record->id}}"> <i
    														class="am-icon-pencil"></i> 生成授权文件
    									            </div>
    									        @endif
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							<div class="am-u-lg-12 am-cf">
        						<div class="am-fr">
        							<link rel="stylesheet" href="{{asset('css/app.css')}}">
        							{{ $records->links() }}
        						</div>
        					</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


</div>
@stop
