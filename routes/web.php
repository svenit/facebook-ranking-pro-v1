<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;


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

Route::get('test/{id}',function($id){
    Auth::loginUsingId($id);
    return redirect()->back();
});
Route::get('chat/stranger/exit','User\Chat\StrangerController@exit')->name('user.chat.stranger.exit');
Route::group(['middleware' => ['maintaince','redirect.action']], function () {
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
            Route::get('level','TopController@level')->name('level');
            Route::get('power','TopController@power')->name('power');
            Route::get('pvp','TopController@pvp')->name('pvp');
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
                Route::get('lucky-box','LuckyBoxController@index')->name('lucky-box');
            });
            Route::group(['prefix' => 'pvp','as' => 'pvp.','namespace' => 'PVP'], function () {
                Route::get('list-room','PvPController@index')->name('index');
                Route::post('create-room','PvPController@createRoom')->name('create');
                Route::get('join/{id}','PvPController@joinedRoom')->name('joined-room');
                Route::get('room/{id}','PvPController@room')->name('room');
            });
            Route::group(['prefix' => 'chat','as' => 'chat.','namespace' => 'Chat'], function () {
                Route::get('global','GlobalChatController@index')->name('global');
                Route::group(['prefix' => 'stranger','as' => 'stranger.'], function () {
                    Route::get('/','StrangerController')->name('join');
                    Route::get('{room}','StrangerController@chatRoom')->name('room');
                });
            });
            Route::group(['prefix' => 'shop','as' => 'shop.','namespace' => 'Shop'], function () {
                Route::get('pets','ShopController@pet')->name('pet');
                Route::get('skills','ShopController@skill')->name('skill');
                Route::get('items','ShopController@item')->name('item');
                Route::get('{cate}',"ShopController@index")->name('index');
            });
            Route::group(['prefix' => 'profile','as' => 'profile.','namespace' => 'Profile'], function () {
                Route::get('inventories','Inventory\InventoryController@index')->name('inventory.index');
                Route::get('pets','Pet\PetController@index')->name('pet.index');
                Route::get('skills','Skill\SkillController@index')->name('skill.index');
                Route::get('items','Item\ItemController@index')->name('item.index');
            });
            Route::group(['prefix' => 'explore','as' => 'explore.'], function () {
                Route::group(['prefix' => 'recovery-room','as' => 'recovery-room.','namespace' => 'RecoveryRoom'], function () {
                    Route::get('/','RecoveryRoomController@index')->name('index');
                    Route::get('receive/{room_id}','RecoveryRoomController@receive')->name('receive');
                    Route::get('join/{id}','RecoveryRoomController@join')->name('join');
                    Route::get('cancle/{id}','RecoveryRoomController@cancle')->name('cancle');
                });                
            });
        });
    });
});