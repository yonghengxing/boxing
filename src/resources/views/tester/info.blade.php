@extends('template') @section('content')
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">
						测试组件</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action="{{asset('approver/pass')}}/{{$event->id}}" method="post"
						enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
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
							<label class="am-u-sm-3 am-form-label"> 开发方姓名 <span
								class="tpl-form-line-small-title"> User Name</span></label>
							<div class="am-u-sm-9">{{ $preevent->user->true_name }}</div>
						</div>
						<div class="am-form-group">
							<label class="am-u-sm-3 am-form-label"> 上传时间 <span
								class="tpl-form-line-small-title"> Request Time</span></label>
							<div class="am-u-sm-9">{{ $preevent->created_at }}</div>
						</div>
						<div class="am-form-group">
							<label class="am-u-sm-3 am-form-label"> 开发方说明 <span
								class="tpl-form-line-small-title"> Commit Message</span></label>
							<div class="am-u-sm-9">{{ $preevent->description }}</div>
						</div>
						@if($event->status == 2102 || $event->status == 2111)
						<div class="am-form-group">
							<label for="user-name" class="am-u-sm-3 am-form-label"><span
								class="tpl-form-line-small-title"></span></label>
							<div class="am-u-sm-9">
								<button type="button" class="am-btn am-btn-primary am-btn-sm"
									onclick=" location='{{asset('tester/download')}}/{{$event->id}}'">
									<i class="am-icon-cloud-upload"></i> 下载产品组件和描述文档
								</button>
							</div>
						</div>
						@endif
						@if($event->status == 2103)
						<div class="widget-body am-fr">
							<div class="am-u-sm-9 am-u-sm-push-3">
								<button type="button"
									class="am-btn am-btn-primary tpl-btn-bg-color-success"
									onclick="window.location.href='{{asset('/tester/import')}}/{{$event->id}}'">测试通过</button>
								<button type="button"
									class="am-btn am-btn-danger tpl-btn-bg-color-success"
									onclick="window.location.href='{{asset('/issue/new')}}/{{$event->id}}'">测试不通过</button>
							</div>
						</div>
						@endif
					</form>
				</div>
			</div>
		</div>
	</div>


</div>
@stop
