@extends('template') @section('content')
            <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title  am-cf">问题列表</div>


                            </div>
                            <div class="widget-body  am-fr">

                               
                                {{--<div class="am-u-sm-12 am-u-md-12 am-u-lg-3">
                                    <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                                      <a   href="{{ asset('/issue/new')}}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增</a>
                                    </div>
                                </div>--}}

                                <div class="am-u-sm-12">
                                    <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                                <th>标题</th>
                                                <th>描述</th>
                                                <th>组件</th>
                                                <th>版本</th>
                                                <th>报告人</th>
                                                <th>响应人</th>
                                                <th>提出时间</th>
                                                <th>状态</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach($issues as $issue)
                                            <tr class="gradeX">
                                               <td>{{ $issue->title }}</td>
                                               <td>{{ str_limit($issue->description,60,"...") }}</td>
                                               <td>{{ $issue->component->comp_name }}</td>
                                               <td>{{ $issue->ver_num }}</td>
                                               <td>{{ $issue->tester->true_name }}</td>
                                               <td>{{ $issue->developer->true_name }}</td>
                                               <td>{{ $issue->created_at }}</td>
                                               <td>{{ config("app.issue_status")[$issue->status] }}</td>
                                               <td>
                                                    <div class="tpl-table-black-operation">
                                                        <a href="{{ asset('issue/info')}}/{{$issue->id }}">
                                                            <i class="am-icon-pencil"></i> 编辑
                                                        </a>
                                                        <a href="{{ asset('issue/delete')}}/{{$issue->id }}" class="tpl-table-black-operation-del" onclick="return del()">
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
                                		{{ $issues->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@stop
