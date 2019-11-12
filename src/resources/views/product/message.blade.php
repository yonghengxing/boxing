@extends('template') @section('content')

<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title am-fl">产品编辑</div>
					<div class="widget-function am-fr">
						<a href="javascript:;" class="am-icon-cog"></a>
					</div>				
				</div>
				<div class="widget-body  am-fr">
    				<div class="am-u-sm-12 am-u-md-12 am-u-lg-3">
                             <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                                  <a   href="{{asset('/product/newcomp')}}/{{$proid}}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增组件</a>
                                  或者
                                  <a   href="{{asset('/product/multicomp')}}/{{$proid}}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 选择现有组件</a>
                             </div>
                    </div>
                </div>

						@if($promessage->count() != 0)
						<div class="widget-body  am-fr">
							<div class="am-u-sm-12">
								<table width="100%"
									class="am-table am-table-compact am-table-striped tpl-table-black "
									id="example-r">
									<thead>
										<tr>
											<th>组件名称</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										@foreach($promessage as $promessage)
										<tr class="gradeX">
											<td>{{ $promessage->comp_name }}</td>
											<td>
												<div class="tpl-table-black-operation">
													<a href="{{asset('/product/productlist')}}/{{$proid}}/{{$promessage->comp_id}}/{{$promessage->id}}"> <i
														class="am-icon-pencil"></i> 添加文件
													</a>
<!-- 													<a href="{{asset('/product/compfile')}}/{{$proid}}/{{$promessage->comp_id}}"> -->
<!--                                                             <i class="am-icon-pencil"></i> 详情 -->
<!--                                                     </a> -->
													<a href="{{asset('/product/compfile')}}/{{$proid}}/{{$promessage->id}}">
                                                            <i class="am-icon-pencil"></i> 详情
                                                    </a>
                                                    <a href="{{ asset('product/removecomp')}}/{{$promessage->id }}/{{$proid}}" class="tpl-table-black-operation-del" onclick="return del()" >
                                                            <i class="am-icon-trash"></i> 从产品中移除
                                                            <script> 
																function del(){
																	if(confirm("确定要从产品中移除吗？")){
																		alert('移除成功！');
																		return true;
																	}else{
																		return false; 
																	}
																} 
															</script> 
                                                    </a>
									            </div>									            
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							
						</div>
						<br />
						@endif

				<div class="widget-body  am-fr">
    				<div class="am-u-sm-12 am-u-md-12 am-u-lg-3">
                             <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                             	  <a   href="{{asset('/product/removemulticomp')}}/{{$proid}}" class="am-btn am-btn-default am-btn-danger"><span class="am-icon-trash-o"></span> 批量移除组件</a>
                             </div>
                    </div>
                </div>
				</div>

			</div>
		</div>
	</div>
</div>


</div>
@stop

