<?php

namespace App\Shake\ViewComposers;

use App\Modules\Pages\Models\Page;
use Route;
use Illuminate\View\View;

class SitemapComposer {
    
    public function compose(View $view) {
        $pages = Page::publ()->wherePageId(0)->orderBy('position')->get();
        $view->with(compact('pages'));
    }
    
}
