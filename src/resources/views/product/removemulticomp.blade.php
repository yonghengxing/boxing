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
				<form class="am-form tpl-form-border-form  tpl-form-border-br" action="{{asset('/product/removemulticomps')}}/{{$proid}}" method="post" onsubmit="return checkForm()">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<div class="am-form-group">
            				<div class="am-u-sm-12 am-u-sm-push-12">
            					<button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">确定移除</button>
            				</div>
            			</div>
						@if($promessage->count() != 0)
						<div class="am-form-group" index="1">
                        	<div class="am-u-sm-12">
								<table width="100%"
									class="am-table am-table-compact am-table-striped tpl-table-black "
									id="example-r">
									<thead>
										<tr>
											<th>组件名称</th>
											<th>选中移除</th>
										</tr>
									</thead>
									<tbody>
										@foreach($promessage as $promessage)
										<tr class="gradeX">
											<td>{{ $promessage->comp_name }}</td>
											<td>
												<div class="tpl-table-black-operation">
													<label class="am-radio-inline">
                                        				<input name="checkbox{{$promessage->id}}" id="checkbox{{$promessage->id}}" type="checkbox"/>  移除 </td>
                                        			</label>
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
					</form>
				</div>

			</div>
		</div>
	</div>
</div>


</div>
@stop

