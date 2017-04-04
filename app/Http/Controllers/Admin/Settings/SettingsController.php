<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Utils\Setting;
use Date;

class SettingsController extends AdminController {
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Setting $setting) {
        $this->model = $setting;
        parent::__construct();
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
