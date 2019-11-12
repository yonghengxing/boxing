<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//index
Route::get('/index', 'IndexController@index');
Route::get('/bxLogout', 'BXUserController@bxLogout');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/group/list', 'GroupController@group_list');

Route::get('/ceshi/new', 'CeshiController@ceshi_newrecr');


/**
* 用户相关操作路由
* @date: 2018年11月20日 下午3:35:09
* @author: wongwuchiu
*/
Route::get('/user/list', 'UserController@user_list');
Route::get('/user/info/{user_id}', 'UserController@user_info');
Route::get('/user/new', 'UserController@user_new');
Route::post('/user/new', 'UserController@user_new_do');
Route::get('/user/delete/{user_id}', 'UserController@user_delete');
Route::post('/user/info/{user_id}', 'UserController@user_update');
Route::get('/user/role/{select_role}/{select_group}', 'UserController@user_role_list');


/**
* 开发方相关操作路由
* @date: 2018年11月19日 下午8:14:19
*/
Route::get('/developer/complist/{select_type}/{select_group}/{import_status}', 'DeveloperController@dev_complist');
Route::any('/developer/eventlist', 'DeveloperController@dev_eventlist');
Route::get('/developer/import/{comp_id}', 'DeveloperController@dev_import');
Route::post('/developer/import/{comp_id}', 'DeveloperController@dev_import_do');
Route::get('/developer/addtest/{event_id}', 'DeveloperController@dev_addtest');

 /** 产品相关操作路由
 * @date: 2018年11月19日 下午8:14:19
 */
Route::any('/product/show', 'ProductController@ProIndexCreate');
Route::any('/product/message/{proall_id}', 'ProductController@ProCreate');
Route::get('/product/newcomp/{proall_id}', 'ProductController@procNewComp');
Route::post('/product/newcomp/{proall_id}', 'ProductController@procNewCompDo');
Route::get('/product/productlist/{proall_id}/{comp_id}/{p2cid}', 'ProductController@procFile');
Route::post('/product/productlist/{proall_id}/{comp_id}/{p2cid}', 'ProductController@procFileDo');
Route::any('/product/compfile/{proall_id}/{comp_id}', 'ProductController@compFileList');
Route::any('/product/getVersion', 'ProductController@getVersion');
Route::any('/product/getComponent/{select_type}', 'ProductController@getComponent');
Route::any('/product/devices', 'ProductController@getDevices');
Route::any('/product/inputIp', 'ProductController@inputIp');
Route::any('/product/sendToEqu', 'ProductController@sendToEqu');
Route::any('/product/proclistview', 'ProductController@showProcList');

Route::get('/product/newproc', 'ProductController@procNew');
Route::post('/product/newproc', 'ProductController@procNewDo');
Route::get('/product/complist/{proid}/{select_type}/{select_group}', 'ProductController@procShowComp');
Route::get('/product/choosecomp/{proid}/{compid}', 'ProductController@procChooseComp');
Route::get('/product/removecomp/{promessageid}/{proid}', 'ProductController@procRemoveComp');
Route::get('/product/proceditlist/{select_group}', 'ProductController@procEditList');
Route::get('/product/procfileshow/{proid}', 'ProductController@procFileShow');
Route::get('/product/showsendrec', 'ProductController@showSendRecord');
Route::get('/product/genauthfile/{record_id}', 'ProductController@genauthfile');
Route::get('/product/authfile', 'ProductController@authfile');
Route::post('/product/sendauthfile', 'ProductController@sendAuthToEqu');
Route::get('/product/multicomp/{proid}', 'ProductController@procMulitComp');
Route::post('/product/multicomps/{proid}', 'ProductController@procMulitCompDo');
Route::get('/product/removemulticomp/{proid}', 'ProductController@procDeleMulitComp');
Route::post('/product/removemulticomps/{proid}', 'ProductController@procDeleMulitCompDo');
Route::get('/product/fileremove/{proid}', 'ProductController@procFileRemove');
Route::post('/product/remove/{proid}', 'ProductController@procFileRemoveDo');

/**
 * 测试方相关操作路由
 * @date: 2018年11月19日 下午8:14:19
 */
