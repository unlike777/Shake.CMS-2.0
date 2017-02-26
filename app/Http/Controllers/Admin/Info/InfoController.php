<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Admin\AdminController;

class InfoController extends AdminController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
    
    public function def()
    {
        return view('admin.info.default');
    }
    
    public function php()
    {
        phpinfo();
    }
}
