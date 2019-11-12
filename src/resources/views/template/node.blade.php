@extends('template') @section('content')
            <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title  am-cf">节点人员列表</div>
							</div>
                            <div class="widget-body  am-fr">
                            	<div class="am-u-sm-12 am-u-md-12 am-u-lg-3">
                                    <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                                  		<a   href="{{ asset('/template/nodeappend')}}/{{$node_id}}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 节点追加人员</a>
                                    </div>
                                </div>
                                <div class="am-u-sm-12">
                                    <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                                <th>姓名</th>
                                                <th>创建时间</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach($nodeusers as $nodeuser)
                                            <tr class="gradeX">
                                               <td>{{ $nodeuser->approver->true_name }}</td>
                                               <td>{{ $nodeuser->created_at }}</td>
                                               <td>
                                                    <div class="tpl-table-black-operation">
                                                    	<a href="{{ asset('/template/deleteappr')}}/{{$nodeuser->id}}" class="tpl-table-black-operation-del" onclick="return del()">
                                                            <i class="am-icon-trash"></i> 取消授权
                                                        </a>
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
                                		{{ $nodeusers->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@stop
