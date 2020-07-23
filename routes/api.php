<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
Route::post('verify-token','Api\IndexController@verifyToken');
Route::get('user/all','Api\User\IndexController@all');
Route::get('user/{param}','Api\IndexController@userInfor')->middleware('cors');
Route::group(['namespace' => 'Api','middleware' => ['cors', 'auth']], function () {
    Route::post('set-location','User\IndexController@setLocation');
    Route::group(['prefix' => 'pvp','namespace' => 'PvP'], function () {
        Route::get('list-room','ListRoomController');
        Route::post('kick-enemy','BaseController@kickEnemy');
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
        Route::post('buy-gem','ShopController@buyGem');
    });
    Route::group(['prefix' => 'profile','namespace' => 'Profile'], function () {
        Route::group(['prefix' => 'inventory'], function () {
            Route::get('/','InventoryController');
            Route::get('available','InventoryController@available');
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
        });
        Route::group(['prefix' => 'stat'], function () {
            Route::post('increment','StatController@increment');
        });
        Route::group(['prefix' => 'gem'], function () {
            Route::get('/','GemController');
            Route::post('remove','GemController@remove');
        });
    });
    Route::group(['prefix' => 'oven','namespace' => 'Oven'], function () {
        Route::post('insert-gem-to-gear','InsertGemToGearController@insert');
    });
});