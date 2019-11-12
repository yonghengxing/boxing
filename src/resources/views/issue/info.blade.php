@extends('template') @section('content')
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">问题描述</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action="{{asset('issue/update')}}/{{$issue->id}}" method="post"
						enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<div class="am-form-group" id="pre_app">
							<label class="am-u-sm-3 am-form-label">组件 <span
								class="tpl-form-line-small-title"> Component</span></label>
							<div class="am-u-sm-9">{{ $issue->component->comp_name }}</div>
						</div>
						<div class="am-form-group" id="pre_app">
							<label class="am-u-sm-3 am-form-label">版本<span
								class="tpl-form-line-small-title"> Version</span></label>
							<div class="am-u-sm-9">{{ $issue->ver_num }}</div>
						</div>
						<div class="am-form-group">
							<label class="am-u-sm-3 am-form-label">问题标题<span
								class="tpl-form-line-small-title"> Issue Title</span></label>
							<div class="am-u-sm-9">
								{{$issue->title}}
							</div>
						</div>
						<div class="am-form-group" id="pre_app">
							<label class="am-u-sm-3 am-form-label"> 提出人姓名 <span
								class="tpl-form-line-small-title"> Tester Name</span></label>
							<div class="am-u-sm-9">{{ $issue->tester->true_name }}</div>
						</div>
						<div class="am-form-group" id="pre_app">
							<label class="am-u-sm-3 am-form-label"> 响应人姓名 <span
								class="tpl-form-line-small-title"> Developer Name</span></label>
							<div class="am-u-sm-9">{{ $issue->developer->true_name }}</div>
						</div>
						<div class="am-form-group">
							<label class="am-u-sm-3 am-form-label"> 提出时间 <span
								class="tpl-form-line-small-title"> Time</span></label>
							<div class="am-u-sm-9">{{ $issue->created_at }}</div>
						</div>

						<div class="am-form-group">
							<label for="user-name" class="am-u-sm-3 am-form-label">问题描述 <span
								class="tpl-form-line-small-title"> Issue Description</span></label>
							<div class="am-u-sm-9">
								{{$issue->description}}
							</div>
						</div>
						<div class="am-form-group">
							<label for="user-name" class="am-u-sm-3 am-form-label"><span
							class="tpl-form-line-small-title"></span></label>
							<div class="am-u-sm-9">
								<button type="button" class="am-btn am-btn-danger am-btn-sm"
									onclick="location='{{asset('download/issue')}}/{{$issue->id}}'">
									<i class="am-icon-cloud-upload"></i> 下载对应测试文档
								</button>
							</div>
						</div>
					    <div class="am-form-group" id="pre_app" >
                            <label  class="am-u-sm-3 am-form-label">问题状态<span class="tpl-form-line-small-title">  Status</span></label>
                                 <div class="am-u-sm-9">
                                      <select data-am-selected="{searchBox: 1}" style="display: none;" name="status" id="status">
                                            @for($i = 0;$i<=1;$i++)
                                            @if($issue->status == $i)
                                            	<option value="{{$i}}" selected = "selected" >{{ config("app.issue_status")[$i] }}</option>
                                            @else
                                            	<option value="{{$i}}"> {{ config("app.issue_status")[$i] }}</option>
                                            @endif
                                            @endfor
                                      </select>
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
