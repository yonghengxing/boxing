@extends('template') @section('content')
            <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title  am-cf">产品列表</div>


                            </div>
                            <div class="widget-body  am-fr">

                               
                                <div class="am-u-sm-12 am-u-md-12 am-u-lg-3">
                                    <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                                      <a   href="{{ asset('/app/new')}}" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 新增</a>
                                    </div>
                                </div>

                                <div class="am-u-sm-12">
                                    <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                            	<th>ID</th>
                                                <th>名称</th>
                                                <th>描述</th>
                                                <th>类型</th>
                                                <th>创建时间</th>
                                                <th>创建人</th>
                                                <th>创建单位</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach($projects as $project)
                                            <tr class="gradeX">
                                               <td>{{ $project->id }}</td>
                                               <td>{{ $project->name }}</td>
                                               <td>{{ str_limit($project->description,100,"...") }}</td>
                                               <td>{{ $project->type }}</td>
                                               <td>{{ $project->created_at }}</td>
                                               <td>{{ $project->owner->name }}</td>
                                               <td>{{ $project->group->name }}</td>
                                               
                                               <td>
                                                    <div class="tpl-table-black-operation">
                                                        <a href="user-edit.html">
                                                            <i class="am-icon-pencil"></i> 编辑
                                                        </a>
                                                        <a href="{{ asset('/app/delete')}}/{{ $project->id }}" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-trash"></i> 删除
                                                        </a>
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
