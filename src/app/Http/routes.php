<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//index
Route::get('/', 'HomeController@index');

//user
Route::get('/user/list', 'UserController@user_list');
Route::get('/user/info/{user_id}', 'UserController@user_info');
Route::get('/user/new', 'UserController@user_new');
Route::post('/user/new', 'UserController@user_new_do');
Route::get('/user/delete/{user_id}', 'UserController@user_delete');

//group
Route::get('/group/list', 'GroupController@group_list');
Route::get('/group/new', 'GroupController@group_new');
Route::get('/group/info/{group_id}', 'GroupController@group_info');


//repository
Route::get('/app/list', 'ApplicationController@app_list');
Route::get('/app/new', 'ApplicationController@app_new');
Route::post('/app/new', 'ApplicationController@app_new_do');
Route::get('/app/delete/{app_id}', 'ApplicationController@app_delete');

//product
Route::get('/app/import', 'ApplicationController@app_import');
Route::post('/app/import', 'ApplicationController@app_import_do');

Route::get('/app/import/list', 'ApplicationController@app_import_list');
Route::get('/app/export/list' , 'ApplicationController@app_export_list');

Route::get('/app/request/{request_type}' , 'ApplicationController@app_request');


//Route::get('/app/import/request' , 'ApplicationController@app_request');


//audit
Route::get('/app/request/list', 'ApplicationController@app_request_list');
Route::get('/app/request/deal/{request_id}' , 'ApplicationController@app_request_deal');


//issue
Route::get('/issue/list', 'IssueController@issue_list');








