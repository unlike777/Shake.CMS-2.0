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
    public function __construct(Setting $model) {
        $this->model = $model;
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
        $this->table->add('title', 'Описание');
        $this->table->add('alias', 'Алиас');
        $this->table->add('created_at', 'Дата создания', 'text', 0, function($val, $obj) {
            return Date::parse($val)->format('j mm Y H:i:s');
        });
        $this->table->add('updated_at', 'Дата обновления', 'text', 0, function($val, $obj) {
            return Date::parse($val)->format('j mm Y H:i:s');
        });
        
        return parent::def();
    }
    
}
