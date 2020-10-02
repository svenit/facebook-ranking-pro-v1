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
Route::group(['namespace' => 'Api','middleware' => ['cors', 'auth']], function () {
    Route::get('app','IndexController@initialApplication');
    Route::get('user/{param}','IndexController@userInfor');
    Route::group(['prefix' => 'user-utils', 'namespace' => 'User'], function () {
        Route::post('set-location','IndexController@setLocation');
        Route::get('all-fames', 'IndexController@getAllFames');
    });
    Route::group(['prefix' => 'pvp','namespace' => 'PvP'], function () {
        Route::get('list-room','ListRoomController');
        Route::post('kick-enemy','BaseController@kickEnemy');
        Route::post('exit-match','BaseController@exitMatch');
    });
    Route::group(['prefix' => 'wheel','namespace' => 'Wheel'], function () {
        Route::get('/','IndexController');
        Route::get('check','CheckController');
        Route::post('spin','SpinController');
    });
    Route::group(['prefix' => 'shop','namespace' => 'Shop'], function () {
        Route::get('item', 'IndexController@item');
        Route::get('gems', 'IndexController@gems');
        Route::get('pet', 'IndexController@pet');
        Route::get('skill', 'IndexController@skill');
        Route::post('buy-equip','ShopController@buyEquip');
        Route::post('buy-skill','ShopController@buySkill');
        Route::post('buy-pet','ShopController@buyPet');
        Route::post('buy-item','ShopController@buyItem');
        Route::post('buy-gem','ShopController@buyGem');
        Route::get('{id}', 'IndexController@equipment');
    });
    Route::group(['prefix' => 'profile','namespace' => 'Profile'], function () {
        Route::group(['prefix' => 'equipment'], function () {
            Route::get('/','EquipmentController');
            Route::get('available','EquipmentController@available');
            Route::post('use','EquipmentController@use');
            Route::post('delete','EquipmentController@delete');
            Route::post('remove','EquipmentController@removeEquipment');
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
    Route::group(['prefix' => 'oven','namespace' => 'Oven','middleware' => 'prevent.api'], function () {
        Route::post('insert-gem-to-gear','InsertGemToGearController@insert');
    });
});