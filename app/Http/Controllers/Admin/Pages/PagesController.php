<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Structure\Page;

class PagesController extends AdminController
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Page $page)
    {
        $this->model = $page;
    }
    
    public function def()
    {
        $items = $this->model->wherePageId(0)->get();
        return view('admin.pages.default', compact('items'));
    }
    
}
