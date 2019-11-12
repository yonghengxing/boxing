@extends('admintemplate') 
@section('content')
<div class="row">
	<div class="am-u-md-12 am-u-sm-12 row-mb">
		<div class="tpl-portlet">
			<div class="tpl-portlet-title">
							<div class="tpl-caption font-green  bold">
								<i class="am-icon-user"></i> <span> 人员代码统计</span>
							</div>
			</div>
			<table class="am-table">
				<thead>
					<tr>
						<th>ID</th>
						<th>姓名</th>
						<th>增量</th>
						<th>减量</th>
						<th>净增</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($res['user_code'] as $user)
					<tr>
						<td><a href="{{ asset('user')}}/{{ $user['info']->email  }}">{{ $user['info']->id }}</a></td>
						<td><a href="{{ asset('user')}}/{{ $user['info']->email  }}">{{ $user['info']->name }}</a></td>
						<td>{{ $user['sum_add'] }}</td>
						<td>{{ $user['sum_delete'] }}</td>
						<td>{{ $user['sum_add']-$user['sum_delete'] }}</td>
						<td></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
