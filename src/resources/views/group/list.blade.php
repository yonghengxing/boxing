@extends('template') @section('content')
       <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title  am-cf">单位列表</div>
                            </div>
                            <div class="widget-body  am-fr">
                                <div class="am-u-sm-12 am-u-md-12 am-u-lg-3">
                                @if($isAdmin)
                                    <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                                      <a  href="{{ asset('/group/new')}}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增</a>
                                    </div>
                                @endif
                                </div>

                                <div class="am-u-sm-12">
                                    <table   class="am-table am-table-compact am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                        	    <th>ID</th>
                                                <th>名称</th>
                                                <th>详细</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($groups as $group)
                                            <tr class="gradeX">
                                                <td>{{ $group->id }}</td>
                                                <td>{{ $group->group_name }}</td>
                                                <td>{{str_limit($group->group_desc,140,"...") }}</td>
                                                <td>
                                                <div class="tpl-table-black-operation">
                                                @if($isAdmin || config('app.admin_mode',false))
                                                        <a href="{{ asset('group/edit')}}/{{$group->id }}">
                                                            <i class="am-icon-pencil"></i> 编辑
                                                        </a>
                                                        <a href="{{ asset('group/delete')}}/{{$group->id }}" class="tpl-table-black-operation-del" onclick="return del()">
                                                            <i class="am-icon-trash"></i> 删除
                                                            <script> 
																function del(){
																	if(confirm("确定要删除吗？")){
																		alert('删除成功！');
																		return true;
																	}else{
																		return false; 
																	}
																} 
															</script> 
                                                    
                                                @endif
                                                </div>
                                                </td>
                                            </tr>
                                         @endforeach
                                            <!-- more data -->
                                        </tbody>
                                    </table>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@stop
