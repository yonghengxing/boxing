@extends('template') @section('content')
            <div class="row-content am-cf">
                <div class="row">
                
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                            	@if($type == 0)
                                	<div class="widget-title am-fl">新增组件类型</div>
                                @else
                                	<div class="widget-title am-fl">新增用户角色</div>
                                @endif
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body am-fr">
                                 <form class="am-form tpl-form-border-form  tpl-form-border-br" action="{{ asset('/typesetting/new')}}/{{$type}}" method="post" onsubmit="return checkForm()">
									<input type="hidden" name="_token" value="{{ csrf_token() }}" />
									<div class="am-form-group">
										@if($type == 0)
											<label  class="am-u-sm-3 am-form-label">组件类型名<span class="tpl-form-line-small-title">  Component Type Name</span></label>
                                		@else
                                			<label  class="am-u-sm-3 am-form-label">用户角色名<span class="tpl-form-line-small-title">  User Role Name</span></label>
                                		@endif
                                        <div class="am-u-sm-9">
                                             <input type="text" class="tpl-form-input" id="name"  name="name" placeholder="请输入对应名称">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-12 am-u-sm-push-12">
                                            <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                                        </div>
                                    </div>
                                    
                                    <script type="text/javascript">
										function checkForm(){
											var nameText = document.getElementById("name").value;
											if ( nameText == "" || nameText == null ){
													alert("请输入名称！");
													return false;
											}
											return true;
										}
									</script>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@stop
