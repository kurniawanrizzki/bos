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

Route::post('transactions',['as'=>'api.transactions','uses'=>'TransactionController@getAllList']);
Route::post('udpate',['as'=>'api.transaction.update','uses'=>'TransactionController@update']);
Route::post('bulk_transaction_delete',['as'=>'api.bulk_transaction_delete','uses'=>'TransactionController@delete']);
Route::post('items',['as'=>'api.items','uses'=>'ItemController@getItemList']);
Route::post('item_parent_checking',['as'=>'api.item_parent_checking','uses'=>'ItemController@didItemHaveChild']);
