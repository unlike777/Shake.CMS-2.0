<?php

Route::any('/', 'PagesController@def')->name('home');
Route::any('/{slug}', 'PagesController@pages')->name('pages');

Route::any('sitemap', 'SitemapController@def')->name('sitemap');
Route::any('sitemap.xml', 'SitemapController@xml')->name('sitemap.xml');
