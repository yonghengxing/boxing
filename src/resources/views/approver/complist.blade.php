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
                                    <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                                <th>名称</th>
                                                <th>描述</th>
                                                <th>类型</th>
                                                <th>所属单位</th>
                                                <th>状态</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody  id = "comptable" name = "comptable">
                                         @foreach($components as $component)
                                            <tr class="gradeX">
                                               <td>{{ $component->comp_name }}</td>
                                               <td>{{ str_limit($component->comp_desc ,100,"...") }}</td>
                                               <td>{{ config("app.comp_type")[$component->comp_type] }}</td>
                                               <td>{{ $component->group_name }}</td>
                                               <td>
            										@if($component->appr_status == 10001)
            											<font color="#FF0000">{{ config("app.comp_status")[$component->appr_status] }}</font>
            										@else
            											{{ config("app.comp_status")[$component->appr_status] }}
            										@endif
            									</td>
                                               <td>
                                                    <div class="tpl-table-black-operation">
                                                    	<a href="{{ asset('/apprvoer/requestlist')}}/{{$component->id}}">
                                                            <i class="am-icon-pencil"></i> 详情
                                                        </a>
                                                    </div>
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
                                    onload = function() {
                                		setInterval(refresh, 5000);
                                	};
                                    $(function(){
                						$("#comp_type").change(function(){
                							var group_val = document.getElementById("group_choose").value;
                							var value = $(this).val();
                							var str1 = "{{asset('approver/complist')}}";
                							var url = str1 + '/' + value + '/' + group_val;
                							window.location.href= url;
                						});
                						$("#group_choose").change(function(){
                							var comp_val = document.getElementById("comp_type").value;
                							var value = $(this).val();
                							var str1 = "{{asset('approver/complist')}}";
                							var url = str1 + '/' + comp_val + '/' + value;
                							window.location.href= url;
                						});
                					});
                                    function refresh(){
								        var objectModel = {};
								        var group_val = document.getElementById("group_choose").value;
								        var comp_val = document.getElementById("comp_type").value;
								        var page = {{ $components->currentPage() }}
								        objectModel["group_val"] = group_val;
								        objectModel["comp_val"] = comp_val;
								        objectModel["page"] = page;
								        var csrf = "_token";
		                        		var ctoken = "{{csrf_token()}}";
		                        		objectModel[csrf] = ctoken;
								        $.ajax({
								            url:"{{url('/approver/getcomps')}}", //你的路由地址
								            type:"post",
								            dataType:"json",
								            data:objectModel,
								            timeout:30000,
								            success:function(data){
									            $("#comptable").empty();
								                var count = data.length;
								                var i = 0;
								                var x="";
								                for(i=0;i<count;i++){
								                       x+='<tr class="gradeX"><td>'+data[i].comp_name+'</td><td>'+ 
								                       data[i].comp_desc + '</td><td>' + 
								                       data[i].comp_type + '</td><td>' + 
								                       data[i].group_name + '</td><td>' + 
								                       data[i].status_str + '</td><td><div class="tpl-table-black-operation"><a href="' + 
								                       data[i].url + '"><i class="am-icon-pencil"></i> 详情</a></div></td></tr>';
								                }
								                $("#comptable").append(x);

								            }
								        });
								    }
            					</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@stop
