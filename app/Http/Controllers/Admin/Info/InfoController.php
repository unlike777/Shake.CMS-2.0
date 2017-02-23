<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;

class InfoController extends Controller
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
