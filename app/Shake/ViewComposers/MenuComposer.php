<?php

namespace App\Shake\ViewComposers;

use Route;
use Illuminate\View\View;

class MenuComposer {
    
    public function compose(View $view) {
        $menu = $this->menu();
        
        $route = Route::currentRouteAction();
        $route = explode('@', $route);
        $route = $route[0];
        
        //проверяем активность пункта меню
        foreach ($menu as $num => $group) {
            foreach ($group['items'] as $key => $item) {
                $menu[$num]['items'][$key]['active'] = false;
                if (strripos($route, $item['route']) !== false) {
                    $menu[$num]['items'][$key]['active'] = true;
                }
            }
        }
        
        $view->with(compact('menu', 'route'));
    }
    
    public function menu() {
        return [
            [
                'group' => '',
                'items' => [
                    ['name' => config('admin.def_page_name'), 'url' => '/admin', 'route' => 'Admin\Dashboard\DashboardController', 'glyph' => 'dashboard'],
                ],
            ],
            [
                'group' => 'Структура',
                'items' => [
                    ['name' => 'Страницы', 'url' => '/admin/pages', 'route' => 'Admin\Pages\PagesController', 'glyph' => 'file'],
                ],
            ],
            [
                'group' => 'Системные',
                'items' => [
                    ['name' => 'Пользователи', 'url' => '/admin/users', 'route' => 'Admin\Users\UsersController', 'glyph' => 'users'],
                    ['name' => 'Настройки', 'url' => '/admin/settings', 'route' => 'Admin\Settings\SettingsController', 'glyph' => 'cogs'],
                    ['name' => 'Инфо о сервере', 'url' => '/admin/info', 'route' => 'Admin\Info\InfoController', 'glyph' => 'info-circle'],
                ],
            ],
        ];
    }
    
}
