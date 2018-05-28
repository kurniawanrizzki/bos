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

Route::get('/',['as'=>'auth.index','uses'=>'AuthController@index']);
Route::post('/',['as'=>'auth.signin','uses'=>'AuthController@signin']);

Route::group ([
    'prefix' => 'dashboard', 'middleware' => 'auth.bos'
], function (){

  Route::get('/',['as'=>'dashboard.index','uses'=>'DashboardController@index']);
  Route::get('/signout',['as'=>'auth.signout','uses'=>'AuthController@signout']);

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
      Route::get('/{id}/view',['as'=>'item.view','uses'=>'ItemController@view']);
      Route::get('/{id}/delete',['as'=>'item.delete','uses'=>'ItemController@delete']);
      Route::get('/form/{id?}',['as'=>'item.form','uses'=>'ItemController@form']);
      Route::post('/store',['as'=>'item.store','uses'=>'ItemController@store']);
      Route::post('/update',['as'=>'item.update','uses'=>'ItemController@update']);

  });

});
