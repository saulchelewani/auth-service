<?php

Route::get('auth/callback', function () {
    return 'callback';
});

Route::group(['namespace' => 'TNM\AuthService\Http\Controllers'], function () {
    Route::post('authenticate', 'AuthController@authenticate')->name('authenticate');
});

