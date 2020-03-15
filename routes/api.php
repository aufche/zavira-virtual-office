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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/logam','RestapiController@logam');
Route::get('/hargapokok','RestapiController@hargapokok');
Route::post('/orderweb','RestapiController@orderweb');
Route::post('/ordercustom','RestapiController@ordercustom');
Route::get('/resi/{id}','RestapiController@resi');
Route::get('/pricelist','RestapiController@couple_pricelist');
Route::post('/joingiveaway','RestapiController@joingiveaway');

Route::get('/chat','RestapiController@chat');
