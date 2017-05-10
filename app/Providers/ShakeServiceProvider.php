<?php

namespace App\Providers;

use App\Shake\Libs\Date;
use App\Shake\Libs\Menu;
use App\Shake\Libs\Resizer;
use App\Shake\Libs\SEO;
use Illuminate\Support\ServiceProvider;

class ShakeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('date', Date::class);
        $this->app->bind('resizer', Resizer::class);
        $this->app->singleton('menu', Menu::class);
        $this->app->singleton('seo', SEO::class);
    }
}
