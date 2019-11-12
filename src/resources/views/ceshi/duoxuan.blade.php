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
                                        	<input name="checkbox{{$component->id}}" id="checkbox{{$component->id}}" type="checkbox"   onclick="SetArticleId(this,{{$component->id}});" /> </td>
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
    					$(function(){
    						$("#comp_type").change(function(){
    							var group_val = document.getElementById("group_choose").value;
    							var value = $(this).val();
    							var str1 = "{{asset('ceshi/duoxuan')}}";
    							var url1 = changeURLArg(str1,"type",value)
    							var url2 = changeURLArg(url1,"group",group_val)
//     							var url = str1 + '/' + value + '/' + group_val + '?name=123';
    							window.location.href= url2;
    						});
    						$("#group_choose").change(function(){
    							var comp_val = document.getElementById("comp_type").value;
    							var value = $(this).val();
    							var str1 = "{{asset('ceshi/duoxuan')}}";
    							var url1 = changeURLArg(str1,"type",comp_val)
    							var url2 = changeURLArg(url1,"group",value)
//     							var url = str1 + '/' + comp_val + '/' + value;
//     							var url2 = changeURLArg(url,'name',123)
    							window.location.href= url2;
    						});
    					});
    					onload = function() {
    						setChecked();
                    	};
     					   //得到选中复选框值
     					    function theSubmit(){
     					     var checkIds = GetCookie("SelectCompId");
     					     alert(checkIds);
     					    }
     					     
     					    function SetArticleId(o, i) { 
     					       if (o.checked) {
     					        AddCookie(i);
      					        alert(i);
     					      }
     					      else {
     					        RemoveCookie(i);
     					      } 
     					    }
     					     
     					    function SetCookie(name, value) {
     					      document.cookie = name + "=" + escape(value); 
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
     					      d = GetCookie("SelectCompId");
     					      if (d == "") d = "|";
     					      if (d.indexOf("|" + i + "|") == -1) {
     					            d += i + "|";
     					            SetCookie("SelectCompId", d);
     					      } 
     					    }
     					  
     					    function RemoveCookie(i) {
     					      d = GetCookie("SelectCompId");
     					      var reg = new RegExp("\\|" + i + "\\|");
     					      if (reg.test(d)) {
     					        d = d.replace(reg, "|");  
     					        SetCookie("SelectCompId", d);
     					      }     
     					    }

      					   function setChecked() {
       					      d = GetCookie("SelectCompId");
       					      if (d == "")
           					      return 0;
          					   alert(d)
       					      var idArr = d.split("|")
          					  for (var i=1;i< idArr.length - 1;i++)
              				  {
                   				  alert(idArr[i])
                  				  var boxName = "checkbox" + idArr[i]
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

        					function getQueryString(name) {  
        				        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");  
        				        var r = window.location.search.substr(1).match(reg);  
        				        if (r != null) return unescape(r[2]);  
        				        return null;  
        				    } 
 					  </script>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
