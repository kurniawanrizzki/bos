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

Route::get('/auth',function(){
  return view('pages.auth.signin');
});
Route::get('/',['as'=>'dashboard.index','uses'=>'DashboardController@index']);

Route::group([
    'prefix' => 'transaction'], function () {

    Route::get('/',['as'=>'transaction.index', 'uses'=>'TransactionController@index']);
    Route::get('/{id}/view', ['as'=>'transaction.view','uses'=>'TransactionController@view']);
    Route::get('/{id}/delete',['as'=>'transaction.delete','uses'=>'TransactionController@delete']);
    Route::get('/{id}/print',['as'=>'transaction.print','uses'=>'TransactionController@print']);
    Route::post('/udpate',['as'=>'transaction.update','uses'=>'TransactionController@update']);

});

Route::group([
    'prefix' => 'item'], function () {

    Route::get('/',['as'=>'item.index','uses'=>'ItemController@index']);

});
