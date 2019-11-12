@extends('admintemplate') 
@section('content')
<div class="row">
	<div class="am-u-md-12 am-u-sm-12 row-mb">
		<div class="tpl-portlet">
			<div class="tpl-portlet-title">
							<div class="tpl-caption font-green  bold">
								<i class="am-icon-users"></i> <span> 团队代码统计</span>
							</div>
			</div>
			<table class="am-table">
				<thead>
					<tr>
						<th>ID</th>
						<th>团队名称</th>
						<th>代码增量</th>
						<th>代码减量</th>
						<th>代码净增</th> 
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($commits as $ci)
					<tr>
						<td>{{ $ci->id }}</td>
						<td>{{ $ci->group_name }}</td>
						<td>{{ $ci->sum_add }}</td>
						<td>{{ $ci->sum_delete }}</td>
						<td>{{ $ci->sum_add-$ci->sum_delete }}</td>
						<td><a href="{{ asset('group')}}/{{ $ci->group_id }}">详情</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
