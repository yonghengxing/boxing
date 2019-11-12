@extends('template') @section('content')
       <div class="container-fluid am-cf">
            <div class="row">
                <div class="am-u-sm-12 am-u-md-12 am-u-lg-9">
                    <div class="page-header-heading"><span class="am-icon-home page-header-heading-icon"></span> 部件首页 <small> </small></div>
                    <p class="page-header-description">波形管理系统，产品出库、入库一站式管理平台。</p>
                </div>
                <div class="am-u-lg-3 tpl-index-settings-button">
                    <button type="button" class="page-header-button"><span class="am-icon-paint-brush"></span> 设置</button>
                </div>
            </div>

        </div>

        <div class="row-content am-cf">
            <div class="row  am-cf">
                <div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
                    <div class="widget widget-purple am-cf">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-fl">产品数量</div>
                            <div class="widget-function am-fr">
                                <a href="javascript:;" class="am-icon-cog"></a>
                            </div>
                        </div>
                        <div class="widget-body am-fr">
                            <div class="am-fr am-cf">
                                <div class="widget-statistic-value">
                                {{ $procNum->count() }} 件
                            	</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                 <div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
                    <div class="widget widget-primary am-cf">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-fl">组件数量</div>
                            <div class="widget-function am-fr">
                                <a href="javascript:;" class="am-icon-cog"></a>
                            </div>
                        </div>
                        <div class="widget-body am-fr">
                            <div class="am-fr am-cf">
                                <div class="widget-statistic-value">
                                {{ $compNum  }}件
                            	</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
                    <div class="widget widget-purple am-cf">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-fl">设备数量</div>
                            <div class="widget-function am-fr">
                                <a href="javascript:;" class="am-icon-cog"></a>
                            </div>
                        </div>
                        <div class="widget-body am-fr">
                            <div class="am-fr am-cf">
                                <div class="widget-statistic-value">
                                {{ $dev_unique  }}件
                            	</div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
			
			<div class="row  am-cf">
                 <div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
                    <div class="widget widget-primary am-cf">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-fl">等待审批组件数量</div>
                            <div class="widget-function am-fr">
                                <a href="javascript:;" class="am-icon-cog"></a>
                            </div>
                        </div>
                        <div class="widget-body am-fr">
                            <div class="am-fr am-cf">
                                <div class="widget-statistic-value">
                                {{ $apprNum  }}件
                            	</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
                    <div class="widget widget-purple am-cf">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-fl">产品库中可用的组件版本总数</div>
                            <div class="widget-function am-fr">
                                <a href="javascript:;" class="am-icon-cog"></a>
                            </div>
                        </div>
                        <div class="widget-body am-fr">
                            <div class="am-fr am-cf">
                                <div class="widget-statistic-value">
                                {{ $verNum  }}件
                            	</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                 <div class="am-u-sm-12 am-u-md-6 am-u-lg-4">
                    <div class="widget widget-primary am-cf">
                        <div class="widget-head am-cf">
                            <div class="widget-title am-fl">等待测试组件数量</div>
                            <div class="widget-function am-fr">
                                <a href="javascript:;" class="am-icon-cog"></a>
                            </div>
                        </div>
                        <div class="widget-body am-fr">
                            <div class="am-fr am-cf">
                                <div class="widget-statistic-value">
                                {{ $testNum  }}件
                            	</div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="row am-cf">
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
                                        <tbody>
                                         @foreach($components as $component)
                                            <tr class="gradeX">
                                               <td>{{ $component->comp_name }}</td>
                                               <td>{{ str_limit($component->comp_desc ,100,"...") }}</td>
                                               <td>{{ config("app.comp_type")[$component->comp_type] }}</td>
                                               <td>{{ $component->group->group_name }}</td>
                                                <td>{{ config("app.comp_status")[$component->appr_status] }}</td>
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
    </div>
    
</div>
@stop