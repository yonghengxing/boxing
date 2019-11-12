@extends('template') @section('content')
<script src="{{asset('lib/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('lib/js/jquery.cxselect.js')}}"></script>
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">申请入库</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br" action="{{ asset('/developer/import')}}/{{$component->id}}" method="post" enctype="multipart/form-data" onsubmit="return checkForm()">
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<input type="hidden"" id="relative_path" name="relative_path" />
						<div class="am-form-group" id="pre_app">
							<label class="am-u-sm-3 am-form-label">入库组件 <span
								class="tpl-form-line-small-title"> Repository</span></label>
							<div class="am-u-sm-9">
								{{ $component->comp_name }}
							</div>
						</div>
						<div class="am-form-group" id="pre_app">
							<label class="am-u-sm-3 am-form-label">当前最新版本 <span
								class="tpl-form-line-small-title"> latest version</span></label>
							<div class="am-u-sm-9">
								{{ $num1 }}.{{ $num2 }}.{{ $num3 }}
							</div>
						</div>
						<div class="am-form-group" id="input_version" >
							<label class="am-u-sm-3 am-form-label">版本号 <span
								class="tpl-form-line-small-title"> Version</span></label>
							<div class="am-u-sm-9">
								<input type="text" class="tpl-form-input" id="version_input"
									name="version_input" placeholder="请输入新版本号" value = "{{ $num1 }}.{{ $num2 }}.{{ $num3 + 1 }}"> <small>格式：X.Y.Z,例如：1.2.3,23.34.45</small>
							</div>
						</div>
						<div class="am-form-group">
							<div class="am-u-sm-9 am-u-sm-push-3">
								<button type="button" id="xplus"
									class="am-btn am-btn-primary tpl-btn-bg-color-success">只增加X</button>
								<button type="button" id="yplus"
									class="am-btn am-btn-primary tpl-btn-bg-color-success">只增加Y</button>
								<button type="button" id="zplus"
									class="am-btn am-btn-primary tpl-btn-bg-color-success">只增加Z</button>
							</div>
						</div>
						<div class="am-form-group">
							<label for="user-name" class="am-u-sm-3 am-form-label"><span
								class="tpl-form-line-small-title"></span></label>
							<div class="am-u-sm-9">
								<div class="am-form-group am-form-file">
									<button type="button" class="am-btn am-btn-danger am-btn-sm">
										<i class="am-icon-cloud-upload"></i> 选择要上传的组件文件夹
									</button>
									<input type="file" name="doc_form_file[]" id="doc_form_file"
										multiple webkitdirectory/>
								</div>
								<div id="file-list1"></div>
								<script>
                                              $(function() {
                                                $('#doc_form_file').on('change', function() {
                                                  var fileNames = '';
                                                  var relative_path = new Array();
                                                  $.each(this.files, function() {
                                                    fileNames += '<span class="am-badge">' + this.webkitRelativePath + '</span> ';
                                                    relative_path.push(this.webkitRelativePath);
                                                  });
                                                  $('#file-list1').html(fileNames);
                                                  var text_path = relative_path.join("#$#");
                                                  $("#relative_path").attr("value",text_path);
                                                });
                                              });
                               </script>
							</div>
						</div>
						<div class="am-form-group">
							<label for="user-name" class="am-u-sm-3 am-form-label"><span
								class="tpl-form-line-small-title"></span></label>
							<div class="am-u-sm-9">
								<div class="am-form-group am-form-file">
									<button type="button" class="am-btn am-btn-primary am-btn-sm">
										<i class="am-icon-cloud-upload"></i> 选择要上传的描述文件
									</button>
									<input type="file" name="descdoc" id="descdoc" />
								</div>
								<div id="file-list2"></div>
								<script>
                                              $(function() {
                                                $('#descdoc').on('change', function() {
                                                  var fileNames = '';
                                                  $.each(this.files, function() {
                                                    fileNames += '<span class="am-badge">' + this.name + '</span> ';
                                                  });
                                                  $('#file-list2').html(fileNames);
                                                });
                                              });
                               </script>
							</div>
						</div>

						<div class="am-form-group">
							<label for="user-name" class="am-u-sm-3 am-form-label">描述 <span
								class="tpl-form-line-small-title"> Commit Message</span></label>
							<div class="am-u-sm-9">
								<textarea class="" rows="10" id="description" name="description"
									placeholder="请输入描述内容"></textarea>
								<small></small>
							</div>
						</div>
				
				</div>

				<div class="am-form-group">
					<div class="am-u-sm-9 am-u-sm-push-3">
						<button type="submit"
							class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
					</div>
				</div>
				<script type="text/javascript">
										function checkForm(){
											var versionText = document.getElementById("version_input").value;
											if ( versionText  == "" || versionText == null ){
												alert("请输入新建的版本号！");
												return false;
											}
											var patt = /[0-9]+\.[0-9]+\.[0-9]+/;
											if (!patt.test(versionText)){
												alert("请按要求输入的版本号！");
												return false;
											}
											var verNum=versionText.split(".");
											var x = {{$num1}};
											var y = {{$num2}};
											var z = {{$num3}};
											if(verNum[0] <= x){
												if(verNum[1] <= y){
													if(verNum[2] <= z){
														alert("请增加版本号！");
														return false;
													}
												}
											}
											var descText = document.getElementById("description").value;
											if ( descText == "" || descText == null ){
													alert("请输入描述！");
													return false;
											}
											var uploadFile = document.getElementById("doc_form_file").value;
											if ( uploadFile == "" || uploadFile == null ){
													alert("请上传需要入库的文件！");
													return false;
											}
											var uploadDesc = document.getElementById("descdoc").value;
											if ( uploadDesc == "" || uploadDesc == null ){
													alert("请上传需描述文件！");
													return false;
											}
											
											
											return true;
										};
										$(function(){
											// test 的点击事件
											$("#xplus").click(function(){
												var x = {{$num1}} + 1;
												var y = {{$num2}};
												var z = {{$num3}};
												var versionText = document.getElementById("version_input");
												var strVer = x + "." + y + "." + z;
												versionText.value = strVer;
											});
											$("#yplus").click(function(){
												var x = {{$num1}};
												var y = {{$num2}} + 1;
												var z = {{$num3}};
												var versionText = document.getElementById("version_input");
												var strVer = x + "." + y + "." + z;
												versionText.value = strVer;
											});
											$("#zplus").click(function(){
												var x = {{$num1}};
												var y = {{$num2}};
												var z = {{$num3}} + 1;
												var versionText = document.getElementById("version_input");
												var strVer = x + "." + y + "." + z;
												versionText.value = strVer;
											});
										})
				</script>
				</form>
			</div>
		</div>
	</div>
</div>


</div>
@stop
