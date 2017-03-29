<?php

Route::group(['prefix' => 'admin'], function() {
    
    Route::any('/', 'Admin\Dashboard\DashboardController@def')->name('admin');
    
    Route::any('info', 'Admin\Info\InfoController@def')->name('admin.info');
    Route::any('info/php', 'Admin\Info\InfoController@php')->name('admin.info.php');
    
    Route::any('login', 'Admin\Auth\AuthController@login')->name('admin.login');
    Route::any('logout', 'Admin\Auth\AuthController@logout')->name('admin.logout');
    
    $modules = ['pages'];
    
    foreach ($modules as $module) {
        Route::any($module, 'Admin\\'.ucfirst($module).'\\'.ucfirst($module).'Controller@def')->name('admin.'.$module.'.def');
        Route::any($module.'/edit/{id}', 'Admin\\'.ucfirst($module).'\\'.ucfirst($module).'Controller@edit')->name('admin.'.$module.'.edit');
        Route::any($module.'/create', 'Admin\\'.ucfirst($module).'\\'.ucfirst($module).'Controller@create')->name('admin.'.$module.'.create');
        Route::any($module.'/delete/{id?}', 'Admin\\'.ucfirst($module).'\\'.ucfirst($module).'Controller@delete')->name('admin.'.$module.'.delete');
        Route::any($module.'/active', 'Admin\\'.ucfirst($module).'\\'.ucfirst($module).'Controller@active')->name('admin.'.$module.'.active');
    }
    
    Route::any('pages/position', 'Admin\Pages\PagesController@position')->name('admin.pages.position');
});
