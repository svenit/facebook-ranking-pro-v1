<?php

Route::group(['as' => 'admin.','namespace' => 'Admin'], function () {
    Route::group(['prefix' => 'dashboard','as' => 'dashboard.'], function () {
        Route::get('/','DashboardController@index')->name('index');
        Route::post('execute-query','DashboardController@executeQuery')->name('exceute-query');
    });
    Route::group(['prefix' => 'analytics','as' => 'analytics.'], function () {
        Route::get('total','AnalyticsController@index')->name('total');
        Route::get('hour','AnalyticsController@baseOnHour')->name('hour');
        Route::get('day','AnalyticsController@baseOnDay')->name('day');
        Route::get('view-most','AnalyticsController@viewMost')->name('view-most');
        Route::get('setting','AnalyticsController@setting')->name('setting.index');
        Route::post('setting','AnalyticsController@setAnalyticsDays')->name('setting.update');
    });
    Route::group(['prefix' => 'users','as' => 'users.'], function () {
        Route::get('list','UserController@list')->name('list');
        Route::get('detail/{id}','UserController@detail')->name('detail');
        Route::post('edit/{id}','UserController@edit')->name('edit');
        Route::post('add-gear/{id}','UserController@addGear')->name('add-gear');
        Route::get('remove-gear/{id}/{gear}/{user}','UserController@removeGear')->name('remove-gear');
        Route::post('add-skill/{id}','UserController@addSkill')->name('add-skill');
        Route::get('remove-skill/{skill}/{user}','UserController@removeSkill')->name('remove-skill');
        Route::post('add-pet/{id}','UserController@addPet')->name('add-pet');
        Route::get('remove-pet/{id}/{pet}/{user}','UserController@removePet')->name('remove-pet');
        Route::post('add-item/{id}','UserController@addItem')->name('add-item');
        Route::get('remove-item/{id}/{pet}/{user}','UserController@removeItem')->name('remove-item');
        Route::post('send-message/{id}','UserController@sendMessage')->name('send-message');
        Route::get('delete/{id}','UserController@deleteAccount')->name('delete');
        Route::get('lock/{id}','UserController@lock')->name('lock');
        Route::get('unlock/{id}','UserController@unlock')->name('unlock');
    });
    Route::group(['prefix' => 'cate-gears','as' => 'cate-gears.'], function () {
        Route::get('list','CateGearController@list')->name('list');
        Route::post('store','CateGearController@store')->name('store');
        Route::get('delete/{id}','CateGearController@delete')->name('delete');
        Route::get('detail/{id}','CateGearController@detail')->name('detail');
    });
    Route::group(['prefix' => 'gears','as' => 'gears.'], function () {
        Route::get('add','GearController@add')->name('add');
        Route::get('list','GearController@list')->name('list');
        Route::post('store','GearController@store')->name('store');
        Route::get('edit/{id}','GearController@edit')->name('edit');
        Route::post('update/{id}','GearController@update')->name('update');
        Route::get('replicate/{id}','GearController@replicate')->name('replicate');
        Route::get('delete/{id}','GearController@delete')->name('delete');
        Route::post('delete-multi','GearController@deleteMulti')->name('delete-multi');
    });
    Route::group(['prefix' => 'pets','as' => 'pets.'], function () {
        Route::view('add','admin.pets.add')->name('add');
        Route::get('list','PetController@list')->name('list');
        Route::post('store','PetController@store')->name('store');
        Route::get('edit/{id}','PetController@edit')->name('edit');
        Route::post('update/{id}','PetController@update')->name('update');
        Route::get('replicate/{id}','PetController@replicate')->name('replicate');
        Route::get('delete/{id}','PetController@delete')->name('delete');
        Route::post('delete-multi','PetController@deleteMulti')->name('delete-multi');
    });
    Route::group(['prefix' => 'items','as' => 'items.'], function () {
        Route::view('add','admin.items.add')->name('add');
        Route::get('list','ItemController@list')->name('list');
        Route::post('store','ItemController@store')->name('store');
        Route::get('edit/{id}','ItemController@edit')->name('edit');
        Route::post('update/{id}','ItemController@update')->name('update');
        Route::get('replicate/{id}','ItemController@replicate')->name('replicate');
        Route::get('delete/{id}','ItemController@delete')->name('delete');
        Route::post('delete-multi','ItemController@deleteMulti')->name('delete-multi');
    });
    Route::group(['prefix' => 'skills','as' => 'skills.'], function () {
        Route::get('add','SkillController@add')->name('add');
        Route::get('list','SkillController@list')->name('list');
        Route::post('store','SkillController@store')->name('store');
        Route::get('edit/{id}','SkillController@edit')->name('edit');
        Route::post('update/{id}','SkillController@update')->name('update');
        Route::get('replicate/{id}','SkillController@replicate')->name('replicate');
        Route::get('delete/{id}','SkillController@delete')->name('delete');
        Route::post('delete-multi','SkillController@deleteMulti')->name('delete-multi');
    });
    Route::group(['prefix' => 'levels','as' => 'levels.'], function () {
        Route::view('add','admin.levels.add')->name('add');
        Route::get('list','LevelController@list')->name('list');
        Route::post('store','LevelController@store')->name('store');
        Route::get('edit/{id}','LevelController@edit')->name('edit');
        Route::post('update/{id}','LevelController@update')->name('update');
        Route::get('replicate/{id}','LevelController@replicate')->name('replicate');
        Route::get('delete/{id}','LevelController@delete')->name('delete');
        Route::post('delete-multi','LevelController@deleteMulti')->name('delete-multi');
    });
    Route::get('update-points','UpdatePointsController@index')->name('update-points');
    Route::post('update-points','UpdatePointsController@store');
});