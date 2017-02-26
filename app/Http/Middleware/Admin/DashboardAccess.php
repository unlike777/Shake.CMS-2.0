<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Redirect;

class DashboardAccess
{
    /**
     * Роуты которые следует исключить
     * @var array
     */
    protected $except = [
        'admin/login',
        'admin/logout',
    ];
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->inExceptArray($request))
        {
            return $next($request);
        }
        
        $user = Auth::user();
        if (!$user)
        {
            return Redirect::guest(route('admin.login'));
        }
        
        if ($user->group != 'admin')
        {
            abort(403);
        }

        return $next($request);
    }
    
    /**
     * Проверяет исключения для роутов
     * @param Request $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except)
        {
            if ($except !== '/')
            {
                $except = trim($except, '/');
            }
            
            if ($request->is($except))
            {
                return true;
            }
        }
        
        return false;
    }
}
