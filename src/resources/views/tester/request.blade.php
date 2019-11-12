@extends('template') @section('content')
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">领取测试组件</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action="{{asset('tester/request')}}/{{$event->id}}" method="post"
						enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<div class="am-form-group" id="pre_app">
							<label class="am-u-sm-3 am-form-label">组件 <span
								class="tpl-form-line-small-title"> Component</span></label>
							<div class="am-u-sm-9">{{ $event->component->comp_name }}</div>
						</div>
						<div class="am-form-group" id="pre_app">
							<label class="am-u-sm-3 am-form-label"> 开发者姓名 <span
								class="tpl-form-line-small-title"> User Name</span></label>
							<div class="am-u-sm-9">{{ $preevent->user->true_name }}</div>
						</div>
						<div class="am-form-group">
							<label class="am-u-sm-3 am-form-label"> 上传时间 <span
								class="tpl-form-line-small-title"> Request Time</span></label>
							<div class="am-u-sm-9">{{ $preevent->created_at }}</div>
						</div>
						<div class="am-form-group">
							<label class="am-u-sm-3 am-form-label"> 开发者说明 <span
								class="tpl-form-line-small-title"> Commit Message</span></label>
							<div class="am-u-sm-9">{{ $preevent->description }}</div>
						</div>
						<div class="am-form-group">
							<label for="user-name" class="am-u-sm-3 am-form-label">领取说明<span
								class="tpl-form-line-small-title"> Request Message</span></label>
							<div class="am-u-sm-9">
								<textarea class="" rows="10" id="test_desc" name="test_desc"
									placeholder="请输入领取测试的说明"></textarea>
								<small></small>
							</div>
						</div>
						<div class="widget-body am-fr">
							<div class="am-u-sm-9 am-u-sm-push-3">
								<button type="submit"
									class="am-btn am-btn-primary tpl-btn-bg-color-success">领取测试</button>
							</div>
						</div>
					</form>
					<div class="widget-body am-fr">
						<div class="am-u-sm-9 am-u-sm-push-3">
							<button class="am-btn am-btn-danger tpl-btn-bg-color-success"
								onclick="window.location.href='{{asset('/tester/versionlist')}}/{{$event->comp_id}}'">返回</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</div>
@stop
