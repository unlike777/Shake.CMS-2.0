<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 25.02.2017
 * Time: 21:32
 */

namespace App\Modules\Dashboard\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Modules\Users\Models\User;
use Illuminate\Http\Request;
use Auth;
use Redirect;

class AuthController extends AdminController
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function login(Request $request)
    {
        if (!empty($_POST)) {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            
            if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
                return Redirect::intended(route('admin'));
            }
            error('Неправильная пара логин/пароль');
        }
        
        return view('dashboard::admin.login');
    }
    
    public function logout()
    {
        Auth::logout();
        return Redirect::back();
    }
}
