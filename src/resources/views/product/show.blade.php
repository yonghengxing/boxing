@extends('template') @section('content')
<script src="{{asset('lib/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('lib/js/jquery.cxselect.js')}}"></script>
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">产品模板创建</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>
				</div>
				<div class="widget-body am-fr">
					<form class="am-form tpl-form-border-form  tpl-form-border-br"
						action="" method="post" enctype="multipart/form-data">
						<div class="am-form-group">
							<form action="" method="post">
                     			<input type="hidden" name="_token" value="{{csrf_token()}}">
	                                                  产品名称<input type="text" size="30" name ="proname" ><br />
	                                                  产品描述<input type="text" size="100" name ="prodespt" ><br />
	                			<input type="submit" name="sub1" class="am-btn am-btn-danger tpl-btn-bg-color-success" value="确定"><br />
	            			</form>
						</div>
						@if($proall->count() != 0)
						<div class="widget-body  am-fr">
							<div class="am-u-sm-12">
								<table width="100%"
									class="am-table am-table-compact am-table-striped tpl-table-black "
									id="example-r">
									<thead>
										<tr>
											<th>产品ID</th>
											<th>产品名称</th>
											<th>产品描述</th>
											<th>创建日期</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										@foreach($proall as $proall)
										<tr class="gradeX">
											<td>{{ $proall->id }}</td>
											<td>{{ $proall->proname }}</td>
											<td>{{ $proall->prodespt }}</td>
											<td>{{ $proall->created_at }}</td>
											<td>
												<div class="tpl-table-black-operation">
													<a href="{{asset('/product/message')}}/{{$proall->id}}"> <i
														class="am-icon-pencil"></i> 编辑
									            </div>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						@else
						<div class="widget-body am-fr">
							<div class="am-form-group" id="pre_app">
								<label class="am-u-sm-3 am-form-label">没有产品模板，请 <span
									class="tpl-form-line-small-title"></span></label>
								<div
									class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
									<a href="{{asset('/template/new')}}/{{$select_type}}"
										class="am-btn am-btn-default am-btn-success"><span
										class="am-icon-plus"></span> 新增模板</a>
								</div>
							</div>
						</div>
						@endif
					</form>
				</div>
				<script type="text/javascript">
					$(function(){
						$("#comp_type").change(function(){
							var value = $(this).val();
							var str1 = "{{asset('template/show')}}";
							var url = str1 + '/' + value;
							window.location.href= url;
						});
					})
				</script>
			</div>
		</div>
	</div>
</div>


</div>
@stop
