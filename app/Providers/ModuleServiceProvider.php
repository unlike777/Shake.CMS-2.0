<?php

namespace App\Providers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use View;
use File;

class ModuleServiceProvider extends ServiceProvider
{
    private $namespace = 'App\Modules';
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach (config('modules') as $module_name => $module) {
            $this->addRoutes($module_name);
            $this->addViews($module_name);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
    
    public function addRoutes($module_name) {
        
        $groups = ['admin', 'web'];
        
        foreach ($groups as $group) {
            $path = module_path($module_name, 'routes/'.$group.'.php');
            if (File::exists($path)) {
                Route::middleware($group)
                    ->namespace($this->namespace.'\\'.ucfirst(camel_case($module_name)).'\\Controllers')
                    ->group($path);
            }
        }
        
    }
    
    public function addViews($module_name) {
        View::addNamespace($module_name, module_path($module_name, 'views'));
    }
}
