<?php

Route::group(['prefix' => 'admin'], function() {

    Route::any('/', 'Admin\DashboardController@def')->name('admin');
    
});
