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
Route::group(['prefix' => 'v1','namespace' => 'Api\v1','middleware' => 'cors'], function () {
    Route::get('user/{param}','IndexController@userInfor');
    Route::group(['prefix' => 'pvp'], function () {
        Route::post('find-enemy','PvPController@findEnemy');
        Route::post('turn-time-out','PvPController@turnTimeOut');
        Route::post('listen-action','PvPController@listenAction');
    });
});