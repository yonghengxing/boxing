@extends('admintemplate')

@section('content')
<div class="row">
	<div class="am-u-md-12 am-u-sm-12 row-mb">
		<div class="tpl-portlet">
			<div class="tpl-portlet-title">
					<div class="tpl-caption font-green  bold">
						<i class="am-icon-bar-chart"></i> <span> {{ $project->project_name }}</span>
					</div>
			</div>
<div>
<div id="chart_project" style="tpl-echarts"></div>
<table class="am-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>增量</th>
            <th>减量</th>
            <th>净增</th>
            <th>项目</th>
            <th>群组</th>
            <th>用户</th>
            <th>时间</th>
        </tr>
    </thead>
    <tbody>
    @foreach($project->commits as $ci)
        <tr>
            <td>{{ $ci->id }}</td>
            <td>{{ $ci->commit_add }}</td>
            <td>{{ $ci->commit_delete }}</td>
            <td>{{ $ci->commit_add-$ci->commit_delete }}</td>
            <td>{{ $project->project_name }}</td>
            <td>{{ $ci->group->group_name }}</td>
            <td>{{ $ci->user->name }}</td>
            <td>{{ $ci->timestamp }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
</div>
</div>
<script type="text/javascript"> 
var chart_codeline = Highcharts.chart('chart_project', {
	    chart: {
	        type: 'spline'
	    },
	    title: {
	        text: '{{ $project->project_name }}统计'
	    },
	    xAxis: {
	        type: 'datetime',
	        title: {
	            text: '日期'
	        }
	    },
	    yAxis: {
	        title: {
	            text: ''
	        },
	        min: 0
	    },
	    tooltip: {
	        headerFormat: '<b>{series.name}</b><br>',
	        pointFormat: '{point.x:%e. %b}: {point.y}'
	    },
	    plotOptions: {
	        spline: {
	            marker: {
	                enabled: true
	            }
	        }
	    },
	    series: [ {!! $chart_series !!} ],
	    credits: {
	        enabled: false
	   	}
	});

</script>
@stop