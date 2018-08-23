<?php

namespace App\Modules\Pages\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Pages\Models\Page;
use SEO;
use Menu;

class PagesController extends Controller {

    public function def() {
        $item = Page::where('is_home', '=', 1)->firstOrFail();
        
        $templ = empty($item->template) ? 'default' : $item->template;
        
        return view('pages::templates.'.$templ, ['item' => $item]);
    }

    public function pages($slug) {
        
        $qwe = 0;
        $qwe->qwe = 123;
        
//        \Log::error(new \Exception('ошибка ошибка ошибка'));
        $item = Page::where('slug', '=', $slug)->publ()->where('link', '=', '')->firstOrFail();
        
        SEO::set($item);
        Menu::add($item);
        
        $parent = $item;
        
        while ($parent = $parent->parent) {
            Menu::add($parent);
        }
        
        $templ = empty($item->template) ? 'default' : $item->template;
        
        return view('pages::templates.'.$templ, compact('item'));
    }
    
}
