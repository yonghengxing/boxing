@extends('template') @section('content')
  <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title  am-cf">产品文件移除</div>
                            </div>
                            <div class="widget-body  am-fr">
            					<form class="am-form tpl-form-line-form"  action="{{ asset('product/remove')}}/{{ $proid }}" method="post" >
                                	<input type="hidden" name="_token" value="{{csrf_token()}}">
            						<input type="hidden" name="multifiles" id="multifiles" value="">
                               		<div class="am-form-group" >
                                        <div class="am-u-sm-12">
                                            <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black " id="example-r">
                                                <thead>
                                                    <tr>
                                                	    <th>组件名称</th>
                                                	    <th>文件路径</th>                                        	    
                                                	    <th>文件名称</th>
                                                	    <th>创建时间</th>
                                                	    <th>选择移除</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($mProcLists as $mProcList)
                                                    <tr class="gradeX">
                                                        <td>{{ $mProcList->component->comp_name }}</td>
                                                        <td>{{ $mProcList->profilepath }}</td>
                                                        <td>{{ $mProcList->profile }}</td>                                                
                                                        <td>{{ $mProcList->created_at }}</td>
                                                        <td>
                    										<label class="am-radio-inline">
                                                            	<input name="checkbox{{$mProcList->id}}" id="checkbox{{$mProcList->id}}" type="checkbox"   onclick="SetArticleId(this,{{$mProcList->id}});" />  选择 </td>
                                                            </label>
                    									</td>
                                                    </tr>
                                                 @endforeach
                                                    
                                                    <!-- more data -->
                                                </tbody>
                                            </table>
                                            <div class="am-u-lg-12 am-cf">
                        						<div class="am-fr">
                        							<link rel="stylesheet" href="{{asset('css/app.css')}}">
                        							{{ $mProcLists->links() }}
                        						</div>
                        					</div>
        								</div>
                                    </div>

                               		<div class="am-form-group" >
                                    	<div class="am-u-sm-9 am-u-sm-push-3">
                                        	<button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success " >确认</button>
                                        </div>
                                    </div>
                                </form>
            				</div>
            				<script type="text/javascript">
                					onload = function() {
                						setChecked();
                                	};
                 					   //得到选中复选框值
                 					    function theSubmit(){
                 					    	var pid = {{$proid}};
                     					    var str = "selectFileID" + pid;
                 					     	var checkIds = GetCookie(str);
                 					     	alert(checkIds);
                 					    }
                 					     
                 					    function SetArticleId(o, i) { 
                 					       if (o.checked) {
                 					        AddCookie(i);
                 					      }
                 					      else {
                 					        RemoveCookie(i);
                 					      } 
                 					    }
                 					     
                 					    function SetCookie(name, value) {
                 					      document.cookie = name + "=" + escape(value); 
                  					      var input = document.getElementById("multifiles");
                    					  input.value = GetCookie(name);
                 					    }
                 					    function GetCookie(name) {
                 					      if (document.cookie.length > 0) {
                 					        c_start = document.cookie.indexOf(name + "=");
                 					        if (c_start != -1) {
                 					          c_start = c_start + name.length + 1;
                 					          c_end = document.cookie.indexOf(";", c_start);
                 					          if (c_end == -1) c_end = document.cookie.length;
                 					          return unescape(document.cookie.substring(c_start, c_end));
                 					        }
                 					      }
                 					      return "";
                 					    }
                 					    function AddCookie(i) {
                 					    	var pid = {{$proid}};
                     					    var str = "selectFileID" + pid;
                 					      d = GetCookie(str);
                 					      if (d == "") d = "|";
                 					      if (d.indexOf("|" + i + "|") == -1) {
                 					            d += i + "|";
                 					            SetCookie(str, d);
                 					      } 
                 					    }
                 					  
                 					    function RemoveCookie(i) {
                 					    	var pid = {{$proid}};
                     					    var str = "selectFileID" + pid;
                 					      d = GetCookie(str);
                 					      var reg = new RegExp("\\|" + i + "\\|");
                 					      if (reg.test(d)) {
                 					        d = d.replace(reg, "|");  
                 					        SetCookie(str, d);
                 					      }     
                 					    }
            
                  					   function setChecked() {
                    						 var pid = {{$proid}};
                       					    var str = "selectFileID" + pid;
                   					      d = GetCookie(str);
                      					  var input = document.getElementById("multifiles");
                      					  input.value = d;
                   					      if (d == "")
                       					      return 0;
                   					      var idArr = d.split("|");
                      					  for (var i=1;i< idArr.length - 1;i++)
                          				  {
                              				  var boxName = "checkbox" + idArr[i];
                              				  var box = document.getElementsByName(boxName);
                              				  if(box.length != 0){
                              				  	box[0].checked = true
                              				  }
                          				  }
                   					    }
            
                    					function changeURLArg(url,arg,arg_val){
                       					    var pattern=arg+'=([^&]*)';
                       					    var replaceText=arg+'='+arg_val; 
                       					    if(url.match(pattern)){
                       					        var tmp='/('+ arg+'=)([^&]*)/gi';
                       					        tmp=url.replace(eval(tmp),replaceText);
                       					        return tmp;
                       					    }else{ 
                       					        if(url.match('[\?]')){ 
                       					            return url+'&'+replaceText; 
                       					        }else{ 
                       					            return url+'?'+replaceText; 
                       					        } 
                       					    }
                       					}
             					</script>
                        </div>
                    </div>
                </div>
            </div>
@stop
