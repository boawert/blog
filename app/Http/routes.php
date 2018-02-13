<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();
Route::get('/home', 'HomeController@index');


Route::get('/uploadfile','uploadController@index');
Route::post('/store','uploadController@store');

Route::get('/additionalreports','AdditionalReportsController@index');
Route::post('/storeadditionalreports','AdditionalReportsController@store');


Route::get('/uploadproduct','UploadProductController@index');
Route::post('/product_store','UploadProductController@store');

Route::get('/uploadcustomer','UploadCustomerController@index');
Route::post('/customer_store','UploadCustomerController@store');

Route::get('/uploadprice','UploadPriceController@index');
Route::post('/price_store','UploadPriceController@store');

Route::get('/defineprice','DefineCarryPriceController@index');

Route::get('/defineprice/edit/{id}/{monthyear}', 'DefineCarryPriceController@edit');
Route::post('/defineprice/update/{id}/{monthyear}','DefineCarryPriceController@update');

Route::get('/definedistance/{id}', 'uploadController@define_distance');
Route::post('/definedistance/update/{id}', 'uploadController@define_distance_update');


Route::get('/report/license','ReportController@index_license');
Route::post('/report/license/result','ReportController@result_license');

Route::get('/report/cotrucks','ReportController@index_cotrucks');
Route::post('/report/cotrucks/result','ReportController@result_cotrucks');
Route::get('/report/cotrucks/defineprice/edit/{id}', 'DefineCarryPriceController@edit_cotruck_price');
Route::post('/report/cotrucks/defineprice/update/{id}','DefineCarryPriceController@update_cotruck_price');


Route::post('/ajax_center',[
		'uses'	=> 'ReportController@ajaxCenter',
		'as'	=>	'report.ajax_center.post'
	]);