@extends('template') @section('content')
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">{{
						config("app.appr_type")[$event->type] }}</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action="{{asset('approver/makechoice')}}/{{$event->id}}" method="post"
						enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<input type="hidden" name="appr_pass" id="appr_pass" value="8" />
						<div class="am-form-group" id="pre_app">
							<label class="am-u-sm-3 am-form-label">组件 <span
								class="tpl-form-line-small-title"> Component</span></label>
							<div class="am-u-sm-9">{{ $event->component->comp_name }}</div>
						</div>
						<div class="am-form-group" id="pre_app">
							<label class="am-u-sm-3 am-form-label">版本<span
								class="tpl-form-line-small-title"> Version</span></label>
							<div class="am-u-sm-9">{{ $event->ver_num }}</div>
						</div>
						<div class="am-form-group" id="pre_app">
							<label class="am-u-sm-3 am-form-label"> 申请者姓名 <span
								class="tpl-form-line-small-title"> User Name</span></label>
							<div class="am-u-sm-9">{{ $preevent->user->true_name }}</div>
						</div>
						<div class="am-form-group">
							<label class="am-u-sm-3 am-form-label"> 申请时间 <span
								class="tpl-form-line-small-title"> Request Time</span></label>
							<div class="am-u-sm-9">{{ $event->created_at }}</div>
						</div>
						<div class="am-form-group">
							<label class="am-u-sm-3 am-form-label"> 申请者说明 <span
								class="tpl-form-line-small-title"> Commit Message</span></label>
							<div class="am-u-sm-9">{{ $event->description }}</div>
						</div>
						@if($event->type == 11000)
						<div class="am-form-group">
							<label for="user-name" class="am-u-sm-3 am-form-label"><span
								class="tpl-form-line-small-title"></span></label>
							<div class="am-u-sm-9">
								<button type="button" class="am-btn am-btn-primary am-btn-sm"
									onclick="location='{{asset('download/apprfile')}}/{{$event->id}}'">
									<i class="am-icon-cloud-upload"></i> 下载对应产品组件
								</button>
								<button type="button" class="am-btn am-btn-danger am-btn-sm"
									onclick="location='{{asset('download/apprdesc')}}/{{$event->id}}'">
									<i class="am-icon-cloud-upload"></i> 下载对应描述文档
								</button>
							</div>
						</div>
						@endif @if($event->type == 13000)
						<div class="am-form-group">
							<label for="user-name" class="am-u-sm-3 am-form-label"><span
							class="tpl-form-line-small-title"></span></label>
							<div class="am-u-sm-9">
								<button type="button" class="am-btn am-btn-danger am-btn-sm"
									onclick="location='{{asset('download/apprtest')}}/{{$event->id}}'">
									<i class="am-icon-cloud-upload"></i> 下载对应测试报告
								</button>
							</div>
						</div>
						@endif
						<div class="am-form-group">
							<label for="user-name" class="am-u-sm-3 am-form-label">审批评语 <span
								class="tpl-form-line-small-title"> Approval Message</span></label>
							<div class="am-u-sm-9">
								<textarea class="" rows="10" id="appr_desc" name="appr_desc"
									placeholder="请输入审批评语"></textarea>
								<small></small>
							</div>
						</div>
						<div class="widget-body am-fr">
							<div class="am-u-sm-9 am-u-sm-push-3">
								<button type="submit"
									class="am-btn am-btn-primary tpl-btn-bg-color-success"
									onclick="return setPass()">通过</button>
								<button type="submit"
									class="am-btn am-btn-danger tpl-btn-bg-color-success"
									onclick="return setNoPass()">不通过</button>
							</div>
							<script type="text/javascript">
							function setPass(){
								var appr_pass = document.getElementById("appr_pass");
								appr_pass.value = 1;
								var appr_desc = document.getElementById("appr_desc").value;
								if ( appr_desc == "" || appr_desc == null ){
										alert("请输入审批描述！");
										return false;
								}
								return true;
							}
							function setNoPass(){
								var appr_pass = document.getElementById("appr_pass");
								appr_pass.value = 0;
								var appr_desc = document.getElementById("appr_desc").value;
								if ( appr_desc == "" || appr_desc == null ){
										alert("请输入审批描述！");
										return false;
								}
								return true;
							}
							</script>
						</div>
					</form>
				</div>
				@if($records->count() != 0)
				<div class="widget-body  am-fr">
					<div class="am-u-sm-12">
						<table width="100%"
							class="am-table am-table-compact am-table-striped tpl-table-black "
							id="example-r">
							<thead>
								<tr>
									<th>审批节点</th>
									<th>审批人</th>
									<th>审批时间</th>
									<th>结果</th>
									<th>批语</th>
								</tr>
							</thead>
							<tbody>
								@foreach($records as $record)
								<tr class="gradeX">
									<td>{{ $record->apprnode->node_name }}</td>
									<td>{{ $record->appruser->true_name }}</td>
									<td>{{ $record->created_at }}</td>
									<td>{{ config("app.appr_pass")[$record->has_passed] }}</td>
									<td>{{ $record->appr_desc }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>


</div>
@stop
