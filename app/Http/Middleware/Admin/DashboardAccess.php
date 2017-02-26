<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Auth;
use Redirect;

class DashboardAccess
{
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
        foreach ($this->except as $except)
        {
            if ($request->is($except))
            {
                return $next($request);
            }
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
}
