<?php

Route::group(['namespace' => 'TNM\AuthService\Http\Controllers', 'prefix' => 'api/auth'], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('sync', 'PermissionsController@sync')->name('sync');
});

