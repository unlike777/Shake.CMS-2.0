<?php

namespace App\Modules\Users\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Modules\Users\Models\User;
use Date;

class UsersController extends AdminController {

    protected $module = 'users';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $model) {
        $this->model = $model;
        parent::__construct();

        view()->share([
            'module_name' => 'Пользователи',
            'decls' => [
                'list' => 'пользователей',
                'form' => 'пользователя',
            ],
        ]);
    }
    
    public function def() {
        $this->table->add('email', 'Эл. почта');
        $this->table->add('created_at', 'Дата регистрации', 'text', 0, function($val, $obj) {
            return Date::parse($val)->format('j mm Y H:i:s');
        });
        $this->table->add('updated_at', 'Дата обновления', 'text', 0, function($val, $obj) {
            return Date::parse($val)->format('j mm Y H:i:s');
        });

        return parent::def();
    }
    
}
