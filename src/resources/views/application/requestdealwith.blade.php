@extends('template') @section('content')
            <div class="row-content am-cf">
                <div class="row">
                    
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">产品入库申请</div>
                                
                            </div>
                            <div class="widget-body am-fr">

                                <form class="am-form tpl-form-border-form  tpl-form-border-br">
                                    

                                     <div class="am-form-group">
                                        <label for="user-phone" class="am-u-sm-3 am-form-label">仓库 <span class="tpl-form-line-small-title"> Repository</span></label>
                                        <div class="am-u-sm-9">
                                            <small> OSCC </small>
                                        </div>
                                    </div>

                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label">入库申请说明 <span class="tpl-form-line-small-title"> Commit Message</span></label>
                                        <div class="am-u-sm-9">
                                           <small> 版本开发、测试完毕，将release版本申请入库 </small>
                                        </div>
                                    </div>


                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl"> 审批人员</div>
                            
                            </div>
                            <div class="widget-body am-fr">

                                    <div class="am-form-group" index="1" id="authenNode0">
                                        <label for="user-name" class="am-u-sm-3 am-form-label">审批人 员列表:</label>
                                        <div class="am-u-sm-9">
                                        	<ul>
		                                         	<li>   欧阳倩 , 2018-10-01 10:34:30 </li>
	                                           		<li>  张峰	 , 2018-10-02 11:45:10</li>
                                             </ul>
                                        </div>
                                    </div>

                            </div>
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-3">
                                            <button type="button" class="am-btn am-btn-success tpl-btn-bg-color-success ">批准</button>
                                            <button type="button" class="am-btn am-btn-danger tpl-btn-bg-color-success ">拒绝</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>


            </div>
@stop
