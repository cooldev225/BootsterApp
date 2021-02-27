<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
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
Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/login', 'AuthController')->name('login');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');
Route::get('/forgot', 'AuthController@forgot')->name('forgot');
Route::post('/forgot', 'AuthController@forgot');
Route::get('/logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => ['login']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/home/getDocumentChartData', 'HomeController@getDocumentChartData');
    Route::post('/home/attachRemoveFile', 'HomeController@attachRemoveFile');

    Route::get('/document', 'DocumentController@index')->name('document');
    Route::post('/document/getFileBody', 'DocumentController@getFileBody');
    Route::post('/document/getDocumentDataTable', 'DocumentController@getDocumentDataTable');//API\\
    Route::post('/document/saveDocument', 'DocumentController@saveDocument');
    Route::post('/document/deleteDocument', 'DocumentController@deleteDocument');
    Route::post('/document/getDocumentByGroup', 'DocumentController@getDocumentByGroup');
    Route::post('/document/finishDocument', 'DocumentController@finishDocument');
    Route::post('/document/getDocumentById', 'DocumentController@getDocumentById');
    Route::post('/document/saveTemplate', 'DocumentController@saveTemplate');
    Route::get('/document/exportDocumentDataTable', 'DocumentController@exportDocumentDataTable');//API\\

    Route::get('/project', 'ProjectController@index')->name('project');
    Route::post('/project/saveBusiness', 'ProjectController@saveBusiness');
    Route::post('/project/deleteBusiness', 'ProjectController@deleteBusiness');
    Route::post('/project/saveProject', 'ProjectController@saveProject');
    Route::post('/project/deleteProject', 'ProjectController@deleteProject');
    Route::post('/project/attachFile', 'ProjectController@attachFile');
    Route::post('/project/getAdCitiesList', 'ProjectController@getAdCitiesList');
    Route::post('/project/getBusinessById', 'ProjectController@getBusinessById');
    Route::post('/project/getProjectsByBusiness', 'ProjectController@getProjectsByBusiness');

    Route::get('/group', 'GroupController@index')->name('group');
    Route::post('/group/getGroupDataTable', 'GroupController@getGroupDataTable');
    Route::post('/group/saveGroup', 'GroupController@saveGroup');
    Route::post('/group/deleteGroup', 'GroupController@deleteGroup');
    Route::post('/group/getGroupList', 'GroupController@getGroupList');

    Route::get('/task', 'TaskController@index')->name('task');
    Route::post('/task/getTaskDescDataTable', 'TaskController@getTaskDescDataTable');
    Route::post('/task/saveTaskDesc', 'TaskController@saveTaskDesc');
    Route::post('/task/deleteTaskDesc', 'TaskController@deleteTaskDesc');
    Route::post('/task/getTaskDataTable', 'TaskController@getTaskDataTable');
    Route::post('/task/saveTask', 'TaskController@saveTask');
    Route::post('/task/deleteTask', 'TaskController@deleteTask');
    Route::post('/task/getTaskDescsList', 'TaskController@getTaskDescsList');
    Route::get('/taskmap', 'TaskController@taskmap')->name('taskmap');
    Route::post('/task/finishTask', 'TaskController@finishTask');

    Route::get('/download/{path1}/{path2}/{filename}', 'API\\CommonController@download');
});
Route::post('/uploadFile', 'Util\\FileUtil@uploadFile');
Route::get('/downloadFile', 'Util\\FileUtil@downloadFile');

Route::post('/notify', 'Util\\NotifyUtil@notify');
Route::get('/notify', 'Util\\NotifyUtil@notify');
Route::group(['middleware' => ['login']], function () {
    Route::post('/developer', 'Util\\DbUtil@developer');
    Route::post('/notify/read', 'Util\\NotifyUtil@read');
});
