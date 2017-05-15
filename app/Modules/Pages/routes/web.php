<?php

//Route::any('/', 'PagesController@def')->name('home');
Route::any('/pages/{slug}', 'PagesController@pages')->name('pages');
