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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('user-profile', 'UserController@profile');
Route::post('user-update', 'UserController@update');
Route::post('user-update-picture', 'UserController@updatepicture');
Route::get('user-remove-picture/{id}', 'UserController@removepicture');

Route::get('airport-dom', 'AirportController@domestic');

Route::get('airport-dom/generaldata/{id}', 'AirportController@generaldata');
Route::get('print-airportdata/{id}', 'AirportController@printairportdata');
Route::post('update-generaldata', 'AirportController@updategeneraldata');
Route::post('update-totalat', 'AirportController@updatetotalat');
Route::post('add-rwd', 'AirportController@addrwd');
Route::post('update-rwd', 'AirportController@updaterwd');
Route::delete('delete-rwd', 'AirportController@deleterwd');

Route::get('airport-dom/detaildata/{id}', 'AirportController@detaildata');
Route::get('find-city', 'AirportController@findcity');
Route::post('add-airport', 'AirportController@addairport');
Route::delete('delete-airport', 'AirportController@deleteairport');
Route::post('upload-aerodrome', 'FileController@uploadaerodrome');
Route::post('update-detail-airport', 'AirportController@updatedetailairport');
Route::post('update-detail-aerodrome', 'AirportController@updatedetailaerodrome');
Route::post('add-detail-rwd-detail', 'AirportController@adddetailrwddetail');
Route::post('update-detail-rwd', 'AirportController@updatedetailrwd');
Route::post('update-detail-rwd-detail', 'AirportController@updatedetailrwddetail');
Route::delete('delete-detail-rwd', 'AirportController@deletedetailrwd');
Route::delete('delete-detail-rwd-detail', 'AirportController@deletedetailrwddetail');
Route::post('add-detail-taxiway', 'AirportController@adddetailtaxiway');
Route::post('update-detail-taxiway', 'AirportController@updatedetailtaxiway');
Route::delete('delete-detail-taxiway', 'AirportController@deletedetailtaxiway');
Route::post('add-detail-apron', 'AirportController@adddetailapron');
Route::post('update-detail-apron', 'AirportController@updatedetailapron');
Route::delete('delete-detail-apron', 'AirportController@deletedetailapron');
Route::post('add-detail-nav', 'AirportController@adddetailnav');
Route::post('update-detail-nav', 'AirportController@updatedetailnav');
Route::delete('delete-detail-nav', 'AirportController@deletedetailnav');
Route::post('add-detail-obs', 'AirportController@adddetailobs');
Route::post('update-detail-obs', 'AirportController@updatedetailobs');
Route::delete('delete-detail-obs', 'AirportController@deletedetailobs');
Route::post('add-detail-obs-detail', 'AirportController@adddetailobsdetail');
Route::post('update-detail-obs-detail', 'AirportController@updatedetailobsdetail');
Route::delete('delete-detail-obs-detail', 'AirportController@deletedetailobsdetail');
Route::post('update-detail-apm', 'AirportController@updatedetailapm');
Route::post('update-detail-rwm', 'AirportController@updatedetailrwm');
Route::post('update-detail-txm', 'AirportController@updatedetailtxm');
Route::post('update-detail-lightning', 'AirportController@updatedetaillightning');
Route::post('update-detail-fffac', 'AirportController@updatedetailfffac');
Route::post('update-detail-comm', 'AirportController@updatedetailcomm');
Route::post('update-detail-meteoeq', 'AirportController@updatedetailmeteoeq');
Route::post('update-detail-iaproc', 'AirportController@updatedetailiaproc');

Route::get('airport-dom/document/{id}', 'AirportController@document');

Route::get('airport-dom/adl/{id}', 'ADLController@index');
Route::post('add-adl-rws', 'ADLController@addadlrws');
Route::post('update-adl-rws', 'ADLController@updateadlrws');
Route::delete('delete-adl-rws', 'ADLController@deleteadlrws');
Route::post('update-adl-rws-detail', 'ADLController@updateadlrwsdetail');
Route::get('download-adl/{id}', 'ADLController@download');

//Route::get('airport-int', 'AirportController@international');

Route::get('manage-users', 'UserController@index');
Route::post('manage-user-add', 'UserController@add');
Route::post('manage-user-update', 'UserController@update');
Route::delete('manage-user-delete', 'UserController@delete');

Route::get('manage-actypes', 'ACTypeController@index');
Route::post('manage-actype-add', 'ACTypeController@add');
Route::post('manage-actype-update', 'ACTypeController@update');
Route::delete('manage-actype-delete', 'ACTypeController@delete');

Route::get('manage-region', 'RegionController@index');
Route::post('manage-region-add', 'RegionController@add');
Route::post('manage-region-update', 'RegionController@update');
Route::delete('manage-region-delete', 'RegionController@delete');

Route::get('manage-doc', 'FileController@index');
Route::post('upload-chart/{id}', 'FileController@uploadchart');
Route::post('upload-arpi/{id}', 'FileController@uploadarpi');
Route::post('upload-armi/{id}', 'FileController@uploadarmi');
Route::post('upload-beritaacara/{id}', 'FileController@uploadberitaacara');
