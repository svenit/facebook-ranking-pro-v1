<?php

use App\Events\PvPJoinedRoom;
use Illuminate\Support\Facades\Auth;


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
Route::get('x',function(){
    event(new PvPJoinedRoom('hello world'));
    return 'OK';
});
Route::get('test/{id}',function($id){
    Auth::loginUsingId($id,1);
    return redirect()->route('user.index');
});

Route::group(['prefix' => 'oauth','as' => 'oauth.','namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('index');
    Route::get('logout','LoginController@logout')->name('logout');
    Route::get('confirm','LoginController@showConfirm')->name('show-confirm');
    Route::post('confirm','LoginController@confirm')->name('confirm');
    Route::get('facebook','LoginController@redirectToProvider')->name('login');
    Route::get('facebook/callback','LoginController@handleProviderCallback');
});

Route::group(['prefix' => 'character','as' => 'user.character.','namespace' => 'User\Character'], function () {
    Route::get('choose','CharacterController@choose')->name('choose');
    Route::get('set/{id}','CharacterController@set')->name('set')->where('id','[1-9+]');
});

Route::group(['prefix' => '/','as' => 'user.','namespace' => 'User','middleware' => 'user'], function () {
    
    Route::get('/','HomeController@index')->name('index');


    Route::group(['prefix' => 'top','as' => 'top.','namespace' => 'Top'], function () {
        Route::get('/','TopController@power')->name('power');
        Route::get('gold','TopController@coin')->name('coin');
        Route::get('diamond','TopController@gold')->name('gold');
        Route::get('activities','TopController@activities')->name('activities');
    });
    Route::group(['prefix' => '/','middleware' => 'auth'], function () {
        Route::group(['prefix' => 'events','as' => 'events.','namespace' => 'Events'], function () {
            Route::group(['prefix' => 'wheel'], function () {
                Route::get('/','WheelController@index')->name('wheel');
                Route::get('data','WheelController@data')->name('data');
            });
        });
        Route::group(['prefix' => 'pvp','as' => 'pvp.','namespace' => 'PVP'], function () {
            Route::get('/','PvPController@index')->name('index');
            Route::get('create-room','PvPController@createRoom')->name('create');
            Route::get('join/{id}','PvPController@joinedRoom')->name('joined-room');
            Route::get('room/{id}','PvPController@room')->name('room');
        });
    });
});
Route::group(['prefix' => 'admin','as' => 'admin.','namespace' => 'Admin','middleware' => 'admin'], function () {
    Route::get('/',function(){
        return 1;
    });
    Route::get('update-points','UpdatePointsController@index')->name('update-points');
    Route::post('update-points','UpdatePointsController@store');
});