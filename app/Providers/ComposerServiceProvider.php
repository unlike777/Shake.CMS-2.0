<?php

namespace App\Providers;

use App\Shake\ViewComposers\MenuComposer;
use App\Shake\ViewComposers\SitemapComposer;
use Illuminate\Support\ServiceProvider;

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
