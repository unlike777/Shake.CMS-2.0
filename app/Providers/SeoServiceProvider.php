<?php

namespace App\Providers;

use App\Modules\Pages\Models\Page;
use Illuminate\Support\ServiceProvider;
use SEO;

class SeoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        SEO::change(Page::class, 'title', function(Page $obj, $text) {
            return $obj->title.' | '.SEO::getDefSeoText('title');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
