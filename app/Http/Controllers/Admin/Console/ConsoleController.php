<?php

namespace App\Http\Controllers\Admin\Console;

use App\Http\Controllers\Controller;

class ConsoleController extends Controller
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
        return view('admin.console.default');
    }
}