Route::get('/tester/complist/{select_type}/{select_group}', 'TesterController@test_complist');
Route::get('/tester/eventlist', 'TesterController@test_eventlist');
Route::get('/tester/versionlist/{comp_id}', 'TesterController@test_versionlist');
Route::get('/tester/info/{event_id}', 'TesterController@test_info');
Route::get('/tester/download/{event_id}', 'TesterController@test_download');
Route::get('/tester/request/{comp_id}', 'TesterController@test_request');
Route::post('/tester/request/{comp_id}', 'TesterController@test_request_do');
Route::get('/tester/import/{event_id}', 'TesterController@test_import');
Route::post('/tester/import/{event_id}', 'TesterController@test_import_do');

/**
 *机关方相关操作路由
 * @date: 2018年11月19日 下午8:14:19
 */
Route::get('/approver/complist/{select_type}/{select_group}', 'ApproverController@appr_complist');
Route::get('/approver/eventlist', 'ApproverController@appr_eventlist');
Route::get('/apprvoer/requestlist/{comp_id}', 'ApproverController@appr_requestlist');
Route::get('/apprvoer/info/{event_id}', 'ApproverController@appr_info');
Route::get('/apprvoer/detail/{event_id}', 'ApproverController@appr_detail');
//Route::post('/approver/pass/{event_id}', 'ApproverController@appr_pass');
Route::post('/approver/makechoice/{event_id}', 'ApproverController@appr_makechoice');
Route::post('/approver/getcomps', 'ApproverController@appr_getcomps');
Route::get('/approver/test/{comp_id}/{node_id}', 'ApproverController@checkNextStep');

/**
* 随便写的测试方法 ，记得删除
* @date: 2018年11月23日 下午7:25:45
* @author: wongwuchiu
*/
Route::get('/ceshi/list', 'CeshiController@ceshi_list');
Route::post('/ceshi/import', 'CeshiController@ceshi_import_do');
Route::get('/ceshi/duoxuan', 'CeshiController@duoxuan');
Route::get('/ceshi/comps/{select_type}/{select_group}', 'CeshiController@ceshi_complist');
Route::post('/ceshi/getcomps', 'CeshiController@ceshi_getcomps');

/**
* 下载相关路由
* @date: 2018年11月22日 下午9:03:57
* @author: wongwuchiu
*/
Route::get('/download/apprfile/{event_id}', 'DownloadController@downloadApprFile');
Route::get('/download/apprdesc/{event_id}', 'DownloadController@downloadApprDesc');
Route::get('/download/apprtest/{event_id}', 'DownloadController@downloadApprTest');
Route::get('/download/devtest/{event_id}', 'DownloadController@downloadByDeveloper');
Route::get('/download/issue/{issue_id}', 'DownloadController@downloadByIssue');

/**
* 问题相关路径
* @date: 2018年11月26日 下午7:35:55
* @author: wongwuchiu
*/
Route::get('/issue/new/{event_id}', 'IssueController@issue_new');
Route::post('/issue/new/{event_id}', 'IssueController@issue_new_do');
Route::get('/issue/event/{event_id}', 'IssueController@issue_event');
Route::get('/issue/info/{event_id}', 'IssueController@issue_info');
Route::post('/issue/update/{issue_id}', 'IssueController@issue_update');
Route::get('/issue/list', 'IssueController@issue_list');

/**
* 授权相关
* @date: 2018年11月27日 下午2:37:18
* @author: wongwuchiu
*/
Route::get('/authority/userlist/{user_id}', 'AuthorityController@auth_userlist');
Route::get('/authority/userappend/{user_id}', 'AuthorityController@auth_userappend');
Route::post('/authority/userappend/{user_id}', 'AuthorityController@auth_userappend_do');
Route::get('/authority/complist/{comp_id}', 'AuthorityController@auth_complist');
Route::get('/authority/compappend/{comp_id}', 'AuthorityController@auth_compappend');
Route::post('/authority/compappend/{comp_id}', 'AuthorityController@auth_compappend_do');
Route::get('/authority/delete/{compauthority_id}', 'AuthorityController@auth_delete');

