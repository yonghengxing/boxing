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
							<form action="{{asset('/product/newproc')}}" method="post">
                     			<input type="hidden" name="_token" value="{{csrf_token()}}">
                     			<div class="am-form-group">
                                        <label  class="am-u-sm-3 am-form-label">产品名称<span class="tpl-form-line-small-title">  Product Name</span></label>
                                        <div class="am-u-sm-9">
                                             <input type="text" class="tpl-form-input" id="proname"  name="proname" placeholder="请输入产品的名称">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">产品描述 <span
											class="tpl-form-line-small-title"> Description</span></label>
										<div class="am-u-sm-9">
											<textarea class="" rows="10" id="prodespt" name="prodespt"
											placeholder="请输入产品描述"></textarea>
											<small></small>
										</div>
									</div>
	                			
	            				<div class="am-form-group" id="pre_app" >
                    				<label  class="am-u-sm-3 am-form-label">所属公司<span class="tpl-form-line-small-title">  Group</span></label>
                    				<div class="am-u-sm-9">
                    					<select data-am-selected="{searchBox: 1}" style="display: none;" id="group_id" name="group_id">
                    						@foreach($groups as $id=> $group)
                        						<option value="{{ $group->id }}">{{ $group->group_name }}</option>
                        					@endforeach
                        				</select>
                        			</div>
                        		</div>
                        		<div class="am-form-group" id="pre_app" >
                        			<div class="am-u-sm-12 am-u-sm-push-12">
                        				<input type="submit" name="sub1" class="am-btn am-btn-danger tpl-btn-bg-color-success" value="确定"><br />
                        			</div>
                        		</div>
	            			</form>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


</div>
@stop
