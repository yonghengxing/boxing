@extends('template') @section('content')
<script src="{{asset('lib/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('lib/js/jquery.cxselect.js')}}"></script>

<script type="text/javascript">
	var compIndex = 1;
	function addComp()
 	{
		compIndex++;
		var str = '<div class="am-form-group" index="'+
		compIndex + '" id="file_'+
		compIndex + '"><label class="am-u-sm-3 am-form-label">文件('+
		compIndex + ')名</label><div class="am-u-sm-9"><input type="text" size="30" name ="filename_'+
		compIndex + '"><br /></div><label class="am-u-sm-3 am-form-label">文件('+
		compIndex + ')安装路径</label><div class="am-u-sm-9"><input type="text" size="30" name ="filepath_'+
		compIndex + '" ><br /></div></div>';
		$("#showComp").append(str);
		var file_num = document.getElementById("file_num");
		file_num.value = compIndex;
		
	}
	function deleteComp()
	{
// 		alert(compIndex);
		if(compIndex < 1){
			return;
		}
		
		$("#file_"+compIndex).remove();
		compIndex--;
		var file_num = document.getElementById("file_num");
		file_num.value = compIndex;
	}
</script>

<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">为产品编辑文件模板</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action=" " method="post"
						enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<input type="hidden" name="file_num" id="file_num" value="1" />
							<div class="widget-body am-fr" id="showComp">
								<div class="am-form-group" index="1" id="file_1">
									<label class="am-u-sm-3 am-form-label">文件(1)名</label>
									<div class="am-u-sm-9">
										<input type="text" size="30" name ="filename_1" ><br />
									</div>
									<label class="am-u-sm-3 am-form-label">文件(1)安装路径</label>
									<div class="am-u-sm-9">
										<input type="text" size="30" name ="filepath_1" ><br />
									</div>
								</div>							
							</div>
						</div>
						<div class="am-form-group" index="1">
								<label for="user-name" class="am-u-sm-3 am-form-label"></label>
								<div class="am-u-sm-9">
									<div class="am-form-group">
										<div class="am-btn-toolbar">
											<div class="am-btn-group am-btn-group-xs">
												<button type="button"
													class="am-btn am-btn-default am-btn-success"
													onclick="addComp();">
													<span class="am-icon-plus"></span> 追加文件
												</button>
												<button type="button"
													class="am-btn am-btn-default am-btn-danger"
													onclick="deleteComp();">
													<span class="am-icon-trash-o"></span> 删除文件
												</button>
											</div>
										</div>
									</div>
								</div>
								<div class="am-form-group">
									<div class="am-u-sm-9 am-u-sm-push-3">
									<button type="submit"
										class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
									</div>
								</div>
							</div>
						</div>							
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
