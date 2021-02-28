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

    Route::get('/users', 'UsersController@index')->name('users');
    Route::post('/users/getUsersDataTable', 'UsersController@getUsersDataTable');
    Route::post('/users/saveUser', 'UsersController@saveUser');
    Route::post('/users/deleteUser', 'UsersController@deleteUser');
    
    Route::get('/boost', 'BoostController@index')->name('boost');
    Route::post('/boost/getBoostsDataTable', 'BoostController@getBoostsDataTable');
    Route::post('/boost/saveBoost', 'BoostController@saveBoost');
    Route::post('/boost/deleteBoost', 'BoostController@deleteBoost');

    Route::get('/packs', 'PacksController@index')->name('packs');
    Route::post('/packs/getPacksDataTable', 'PacksController@getPacksDataTable');
    Route::post('/packs/savePack', 'PacksController@savePack');
    Route::post('/packs/deletePack', 'PacksController@deletePack');

    Route::get('/ads', 'AdsController@index')->name('ads');
    Route::post('/ads/getAdsDataTable', 'AdsController@getAdsDataTable');
    Route::post('/ads/saveAd', 'AdsController@saveAd');
    Route::post('/ads/deleteAd', 'AdsController@deleteAd');
});

Route::group(['middleware' => ['login']], function () {
    Route::post('/developer', 'Util\\DbUtil@developer');
    Route::post('/notify/read', 'Util\\NotifyUtil@read');
});