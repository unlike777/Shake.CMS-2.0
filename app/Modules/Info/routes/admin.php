<?php

Route::group(['prefix' => 'admin'], function() {

    Route::any('info', 'Admin\InfoController@def')->name('admin.info');
    Route::any('info/php', 'Admin\InfoController@php')->name('admin.info.php');
    
});
