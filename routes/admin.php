<?php

Route::group(['prefix' => 'admin'], function() {
    
    Route::any('login', 'Admin\Auth\AuthController@login')->name('admin.login');
    Route::any('logout', 'Admin\Auth\AuthController@logout')->name('admin.logout');
    
    //ajax загрузка файлов
    Route::any('ajax/upload', 'Admin\AjaxController@upload')->name('admin.ajax.upload');
    Route::any('ajax/delete', 'Admin\AjaxController@delete')->name('admin.ajax.delete');
    
    //уникальные поля
    Route::any('fields/create/{parent_id}', 'Admin\FieldsController@create')->name('admin.fields.create');
    Route::any('fields/update/{id}', 'Admin\FieldsController@update')->name('admin.fields.update');
    Route::any('fields/delete/{id}', 'Admin\FieldsController@delete')->name('admin.fields.delete');
    
});
