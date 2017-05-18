<?php

namespace App\Providers;

use App\Shake\ViewComposers\MenuComposer;
use App\Shake\ViewComposers\SitemapComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('dashboard::widgets.menu.main', MenuComposer::class);
        view()->composer('pages::sitemap.default', SitemapComposer::class);

        view()->composer('pages::layouts.main', function(View $view) {
            
            //$view->with(compact());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
