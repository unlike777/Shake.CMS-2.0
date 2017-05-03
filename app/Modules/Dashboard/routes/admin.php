<?php

Route::group(['prefix' => 'admin'], function() {

    Route::any('login', 'Admin\AuthController@login')->name('admin.login');
    Route::any('logout', 'Admin\AuthController@logout')->name('admin.logout');
    
    Route::any('/', 'Admin\DashboardController@def')->name('admin');
    
});
