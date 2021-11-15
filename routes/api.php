<?php

use Illuminate\Http\Request;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');

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
Route::get('/kalkulator','RestapiController@kalkulator');
Route::post('/orderweb','RestapiController@orderweb');
Route::post('/ordercustom','RestapiController@ordercustom');
Route::get('/resi/{id}','RestapiController@resi');
Route::get('/pricelist','RestapiController@couple_pricelist');
Route::get('/pl/{what}','RestapiController@pricelist_single');
Route::post('/joingiveaway','RestapiController@joingiveaway');

Route::get('/chat','RestapiController@chat');

Route::get('/ai/{logam_pria?}/{logam_wanita?}','RestapiController@ai_pricelist');
Route::get('/cl/{id}/{message?}','RestapiController@chat_langsung');
Route::post('/search','RestapiController@ai_pricelist_search');


Route::any('/calc','RestapiController@calc');
Route::get('/pl_depan/{logam}','RestapiController@pricelist_depan');
Route::post('/update/{apa?}','API\RestfullController@update');
Route::get('/daftar_harga','API\RestfullController@daftar_harga');
Route::post('/order','API\RestfullController@order');
Route::get('/detail/{id?}','API\RestfullController@detail');

Route::get('/paket','API\RestfullController@paket');

Route::get('/log','API\RestfullController@logam');