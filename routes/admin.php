<?php

Route::group(['prefix' => 'admin'], function() {
    
    Route::any('login', 'Admin\Auth\AuthController@login')->name('admin.login');
    Route::any('logout', 'Admin\Auth\AuthController@logout')->name('admin.logout');
    
});
