@extends('template') @section('content')

            <div class="row-content am-cf">
                <div class="row">
                    
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">创建产品库</div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body am-fr">

                                <form class="am-form tpl-form-border-form  tpl-form-border-br" action="{{ asset('/app/new')}}" method="post">
                                    
                                    <div class="am-form-group">
                                        <label for="user-phone" class="am-u-sm-3 am-form-label">所属组<span class="tpl-form-line-small-title"> Repository</span></label>
                                        <div class="am-u-sm-9">
                                            <select data-am-selected="{searchBox: 1}" style="display: none;" name="group_id">
                                             @foreach($groups as $group)
                                              <option value="{{ $group->id }}">{{ $group->name }}</option>
                                             @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label">产品名称 <span class="tpl-form-line-small-title">Space</span></label>
                                        <div class="am-u-sm-9">
                                            <input type="text" class="tpl-form-input" id="app_name" name="app_name" placeholder="请输入名称">
                                            <small>中文、字母、数字、下划线</small>
                                        </div>
                                    </div>
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label">描述 <span class="tpl-form-line-small-title"> Description</span></label>
                                        <div class="am-u-sm-9">
                                           <textarea class="" rows="10" id="app_desc" name="app_desc" placeholder="请输入描述内容"></textarea>
                                           <small></small>
                                        </div>
                                    </div>
                                   
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-3">
                                            <button type="submit" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@stop
