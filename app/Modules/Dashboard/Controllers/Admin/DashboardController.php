<?php

namespace App\Modules\Dashboard\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;

class DashboardController extends AdminController {
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }
    
    public function def() {
        return view('dashboard::admin.default');
    }
}
