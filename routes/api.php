<?php

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
Route::get('v1/user/{param}','Api\IndexController@userInfor')->middleware('cors');
Route::group(['prefix' => 'v1','namespace' => 'Api','middleware' => ['cors','auth']], function () {
    Route::post('set-location','User\LocationController@setLocation');
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
    Route::group(['prefix' => 'shop','namespace' => 'Shop'], function () {
        Route::post('buy-equip','ShopController@buyEquip');
        Route::post('buy-skill','ShopController@buySkill');
        Route::post('buy-pet','ShopController@buyPet');
        Route::post('buy-item','ShopController@buyItem');
    });
    Route::group(['prefix' => 'profile','namespace' => 'Profile'], function () {
        Route::group(['prefix' => 'inventory'], function () {
            Route::get('/','InventoryController');
            Route::post('equipment','InventoryController@equipment');
            Route::post('delete','InventoryController@delete');
            Route::post('remove','InventoryController@removeEquipment');
        });
        Route::group(['prefix' => 'pet'], function () {
            Route::get('/','PetController');
            Route::post('riding','PetController@riding');
            Route::post('pet-down','PetController@petDown');
            Route::post('drop-pet','PetController@dropPet');
        });
        Route::group(['prefix' => 'skill'], function () {
            Route::get('/','SkillController');
            Route::post('use','SkillController@useSkill');
            Route::post('remove','SkillController@removeSkill');
            Route::post('delete','SkillController@deleteSkill');
        });      
        Route::group(['prefix' => 'item'], function () {
            Route::get('/','ItemController');
            Route::post('use','ItemController@use');
            Route::post('delete','ItemController@delete');
            Route::post('delete-all','ItemController@deleteAll');
        });
        Route::group(['prefix' => 'stat'], function () {
            Route::post('increment','StatController@increment');
        });
    });
});