@extends('template') @section('content')
  <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title  am-cf">产品文件详情</div>
                            </div>
                            <div class="widget-body  am-fr">
                				<div class="am-u-sm-12 am-u-md-12 am-u-lg-3">
                                         <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                                              <a   href="{{asset('/product/fileremove')}}/{{$proid}}" class="am-btn am-btn-default am-btn-danger"><span class="am-icon-trash-o"></span> 移除文件</a>
                                         </div>
                                </div>
                            </div>
                            <div class="widget-body  am-fr">

                                <div class="am-u-sm-12">
                                    <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                        	    <th>组件名称</th>
                                        	    <th>文件路径</th>                                        	    
                                        	    <th>文件名称</th>
                                        	    <th>创建时间</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($mProcLists as $mProcList)
                                            <tr class="gradeX">
                                                <td>{{ $mProcList->component->comp_name }}</td>
                                                <td>{{ $mProcList->profilepath }}</td>
                                                <td>{{ $mProcList->profile }}</td>                                                
                                                <td>{{ $mProcList->created_at }}</td>
                                            </tr>
                                         @endforeach
                                            
                                            <!-- more data -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="am-u-lg-12 am-cf">
            						<div class="am-fr">
            							<link rel="stylesheet" href="{{asset('css/app.css')}}">
            							{{ $mProcLists->links() }}
            						</div>
            					</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
@stop
