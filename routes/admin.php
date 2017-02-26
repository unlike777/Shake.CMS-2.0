<?php

Route::group(['prefix' => 'admin'], function() {
    
    Route::any('/', 'Admin\Dashboard\DashboardController@def')->name('admin');
    
    Route::any('info', 'Admin\Info\InfoController@def')->name('admin.info');
    Route::any('info/php', 'Admin\Info\InfoController@php')->name('admin.info.php');
    
    Route::any('login', 'Admin\Auth\AuthController@login')->name('admin.login');
    Route::any('logout', 'Admin\Auth\AuthController@logout')->name('admin.logout');
});
