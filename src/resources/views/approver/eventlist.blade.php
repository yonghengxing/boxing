@extends('template') @section('content')
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title  am-cf">审批记录列表</div>
				</div>
				<div class="widget-body  am-fr">
					<div class="am-u-sm-12">
						<table width="100%"
							class="am-table am-table-compact am-table-striped tpl-table-black "
							id="example-r">
							<thead>
								<tr>
									<th>审批时间</th>
									<th>结果</th>
									<th>批语</th>
								</tr>
							</thead>
							<tbody>
								@foreach($records as $record)
								<tr class="gradeX">
									<td>{{ $record->created_at }}</td>
									<td>{{ config("app.appr_pass")[$record->has_passed] }}</td>
									<td>{{ $record->appr_desc }}</td>
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
			</div>
		</div>
	</div>
</div>
@stop
