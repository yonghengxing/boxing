@extends('template') @section('content')
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">测试组件</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action="{{asset('issue/new')}}/{{$event->id}}" method="post"
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
							<label for="user-name" class="am-u-sm-3 am-form-label"><span
								class="tpl-form-line-small-title"></span></label>
							<div class="am-u-sm-9">
								<div class="am-form-group am-form-file">
									<button type="button" class="am-btn am-btn-primary am-btn-sm">
										<i class="am-icon-cloud-upload"></i> 选择要上传的测试文档
									</button>
									<input type="file" name="testdoc" id="testdoc" />
								</div>
								<div id="file-list"></div>
								<script>
                                              $(function() {
                                                $('#testdoc').on('change', function() {
                                                  var fileNames = '';
                                                  $.each(this.files, function() {
                                                    fileNames += '<span class="am-badge">' + this.name + '</span> ';
                                                  });
                                                  $('#file-list').html(fileNames);
                                                });
                                              });
                               </script>
							</div>
						</div>
						
						<div class="am-form-group">
							<label class="am-u-sm-3 am-form-label">问题标题<span
								class="tpl-form-line-small-title"> Issue Title</span></label>
							<div class="am-u-sm-9">
								<input type="text" class="tpl-form-input" id="issue_title"
									name="issue_title" placeholder="请输入问题标题">
							</div>
						</div>
						<div class="am-form-group">
							<label for="user-name" class="am-u-sm-3 am-form-label">问题描述 <span
								class="tpl-form-line-small-title"> Issue Description</span></label>
							<div class="am-u-sm-9">
								<textarea class="" rows="10" id="issue_desc" name="issue_desc"
									placeholder="请输入问题描述"></textarea>
								<small></small>
							</div>
						</div>
						<div class="widget-body am-fr">
							<div class="am-u-sm-9 am-u-sm-push-3">
								<button type="submit"
									class="am-btn am-btn-primary tpl-btn-bg-color-success">提交</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


</div>
@stop
