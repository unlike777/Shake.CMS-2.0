<?php

Route::any('test', 'TestController@test');

//Route::any('/', 'PagesController@def')->name('home');
Route::any('/pages/{slug}', 'PagesController@pages')->name('pages');
