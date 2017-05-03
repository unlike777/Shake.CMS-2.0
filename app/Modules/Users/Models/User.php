<?php

namespace App\Modules\Users\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\ShakeUser;

class User extends ShakeUser 
{
    use Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password',
//    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $fields = array(
        'name' => array(
            'type' => 'text',
            'title' => 'Имя',
        ),
        'email' => array(
            'type' => 'text',
            'title' => 'Эл. почта',
        ),
        'group' => array(
            'type' => 'select',
            'title' => 'Группа',
            'values' => [
                '' => '',
                'admin' => 'Администратор',
            ],
        ),
        'password' => array(
            'type' => 'password',
            'title' => 'Пароль',
        ),
        
    );
    
    public function validate($data, $behavior = 'default') {
        
        $rules = array(
            'name' => '',
            'email' => 'required|min:5|email|unique:users,email',
            'group' => '',
            'password' => '',
        );
        
        if (!empty($this->id)) {
            $rules['email'] = $rules['email'].','.$this->id;
        } else {
            $rules['password'] = 'required|min:6';
        }
        
        if ($behavior == 'onAuth') {
            $rules = array(
                'email' => 'required|min:5|email',
                'password' => 'required|min:6',
            );
        }
        
        if ($behavior == 'onAdd') {
            $rules['password2'] = 'required|same:password';
        }
        
        if ($behavior == 'onEdit') {
            $rules['password2'] = 'required_with:password|same:password';
        }
        
        return validator($data, $rules);
    }
    
    public function setPasswordAttribute($value) {
        $value = trim($value);
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}
