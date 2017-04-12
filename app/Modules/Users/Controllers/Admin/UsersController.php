<?php

namespace App\Modules\Users\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Modules\Users\Models\User;
use Date;

class UsersController extends AdminController {
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user) {
        $this->model = $user;
        parent::__construct();
    }
    
    public function def() {
        $this->table->add('email', 'Эл. почта', 0);
        $this->table->add('created_at', 'Дата регистрации', 0, function($val, $obj) {
            return Date::parse($val)->format('j mm Y H:i:s');
        });
        $this->table->add('updated_at', 'Дата обновления', 0, function($val, $obj) {
            return Date::parse($val)->format('j mm Y H:i:s');
        });

        return parent::def();
    }
    
}
