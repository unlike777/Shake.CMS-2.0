<?php

namespace App\Modules\Info\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;

class InfoController extends AdminController {

    protected $module = 'info';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        view()->share([
            'module' => $this->module,
            'module_name' => 'Информация о сервере',
            'decls' => [
                'list' => '',
                'form' => '',
            ],
        ]);
    }
    
    public function def() {
        return view('info::admin.default');
    }
    
    public function php() {
        phpinfo();
    }
    
}
