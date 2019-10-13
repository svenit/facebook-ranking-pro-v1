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

Route::group(['prefix' => 'oauth','as' => 'oauth.'], function () {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('index');
    Route::get('logout','Auth\LoginController@logout')->name('logout');
    Route::get('confirm','Auth\LoginController@showConfirm')->name('show-confirm');
    Route::post('confirm','Auth\LoginController@confirm')->name('confirm');
    Route::get('facebook','Auth\LoginController@redirectToProvider')->name('login');
    Route::get('facebook/callback','Auth\LoginController@handleProviderCallback');
});

Route::group(['prefix' => 'character','as' => 'user.character.','namespace' => 'User\Character'], function () {
    Route::get('choose','CharacterController@choose')->name('choose');
    Route::get('/set/{id}','CharacterController@set')->name('set')->where('id','[1-9+]');
});

Route::group(['prefix' => '/','as' => 'user.','namespace' => 'User','middleware' => 'user'], function () {
    
    Route::get('/','HomeController@index')->name('index');


    Route::group(['prefix' => 'top','as' => 'top.','namespace' => 'Top'], function () {
        Route::get('/','TopController@power')->name('power');
        Route::get('gold','TopController@coin')->name('coin');
        Route::get('diamond','TopController@gold')->name('gold');
        Route::get('activities','TopController@activities')->name('activities');
    });

    Route::group(['prefix' => 'events','as' => 'events.','namespace' => 'Events'], function () {
        Route::group(['prefix' => 'wheel'], function () {
            Route::get('/','WheelController@index')->name('wheel');
            Route::get('data','WheelController@data')->name('data');
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