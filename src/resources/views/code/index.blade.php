@extends('admintemplate') 
@section('content')
<div class="row">
	<div class="am-u-md-12 am-u-sm-12 row-mb">
		<div class="tpl-portlet">
			<div class="tpl-portlet-title">
							<div class="tpl-caption font-green  bold">
								<i class="am-icon-code"></i> <span> Commits 详细信息</span>
							</div>
			</div>
			<table class="am-table">
				<thead>
					<tr>
						<th>ID</th>
						<th>人员</th>
						<th>团队</th>
						<th>项目</th>
						<th>增量</th>
						<th>减量</th>
						<th>信息</th>
						<th>时间</th>
					</tr>
				</thead>
				<tbody>
					@foreach($commits as $ci)
					<tr>
						<td>{{ $ci->id }}</td>
						<td>{{ $ci->user->name }}</td>
						<td>{{ $ci->group->group_name }}</td>
						<td>{{ $ci->project->project_name }}</td>
						<td>{{ $ci->commit_add }}</td>
						<td>{{ $ci->commit_delete }}</td>
						<td>{{ $ci->commit_msg }}</td>
						<td>{{ $ci->timestamp }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
