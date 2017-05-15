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
        $item = Page::where('slug', '=', $slug)->where('link', '=', '')->firstOrFail();

        SEO::set($item);
        Menu::add($item);
        
        $parent = $item;
        
        while ($parent = $parent->parent) {
            Menu::add($parent);
        }
        
        $templ = empty($item->template) ? 'default' : $item->template;
        
        $data = [];
        
        //подгружаем доп. данные необходимые для каждого щаблона
        $method = 'data'.ucfirst($templ);
        if (method_exists($this, $method)) {
            $data = $this->{$method}($item);
        }
        
        $data['item'] = $item;
        
        return view('pages::templates.'.$templ, $data);
    }

    /**
     * Доп. данные для шаблона Home
     * @return array
     */
    protected function dataHome() {
        $data = [];
        return $data;
    }
    
}
