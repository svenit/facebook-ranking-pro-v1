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
Route::group(['prefix' => 'v1','namespace' => 'Api\v1','middleware' => 'cors'], function () {
    Route::post('set-location','User\LocationController@setLocation');
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
    Route::group(['prefix' => 'shop','namespace' => 'Shop'], function () {
        Route::post('buy-equip','ShopController@buyEquip');
        Route::post('buy-skill','ShopController@buySkill');
        Route::post('buy-pet','ShopController@buyPet');
        Route::post('buy-item','ShopController@buyItem');
    });
    Route::group(['prefix' => 'profile','namespace' => 'Profile'], function () {
        Route::group(['prefix' => 'inventory','namespace' => 'Inventory'], function () {
            Route::get('/','InventoryController');
            Route::put('equipment','InventoryController@equipment');
            Route::post('delete','InventoryController@delete');
            Route::put('remove','InventoryController@removeEquipment');
        });
        Route::group(['prefix' => 'pet','namespace' => 'Pet'], function () {
            Route::get('/','PetController');
            Route::put('riding','PetController@riding');
            Route::put('pet-down','PetController@petDown');
            Route::post('drop-pet','PetController@dropPet');
        });
        Route::group(['prefix' => 'skill','namespace' => 'Skill'], function () {
            Route::get('/','SkillController');
            Route::put('use','SkillController@useSkill');
            Route::put('remove','SkillController@removeSkill');
            Route::post('delete','SkillController@deleteSkill');
        });      
        Route::group(['prefix' => 'item','namespace' => 'Item'], function () {
            Route::get('/','ItemController');
            Route::put('use','ItemController@use');
            Route::post('delete','ItemController@delete');
        });
    });
});