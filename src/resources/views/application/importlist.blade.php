@extends('template') @section('content')

        <!-- 内容区域 -->
            <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title  am-cf">产品入库列表</div>

                            </div>
                            <div class="widget-body  am-fr">

                               
                                <div class="am-u-sm-12 am-u-md-12 am-u-lg-3">
                                    <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                                       
                                        <span class="am-input-group-btn">
								            <a  href="{{ asset('/app/request')}}/import" type="button" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 发起入库申请</a>
							          </span>
                                    </div>
                                </div>

                                <div class="am-u-sm-12">
                                    <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                                <th>库名称</th>
                                                <th>详细</th>
                                                <th>发起时间</th>
                                                <th>状态</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="gradeX">
                                                <td>ISSD</td>
                                                <td> <small>ISSD-ITEM-001组件开发完毕，申请入库</small></td>
                                                <td>2018-10-01 10:22:29</td>
                                                <td>审核中</td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <a href="javascript:;" class="tpl-table-black-operation-del">
                                                            <i class="am-icon-trash"></i> 撤回
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                             <tr class="gradeX">
                                                <td>ISSD</td>
                                                <td> <small>ISSD-ITEM-002组件开发完毕，申请入库</small></td>
                                                <td>2018-10-02 10:22:29</td>
                                                <td>审核通过，等待入库</td>
                                                <td>
                                                    <div class="tpl-table-black-operation">
                                                        <a href="{{ asset('/app/import')}}" class="tpl-table-black-operation-import">
                                                            <i class="am-icon-briefcase"></i> 入库
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                             <tr class="gradeX">
                                                <td>ISSD</td>
                                                <td> <small>ISSD-ITEM-009组件开发完毕，申请入库</small></td>
                                                <td>2018-10-03 11:22:29</td>
                                                <td>入库完毕</td>
                                                <td></td>
                                            </tr>
                                           
                                            <!-- more data -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="am-u-lg-12 am-cf">

                                    <div class="am-fr">
                                        <ul class="am-pagination tpl-pagination">
                                            <li class="am-disabled"><a href="#">«</a></li>
                                            <li class="am-active"><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                            <li><a href="#">»</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@stop
