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
Route::post('/signin',['as'=>'auth.signin','uses'=>'AuthController@signin']);

Route::get('/error/{errorCode}', function($errorCode) {

  $explanation = \Lang::get('string.error_default');

  if ($errorCode == '505') {
    $explanation = \Lang::get('string.internal_error');
  } else if ($errorCode == '405') {
    $explanation = \Lang::get('string.not_allowed_method');
  }

  return view('pages.errors.error',["errorCode"=>$errorCode, "explanation"=>$explanation]);
})->name('error');

Route::group ([
    'prefix' => 'dashboard', 'middleware' => 'auth.bos'
], function (){

  Route::get('/',['as'=>'dashboard.index','uses'=>'DashboardController@index']);
  Route::get('/signout',['as'=>'auth.signout','uses'=>'AuthController@signout']);

  Route::group([
      'prefix' => 'profile'], function (){
      Route::get('/',['as'=>'profile.index','uses'=>'DashboardController@profile']);
      Route::get('/edit',['as'=>'profile.edit','uses'=>'DashboardController@edit']);
      Route::post('/update',['as'=>'profile.update','uses'=>'DashboardController@update']);
  });

  Route::group([
      'prefix' => 'transaction'], function () {

      Route::get('/',['as'=>'transaction.index', 'uses'=>'TransactionController@index']);
      Route::get('/{id}/view', ['as'=>'transaction.view','uses'=>'TransactionController@view']);
      Route::get('/print',['as'=>'transaction.print','uses'=>'TransactionController@print']);

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
