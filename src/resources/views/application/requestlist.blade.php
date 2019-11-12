@extends('template') @section('content')
            <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title  am-cf">出入库审批列表</div>
                            </div>
                            <div class="widget-body  am-fr">

                               
                                <div class="am-u-sm-12">
                                    <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                                <th>申请人</th>
                                                <th>产品库</th>
                                                <th>操作</th>
                                                <th>时间</th>
                                                <th>状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="gradeX">
                                                <td>张琳</td>
                                                <td>ISSD</td>
                                                <td>入库</td>
                                                <td>2010-10-10 12:30:23</td>
                                                <td>等待入库</td>
                                            </tr>
                                           <tr class="gradeX">
                                                <td>张琳</td>
                                                <td>ISSD</td>
                                                <td>出库</td>
                                                <td>2010-10-10 12:30:23</td>
                                                <td>完毕</td>
                                            </tr>
                                           <tr class="gradeX">
                                                <td>张琳</td>
                                                <td>ISSD</td>
                                                <td>出库</td>
                                                <td>2010-10-10 12:30:23</td>
                                                <td>等待出库</td>
                                            </tr>
                                           <tr class="gradeX">
                                                <td>张琳</td>
                                                <td>ISSD</td>
                                                <td>入库</td>
                                                <td>2010-10-10 12:30:23</td>
                                                <td>审批中</td>
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
