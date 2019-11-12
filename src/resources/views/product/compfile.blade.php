@extends('template') @section('content')
  <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title  am-cf">文件列表</div>
                            </div>
                            <div class="widget-body  am-fr">

                                <div class="am-u-sm-12">
                                    <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black " id="example-r">
                                        <thead>
                                            <tr>
                                        	    <th>文件名称</th>
                                        	    <th>文件路径</th>
                                        	    <th>创建时间</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($compFile as $compFile)
                                            <tr class="gradeX">
                                            	<td>{{ $compFile->profile }}</td>
                                                <td>{{ $compFile->profilepath }}</td>
                                                <td>{{ $compFile->created_at }}</td>
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
