@extends('template') @section('content')
            <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">创建单位</div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body am-fr">
                                <form class="am-form tpl-form-border-form" action="{{ asset('/group/new')}}" method="post" onsubmit="return checkForm()">
                                	@csrf
                                	<div class="am-form-group" id="new_app">
                                        <label  class="am-u-sm-3 am-form-label">单位名称 <span class="tpl-form-line-small-title">  Name</span></label>
                                        <div class="am-u-sm-9">
                                             <input type="text" class="tpl-form-input" id="group_name" name="group_name" placeholder="请输入单位名称">
                                            <small>中文、字母、数字、下划线</small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label">单位描述  <span class="tpl-form-line-small-title">  Details</span></label>
                                        <div class="am-u-sm-9">
                                           <textarea class="" rows="10" id="group_intro" name="group_intro"  placeholder="请输入描述内容"></textarea>
                                            <small></small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-12 am-u-sm-push-12">
                                            <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
										function checkForm(){
											var nameText = document.getElementById("group_name").value;
											if ( nameText == "" || nameText == null ){
													alert("请输入单位名！");
													return false;
											}
											var introText = document.getElementById("group_intro").value;
											if ( introText == "" || introText == null ){
													alert("请输入单位描述！");
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
