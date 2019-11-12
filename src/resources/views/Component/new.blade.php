@extends('template') @section('content')
            <div class="row-content am-cf">
                <div class="row">
                
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">新增组件</div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body am-fr">

                                 <form class="am-form tpl-form-border-form  tpl-form-border-br" action="{{ asset('/component/new')}}" method="post" onsubmit="return checkForm()">
									<input type="hidden" name="_token" value="{{ csrf_token() }}" />
									<div class="am-form-group">
                                        <label  class="am-u-sm-3 am-form-label">组件名称<span class="tpl-form-line-small-title">  User Name</span></label>
                                        <div class="am-u-sm-9">
                                             <input type="text" class="tpl-form-input" id="comp_name"  name="comp_name" placeholder="请输入组件的名称">
                                        </div>
                                    </div>
                                    <div class="am-form-group">
										<label for="user-name" class="am-u-sm-3 am-form-label">组件描述 <span
											class="tpl-form-line-small-title"> Description</span></label>
										<div class="am-u-sm-9">
											<textarea class="" rows="10" id="comp_desc" name="comp_desc"
											placeholder="请输入组件描述"></textarea>
											<small></small>
										</div>
									</div>
                                    <div class="am-form-group">
                                        <label  class="am-u-sm-3 am-form-label">组件类别 <span class="tpl-form-line-small-title">  Type</span></label>
                                        <div class="am-u-sm-9">
                                          @foreach(config('app.comp_type') as $id=> $type)
                                         	<label class="am-radio-inline">
                                              <input type="radio" id="comp_type" name="comp_type" value="{{ $id }}" data-am-ucheck>{{ $type}}
                                            </label>
                                    	  @endforeach
                                        </div>
                                    </div>
                                    <div class="am-form-group" id="pre_app" >
                                        <label  class="am-u-sm-3 am-form-label">所在单位<span class="tpl-form-line-small-title">  Group</span></label>
                                        <div class="am-u-sm-9">
                                            <select data-am-selected="{searchBox: 1}" style="display: none;" id="group_id" name="group_id">
                                            	@foreach($groups as $id=> $group)
                                            		<option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                            	@endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="am-form-group">
                                        <div class="am-u-sm-12 am-u-sm-push-12">
                                            <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                                        </div>
                                    </div>
                                    
                                    <script type="text/javascript">
										function checkForm(){
											var nameText = document.getElementById("comp_name").value;
											if ( nameText == "" || nameText == null ){
													alert("请输入用户名！");
													return false;
											}
											var descText = document.getElementById("comp_desc").value;
											if ( descText == "" || descText == null ){
													alert("请输入组件类别！");
													return false;
											}
											var roleCheck=$('input:radio[name="comp_type"]:checked').val();
								            if(roleCheck == null){
								                alert("请选中组件类别!");
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
