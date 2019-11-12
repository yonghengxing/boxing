@extends('template') @section('content')
            <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title  am-cf">为组件 {{$comp_name}} 增加可访问的机关用户</div>
							</div>
							<form class="am-form tpl-form-border-form  tpl-form-border-br"
								action="{{ asset('authority/addapprer')}}/{{$comp_id}}/{{$pro_id}}" method="post"
								enctype="multipart/form-data">
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
    							@for($idx = 0;$idx < $node_count;$idx++)
                                    <div class="am-form-group" index="1">
                                    	<div class="am-u-sm-12 am-u-md-12 am-u-lg-3">
                                            <div class="am-input-group am-input-group-sm tpl-form-border-form cl-p">
                                          		<div class="widget-title  am-cf">审批流程第{{$idx + 1}}个节点: {{$node_namelist[$idx]}} 的人员如下</div>
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
                                                 @foreach($node_users[$idx] as $nodeuser)
                                                    <tr class="gradeX">
                                                       <td>{{ $nodeuser->approver->true_name }}</td>
                                                       <td>{{ $nodeuser->created_at }}</td>
                                                       <td>
                                                     	<label class="am-radio-inline">
                                                          <input type="radio" id="auth_{{$nodeuser->approver_id}}" name="auth_{{$nodeuser->approver_id}}" value="0" data-am-ucheck checked>不授权
                                                        </label>
                                                        <label class="am-radio-inline">
                                                          <input type="radio" id="auth_{{$nodeuser->approver_id}}" name="auth_{{$nodeuser->approver_id}}" value="1" data-am-ucheck>授权
                                                        </label>
                                                       </td>
                                                    </tr>
                                                     @endforeach
                                                    <!-- more data -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endfor
                                <div class="am-form-group">
									<div class="am-u-sm-9 am-u-sm-push-3">
									<button type="submit"
										class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
									</div>
								</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
@stop
