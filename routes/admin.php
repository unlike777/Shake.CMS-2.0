<?php

Route::group(['prefix' => 'admin'], function() {
    
    Route::any('login', 'Admin\Auth\AuthController@login')->name('admin.login');
    Route::any('logout', 'Admin\Auth\AuthController@logout')->name('admin.logout');

    Route::any('ajax/upload', 'Admin\AjaxController@upload')->name('admin.ajax.upload');
    Route::any('ajax/delete', 'Admin\AjaxController@delete')->name('admin.ajax.delete');
    
});
