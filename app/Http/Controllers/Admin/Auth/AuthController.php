<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 25.02.2017
 * Time: 21:32
 */

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Auth\User;
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
        if (!empty($_POST))
        {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            
            if (Auth::attempt($request->only('email', 'password'), $request->has('remember')))
            {
                return Redirect::intended(route('admin'));
            }
            
            return Redirect::back()->withInput()->withErrors(['errors' => ['Неправильная пара логин/пароль', '123123']]);
        }
        
        return view('admin.login');
    }
    
    public function logout()
    {
        Auth::logout();
        return Redirect::back();
    }
}
