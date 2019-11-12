@extends('template') @section('content')
           <div class="row-content am-cf">
                <div class="row">
                    <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
                        <div class="widget am-cf">
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">{{$title}}</div>
                                <div class="widget-function am-fr">
                                    <a href="javascript:;" class="am-icon-cog"></a>
                                </div>
                            </div>
                            <div class="widget-body am-fr">
                                <form class="am-form tpl-form-border-form  tpl-form-border-br">
                                	 
                                     <div class="am-form-group" id="pre_app" >
                                        <label  class="am-u-sm-3 am-form-label">选择产品 <span class="tpl-form-line-small-title"> Repository</span></label>
                                        <div class="am-u-sm-9">
                                            <select data-am-selected="{searchBox: 1}" style="display: none;" name="project_id">
                                            @foreach($projects as $project)
                                              <option value="{{ $project->id }}">{{ $project->name }} - {{ str_limit($project->description,100,"...") }}</option>
                                             @endforeach
                                            </select>
                                        </div>
                                    </div>
                                 
                                    <div class="am-form-group">
                                        <label for="user-name" class="am-u-sm-3 am-form-label">申请说明 <span class="tpl-form-line-small-title"> Commit Message</span></label>
                                        <div class="am-u-sm-9">
                                           <textarea class="" rows="10" id="group-intro" placeholder="请输入描述内容"></textarea>
                                            <small></small>
                                        </div>
                                    </div>
                           

                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl"> 审批人员选择</div>
                            </div>
                            <div class="widget-body am-fr">

                                    <div class="am-form-group" index="1" id="authenNode0">
                                        <label for="user-name" class="am-u-sm-3 am-form-label">审批人 (1)</label>
                                        <div class="am-u-sm-9">
                                           <select data-am-selected="{searchBox: 1}" style="display: none;" id="person_1">
                                              <option value="a">欧阳倩</option>
                                              <option value="b">张海峰</option>
                                              <option value="o">罗珊珊</option>
                                            </select>

                                        </div>
                                    </div>




                                     <div class="am-form-group" index="1">
                                        <label for="user-name" class="am-u-sm-3 am-form-label"></label>
                                        <div class="am-u-sm-9">
                                            <div class="am-form-group">
                                                        <div class="am-btn-toolbar">
                                                            <div class="am-btn-group am-btn-group-xs">
                                                                <button type="button" class="am-btn am-btn-default am-btn-success" onclick="addAuthenNode();"><span class="am-icon-plus"></span> 增加审批节点</button>
                                                                <button type="button" class="am-btn am-btn-default am-btn-danger" onclick="deleteAuthenNode();"><span class="am-icon-trash-o"></span> 删除审批节点</button>
                                                            </div>
                                                        </div>
                                            </div>
                                        </div>
                                    </div>

                                   <div id="authenPerson">  </div>
                                 
                                  <script type="text/javascript">
                                     var authenNodeIndex = 1;
                                     function addAuthenNode()
                                     {
                                        authenNodeIndex++;
                                        var str = ' <div class="am-form-group" index="'+authenNodeIndex+'"  id="authenNode'+authenNodeIndex+'"><label for="user-name" class="am-u-sm-3 am-form-label">审批人 ('+authenNodeIndex+')</label><div class="am-u-sm-9"><select data-am-selected="{searchBox: 2}" style="" id="person_'+authenNodeIndex+'"> <option value="a">欧阳倩</option><option value="b">张海峰</option><option value="o">罗珊珊</option></select></div></div>';
                                        $("#authenPerson").append(str);
                                      
                                     }
                                     function deleteAuthenNode()
                                     {
                                        if(authenNodeIndex < 1){
                                          return;
                                        }
                                        $("#authenNode"+authenNodeIndex).remove();
                                        authenNodeIndex--;
                                     }
 

                                  </script>

                            </div>
                                  
                                    <div class="am-form-group">
                                        <div class="am-u-sm-9 am-u-sm-push-3">
                                            <button type="button" class="am-btn am-btn-primary tpl-btn-bg-color-success ">提交申请</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@stop
