<?php

namespace App\Modules\Dashboard\Controllers\Admin;

use App\Modules\Dashboard\Controllers\Admin\DefaultController;

class DashboardController extends DefaultController {

    protected $module = 'dashboard';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        view()->share([
            'module' => $this->module,
            'module_name' => config('admin.def_page_name'),
            'decls' => [
                'list' => '',
                'form' => '',
            ],
        ]);
    }
    
    public function def() {
        return view('dashboard::admin.default');
    }
}
