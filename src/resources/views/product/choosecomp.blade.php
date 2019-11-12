@extends('template') @section('content')
<div class="row-content am-cf">
	<div class="row">
		<div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
			<div class="widget am-cf">
				<div class="widget-head am-cf">
					<div class="widget-title  am-cf">组件列表</div>
				</div>
				<div class="widget-body  am-fr">
					<div class="am-u-sm-9">
						<select data-am-selected="{searchBox: 1}" style="display: none;"
							name="comp_type" id="comp_type">
							<option name="type" value="0" selected="selected">显示全部组件类型</option>
						 @foreach(config('app.comp_type') as $id=> $type)
						 	@if($id == $select_type)
								<option name="type" value="{{ $id }}" selected="selected">{{$type }}</option>
							@else
								<option name="type" value="{{ $id }}">{{ $type }}</option>
							@endif
						@endforeach
						</select>
						<select data-am-selected="{searchBox: 1}" style="display: none;"
							name="group_choose" id="group_choose">
							<option name="type" value="0" selected="selected">显示全部所属公司</option>
						 @foreach($groups as $group)
						 	@if($group->id == $select_group)
								<option name="type" value="{{ $group->id }}" selected="selected">{{$group->group_name }}</option>
							@else
								<option name="type" value="{{ $group->id }}">{{ $group->group_name }}</option>
							@endif
						@endforeach
						</select>
					</div>
				</div>
				<div class="widget-body  am-fr">
					<div class="am-u-sm-12">
						<table width="100%"
							class="am-table am-table-compact am-table-striped tpl-table-black "
							id="example-r">
							<thead>
								<tr>
									<th>名称</th>
									<th>描述</th>
									<th>类型</th>
									<th>所属公司</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								@foreach($components as $component)
								<tr class="gradeX">
									<td>{{ $component->comp_name }}</td>
									<td>{{ str_limit($component->comp_desc ,100,"...") }}</td>
									<td>{{ config("app.comp_type")[$component->comp_type] }}</td>
									<td>{{ $component->group->group_name }}</td>
									<td>
										<label class="am-radio-inline">
                                        	<input name="checkbox{{$component->id}}" id="checkbox{{$component->id}}" type="checkbox"   onclick="return SetArticleId(this,{{$component->id}});" />  选择 </td>
                                        </label>
									</td>
								</tr>
								@endforeach
								<!-- more data -->
							</tbody>
						</table>
					</div>
					<div class="am-u-lg-12 am-cf">
						<div class="am-fr">
							<link rel="stylesheet" href="{{asset('css/app.css')}}">
							{{ $components->links() }}
						</div>
					</div>
					<script type="text/javascript">
						var compsArr = [];
    					$(function(){
    						$("#comp_type").change(function(){
    							var group_val = document.getElementById("group_choose").value;
    							var value = $(this).val();
    							var str = "{{asset('product/multicomp')}}";
    							var pid = {{$proid}};
    							var str1 = str + '/' + pid
    							var url1 = changeURLArg(str1,"type",value)
    							var url2 = changeURLArg(url1,"group",group_val)
//     							var url = str1 + '/' + value + '/' + group_val + '?name=123';
    							window.location.href= url2;
    						});
    						$("#group_choose").change(function(){
    							var comp_val = document.getElementById("comp_type").value;
    							var value = $(this).val();
    							var str = "{{asset('product/multicomp')}}";
    							var pid = {{$proid}};
    							var str1 = str + '/' + pid
    							var url1 = changeURLArg(str1,"type",comp_val)
    							var url2 = changeURLArg(url1,"group",value)
//     							var url = str1 + '/' + comp_val + '/' + value;
    							window.location.href= url2;
    						});
    					});
    					
    					onload = function() {
    						setChecked();
                    	};
     					   //得到选中复选框值
     					    function theSubmit(){
     					    	var pid = {{$proid}};
           						var str = "SelectCompId" + pid;
     					    	var checkIds = GetCookie(str);
     					    	alert(checkIds);
     					    }
     					     
     					    function SetArticleId(o, i) { 
     					       if (o.checked) {
     					        AddCookie(i);
     					        return true;
     					      }
     					      else {
          					    var hs = hasSelect(i);
            					if(hs){
            						return false;
            					} else {
            						RemoveCookie(i);
            						return true;
            					}
     					      } 
     					    }
     					     
     					    function SetCookie(name, value) {
     					      document.cookie = name + "=" + escape(value); 
      					      var input = document.getElementById("multicomps");
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
           					    var str = "SelectCompId" + pid;
     					     	d = GetCookie(str);
     					     	if (d == "") d = "|";
     					      	if (d.indexOf("|" + i + "|") == -1) {
     					            d += i + "|";
     					            SetCookie(str, d);
     					      } 
     					    }
     					  
     					    function RemoveCookie(i) {
     					    	var pid = {{$proid}};
           					    var str = "SelectCompId" + pid;
     					     	d = GetCookie(str);
     					     	var reg = new RegExp("\\|" + i + "\\|");
     					     	if (reg.test(d)) {
     					        	d = d.replace(reg, "|");  
     					        	SetCookie(str, d);
     					      }     
     					    }

      					   function setChecked() {
        						var pid = {{$proid}};
         					    var str = "SelectCompId" + pid;
       					     	d = GetCookie(str);
            					var inputa = document.getElementById("hascomps");
            					var hascompsstr = inputa.value;
//      					     	alert(hascompsstr);
     					     	compsArr = hascompsstr.split("|")
          					  	for (var i=1;i< compsArr.length - 1;i++)
              				  	{
//               					  	alert(compsArr[i]);
                					var boxName = "checkbox" + compsArr[i];
                  				  	var box = document.getElementsByName(boxName);
                  				  	if(box.length != 0){
                  				  		box[0].checked = true
                  				  	}
              				  	}
          					  	var input = document.getElementById("multicomps");
          					  	input.value = d;
       					      	if (d == "")
           					    	return 0;
       					      	var idArr = d.split("|")
          					  	for (var i=1;i< idArr.length - 1;i++)
              				  	{
                  				  	var boxName = "checkbox" + idArr[i];
                  				  	var box = document.getElementsByName(boxName);
                  				  	if(box.length != 0){
                  				  		box[0].checked = true;
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

							function hasSelect(compid){
							    for(var i = 1; i < compsArr.length - 1; i++){
							        if(compid == compsArr[i]){
							            return true;
							        }
							    }
							    return false;
							}

 					  </script>
				</div>
				<div class="widget-body  am-fr">
					<form class="am-form tpl-form-line-form"  action="{{ asset('/product/multicomps')}}/{{$proid}}" method="post" >
                    	<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="hidden" name="multicomps" id="multicomps" value="">
						<input type="hidden" name="hascomps" id="hascomps" value="{{$hascomps}}">
                   		<div class="am-form-group" >
                        	<div class="am-u-sm-9 am-u-sm-push-3">
                            	<button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">确认</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
