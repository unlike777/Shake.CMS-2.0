<?php

Route::group(['prefix' => 'admin'], function() {

    $module = 'settings';
    
    Route::any($module, 'Admin\\'.ucfirst($module).'Controller@def')->name('admin.'.$module.'.def');
    Route::any($module.'/edit/{id}', 'Admin\\'.ucfirst($module).'Controller@edit')->name('admin.'.$module.'.edit');
    Route::any($module.'/create', 'Admin\\'.ucfirst($module).'Controller@create')->name('admin.'.$module.'.create');
    Route::any($module.'/delete/{id?}', 'Admin\\'.ucfirst($module).'Controller@delete')->name('admin.'.$module.'.delete');
//    Route::any($module.'/active', 'Admin\\'.ucfirst($module).'Controller@active')->name('admin.'.$module.'.active');
    
});
