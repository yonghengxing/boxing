@extends('template') @section('content')

<script src="{{asset('lib/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('lib/js/jquery.cxselect.js')}}"></script>
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">


                            <form class="am-form tpl-form-line-form"  action="{{ asset('/product/sendauthfile')}}" method="post" >
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="am-alert" data-am-alert
                                <?php

                                    //if( empty($_REQUEST) && $_REQUEST['ConnectionError']){
                                    if(!array_key_exists('ConnectionError', $_GET)){
                                        echo "style='display: none'";
                                    }
                                    ?> >
                                    <button type="button" class="am-close">&times;</button>
                                    <p>连接失败！IP地址不正确或设备未开启FTP服务</p>
                                </div>

                                <div class="am-alert" data-am-alert
                                <?php

                                   // if( empty($_REQUEST) && $_REQUEST['RelationError']){
                                    if(!array_key_exists('RelationError', $_GET)){
                                        echo "style='display: none'";
                                    }
                                    ?> >
                                    <button type="button" class="am-close">&times;</button>
                                    <p>授权文件推送失败！检查设备<?php
                                        if(array_key_exists('equType', $_GET))
                                            //  echo $_GET['equType'];
                                            echo "<span style='color:#fdff50;font-size:18px;'>" .$_GET['equType']."</span>"

                                        ?>是否已生成过授权文件?</p>
                                </div>

                                <div class="am-alert am-alert-success " data-am-alert
                                <?php

                                    // if( empty($_REQUEST) && $_REQUEST['RelationError']){
                                    if(!array_key_exists('sendSuccess', $_GET)){
                                        echo "style='display: none'";
                                    }
                                    ?> >
                                    <button type="button" class="am-close">&times;</button>
                                    <p>授权文件推送成功！</p>
                                </div>

                                <div class="am-form-group am-form-success am-form-icon am-form-feedback" style="margin-top:50px;margin-bottom:20px;">
                                    <label for="doc-ipt-3-a" class="am-u-sm-2 am-form-label">设备IP</label>
                                    <div class="am-u-sm-10">
                                        <input type="text" id="doc-ipt-3-a" class="am-form-field" name="ip" value="{{ $ip }}" placeholder="输入设备IP，推送授权文件到设备">

                                    </div>
                                </div>



                                <div class="am-form-group" >
                                    <div class="am-u-sm-9 am-u-sm-push-3">
                                        <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">推送授权文件</button>
                                    </div>
                                </div>
                            </form>

                        </div>


                    </div>
                </div>
            </div>
        </div>


@stop