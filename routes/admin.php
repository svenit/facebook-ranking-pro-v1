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
    });
    Route::get('update-points','UpdatePointsController@index')->name('update-points');
    Route::post('update-points','UpdatePointsController@store');
});