Route::get('/authority/addtester/{comp_id}/{pro_id}', 'AuthorityController@auth_addtester');
Route::post('/authority/addtester/{comp_id}/{pro_id}', 'AuthorityController@auth_addtester_do');
Route::get('/authority/adddever/{comp_id}/{pro_id}', 'AuthorityController@auth_adddever');
Route::post('/authority/adddever/{comp_id}/{pro_id}', 'AuthorityController@auth_adddever_do');
Route::get('/authority/addapprer/{comp_id}/{pro_id}', 'AuthorityController@auth_addapprer');
Route::post('/authority/addapprer/{comp_id}/{pro_id}', 'AuthorityController@auth_addapprer_do');

/**
* 模板相关
* @date: 2018年11月27日 下午4:52:56
* @author: wongwuchiu
*/
Route::get('/template/show/{comp_type}', 'TemplateController@template_show');
Route::get('/template/delete/{comp_type}', 'TemplateController@template_delete');
Route::get('/template/deleteappr/{apprgroup_id}', 'TemplateController@template_deleteappr');
Route::get('/template/new/{comp_type}', 'TemplateController@template_new');
Route::post('/template/new/{comp_type}', 'TemplateController@template_new_do');
Route::get('/template/node/{node_id}', 'TemplateController@template_node');
Route::get('/template/nodeappend/{node_id}', 'TemplateController@template_nodeappend');
Route::post('/template/nodeappend/{node_id}', 'TemplateController@template_nodeappend_do');

/**
 * 新的灵活的模板相关
 * @date: 2018年11月27日 下午4:52:56
 * @author: wongwuchiu
 */
Route::get('/moban/show/{comp_type}/{action_type}', 'MobanController@moban_show');
Route::get('/moban/delete/{comp_type}/{action_type}', 'MobanController@moban_delete');
Route::get('/moban/deleteappr/{apprgroup_id}', 'MobanController@moban_deleteappr');
Route::get('/moban/new/{comp_type}/{action_type}/{level}', 'MobanController@moban_new');
Route::post('/moban/new/{comp_type}/{action_type}/{level}', 'MobanController@moban_new_do2');
Route::get('/moban/node/{node_id}', 'MobanController@moban_node');
Route::get('/moban/nodeappend/{node_id}', 'MobanController@moban_nodeappend');
Route::post('/moban/nodeappend/{node_id}', 'MobanController@moban_nodeappend_do');
Route::post('/moban/getusers', 'MobanController@moban_getusers');


/**
* 组件相关
* @date: 2018年11月28日 上午10:26:33
* @author: wongwuchiu
*/
Route::get('/component/list/{select_type}/{select_group}', 'ComponentController@comp_list');
Route::get('/component/new', 'ComponentController@comp_new');
Route::post('/component/new', 'ComponentController@comp_new_do');
Route::get('/component/info/{comp_id}', 'ComponentController@comp_info');
Route::post('/component/info/{comp_id}', 'ComponentController@comp_info_do');
Route::get('/component/eventlist/{comp_id}', 'ComponentController@comp_eventlist');

/**
* 单位相关路径
* @date: 2018年11月28日 下午2:30:16
* @author: wongwuchiu
*/
Route::get('/group/list', 'GroupController@group_list');
Route::get('/group/new', 'GroupController@group_new');
Route::post('/group/new', 'GroupController@group_new_do');
Route::get('/group/edit/{group_id}', 'GroupController@group_edit');
Route::get('/group/delete/{group_id}', 'GroupController@group_delete');
Route::post('/group/edit/{group_id}', 'GroupController@group_update');

/**
* 类型设置
* @date: 2019年1月21日 下午4:29:39
* @author: wongwuchiu
*/
Route::get('/typesetting/showcomp', 'TypeSettingController@type_showcomp');
Route::get('/typesetting/showuser', 'TypeSettingController@type_showuser');
Route::get('/typesetting/delete/{type_id}', 'TypeSettingController@type_delete');
Route::get('/typesetting/new/{type}', 'TypeSettingController@type_new');
Route::post('/typesetting/new/{type}', 'TypeSettingController@type_new_do');
