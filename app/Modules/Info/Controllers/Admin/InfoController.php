<?php

namespace App\Modules\Info\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;

class InfoController extends AdminController {
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }
    
    public function def() {
        return view('info::admin.default');
    }
    
    public function php() {
        phpinfo();
    }
    
}
