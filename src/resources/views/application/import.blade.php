@extends('template') @section('content')
            <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">入库</div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body am-fr">
                                <form class="am-form tpl-form-border-form  tpl-form-border-br" action="{{ asset('/app/import')}}" method="post" enctype="multipart/form-data">
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"><span class="tpl-form-line-small-title"></span></label>
                                        <div class="am-u-sm-9">
                                          <div class="am-form-group am-form-file">
                                              <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                                <i class="am-icon-cloud-upload"></i> 选择要上传的产品组件</button>
                                              <input id="doc-form-file" type="file" multiple name="appfile"/>
                                            </div>
                                            <div id="file-list"></div>
                                            <script>
                                              $(function() {
                                                $('#doc-form-file').on('change', function() {
                                                  var fileNames = '';
                                                  $.each(this.files, function() {
                                                    fileNames += '<span class="am-badge">' + this.name + '</span> ';
                                                  });
                                                  $('#file-list').html(fileNames);
                                                });
                                              });
                                            </script>  
                                        </div>
                                    </div>

                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label">描述 <span class="tpl-form-line-small-title"> Commit Message</span></label>
                                        <div class="am-u-sm-9">
                                           <textarea class="" rows="10" id="group-intro" placeholder="请输入描述内容"></textarea>
                                           <small></small>
                                        </div>
                                    </div>

                                  <div class="am-form-group">
                                        <label for="user-phone" class="am-u-sm-3 am-form-label">仓库 <span class="tpl-form-line-small-title"> Repository</span></label>
                                        <div class="am-u-sm-9">
                                          hello25
                                        </div>
                                   </div>
                                  
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-3">
                                            <button type="t" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
@stop
