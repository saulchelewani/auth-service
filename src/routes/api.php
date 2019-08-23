<?php

Route::get('auth/callback', function () {
    return 'callback';
});

Route::group(['namespace' => 'TNM\AuthService\Http\Controllers', 'prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('sync', 'PermissionsController@sync')->name('sync');
});

