<?php

namespace App\Modules\Settings\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Modules\Settings\Models\Setting;
use Date;

class SettingsController extends AdminController {
    
    protected $module = 'settings';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Setting $setting) {
        $this->model = $setting;
        parent::__construct();
        
        view()->share([
            'module_name' => 'Настройки',
            'decls' => [
                'list' => 'настроек', 
                'form' => 'настройки',
            ],
        ]);
    }
    
    public function def() {
        $this->table->add('title', 'Описание', 0);
        $this->table->add('alias', 'Алиас', 0);
        $this->table->add('created_at', 'Дата создания', 0, function($val, $obj) {
            return Date::parse($val)->format('j mm Y H:i:s');
        });
        $this->table->add('updated_at', 'Дата обновления', 0, function($val, $obj) {
            return Date::parse($val)->format('j mm Y H:i:s');
        });
        
        return parent::def();
    }
    
}
