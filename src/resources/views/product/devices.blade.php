@extends('template') @section('content')

 <div class="row-content am-cf">
       <div class="row">
            <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            	<div class="widget am-cf">
                	<div class="widget-head am-cf">
                	
                <form  class="am-form" action="{{ asset('/product/devices')}}" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    
                    <div class="am-form-group" 
                        <?php
                              //if( empty($_REQUEST) && $_REQUEST['ConnectionError']){
                              if($flag != 0){
                                        echo "style='display: none'";
                                    }
                        ?> >

                         <label for="devname" class="am-u-sm-2 am-form-label">设备名称</label>
                         <div class="am-form-group">
                              <input type="text" id="devname" class="am-form-field" name="devname" placeholder="输入设备名称，进行设备与产品的关联查找">
						 </div>
						 
						<div class="am-form-group">
                              <input type="hidden" name="devsub" id="devsub" value="确定" "><br />
                              <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">确定</button>
                     	</div> 
                   </div>
                   
                    @if($procNameToDev != null && $flag == 1)
                        <div class="am-form-group">
							<div class="am-u-sm-12">
								<table width="100%"
									class="am-table am-table-compact am-table-striped tpl-table-black "
									id="example-r">
									<thead>
										<tr>
											<th>设备名称</th>
											<th>产品名称</th>
											<th>组件名称</th>
											<th>组件版本</th>
										</tr>
									</thead>
									<tbody>
									<?php 
									for ($i=0; $i < count($procCompId);$i++){
									?>
										<tr class="gradeX">
											<td>{{ $devName }}</td>
											<td>{{ $procNameToDev[0]->proname }}</td>
											<td>{{ $procCompName[$i][0]->comp_name }}</td>
											<td id="j">
											<select data-am-selected="{searchBox: 1}" name="selVersion[{{$i}}]" id="selVersion{{$i}}">
													@foreach ($procVerNum[$i] as $procVerNum[$i])
														<option value="{{$procVerNum[$i]->ver_num}}"
															<?php //选中当前正在用的版本
															if ($procVerNumNow[$i]->ver_num == $procVerNum[$i]->ver_num){
															?>
															selected="selected"
															<?php 
									                           }
															?>
														>{{$procVerNum[$i]->ver_num}}</option>
													@endforeach
	                            			</select>
	                            			</td>
										</tr>
									<?php 
									}
									?>
									<input type="hidden" name="devName" value="{{$devName}}">
									</tbody>
								</table>
								<div class="am-form-gro">
									<input type="hidden" name="modify" id="modify" value="修改组件版本" "><br />
									<button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">修改组件版本</button> 
								</div>
							</div>			
						</div>	
					@elseif($flag == 2)
					
	                    <div class="am-form-group" style="margin-top:30px">
      						<label for="selProcName" >{{ $devName }}没有关联产品，请添加关联产品及组件版本信息：</label>                             
	                     	<input type="hidden" name="devName1" value="{{$devName}}">                    												   
	                            
	                            <div class="am-form-group" id="pre_app" >
                                    <label  class="am-u-sm-3 am-form-label">选择产品 </label>
                                    <div class="am-u-sm-9">                        												   
    		                   			<select data-am-selected="{searchBox: 1}" style="display: none;" name="selProcName" id="selProcName">
    										<option value="0">产品名</option>
											@foreach ($procIndex as $procIndex)
<!-- 												<option value="{{$procIndex->proname}}">{{$procIndex->proname}}</option> -->
												<option value="{{$procIndex->proname}}">{{$procIndex->proname}}</option>
											@endforeach
	                            		</select>
	                            	 </div>
                              </div> 
                              

					         <table width="100%"
									class="am-table am-table-compact am-table-striped tpl-table-black "
									id="example-r">
									<thead>
										<tr>
											<th>组件名称</th>
											<th>组件版本</th>
										</tr>
									</thead>
									<tbody id="compList" name="compList">

									</tbody>
								</table>

					<script type="text/javascript"> 
    					$(function(){
    						$("#selProcName").change(function(){
    							var value = $(this).val();
    							var type = $(this).attr('id');
//     							var str1 = "{{asset('product/devices')}}";
     							var str1 = "{{asset('product/getComponent')}}";
    							var url1 = str1 + '/' + value;
    							var objectModel = {};
    							var csrf = "_token";
                        		var ctoken = "{{csrf_token()}}";
                        		objectModel[type] =value;
                        		objectModel[csrf] = ctoken;
//     							window.location.href= url;
    							$.ajax({
										url:url1,
										type:"post",
										dataType:"json",
										data:objectModel,
										success:function(data){
											$("#compList").empty();
											var str = new Array;
											var strAll = " ";
											for(var i = 0;i<data.length;i++){
												var comp_name = data[i][0].comp_name;
												var comp_id = data[i][0].id;
												str[i] ="<input type='hidden' name='comp_id["+i+"]' value="+comp_id+">"
													    +"<tr> <td>"+comp_name+"</td><td>"
														+" <select data-am-selected='{searchBox: 1}' name='newSelVersion["+i+"]' id='newSelVersion["+i+"]'>"
														+"<option value = 'undefine'>请选择组件版本</option> ";
												if(data[i][0].ver_num.length != 0){
													for(var j = 0;j<data[i][0].ver_num.length;j++){
														var ver_num = data[i][0].ver_num[j].ver_num;
														str[i] = str[i].concat("<option value='"+ver_num+"'>"+ver_num+"</option>");
													}
												}else{
													str[i] = str[i].concat("<option value='undefine'>暂无现有版本</option>");
												}
	                            				str[i] = str[i].concat("</select> </td></tr>");
	                            				strAll = strAll.concat(str[i]);
												}
											$("#compList").html(strAll);
											}
        							})
    						});
    					})
					</script>
					
	                         <span class="am-form-caret"></span>
                        </div>
                        <div class="am-form-gro">
                           <input type="hidden" name="devToproc" id="devToproc" value="产品及设备关联入库" "><br />
                           <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">产品及设备关联入库</button> 
                       </div>
                    @endif
                 
	          </form>
        </div>
        </div>
        </div>
		</div>
		</div>
@stop