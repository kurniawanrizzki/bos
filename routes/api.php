<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/{userId}/transactions',['as'=>'api.transactions','uses'=>'TransactionController@getAllList']);
Route::get('/{userId}/items',['as'=>'api.items','uses'=>'ItemController@getItemList']);
