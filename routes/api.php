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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['prefix' => 'v1','namespace' => 'Api\v1','middleware' => 'cors'], function () {
    Route::get('user/{param}','IndexController@userInfor');
    Route::group(['prefix' => 'pvp','namespace' => 'PvP'], function () {
        Route::get('list-room','ListRoomController');
        Route::get('find-enemy','FindEnemyController');
        Route::post('toggle-ready','BaseController@toggleReady');
        Route::post('get-ready','FindMatchController');
        Route::post('find-match','FindMatchController');
        Route::post('turn-time-out','TurnOutController');
        Route::post('listen-action','ListenActionController');
        Route::post('hit','HitController');
        Route::post('exit-match','BaseController@exitMatch');
    });
    Route::group(['prefix' => 'wheel','namespace' => 'Wheel'], function () {
        Route::get('check','CheckController');
        Route::post('spin','SpinController');
    });
});