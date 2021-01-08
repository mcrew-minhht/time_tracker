<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class checkIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check())
        {
            $permission = Route::currentRouteName();
            $permissionCurrent = ['project_managers', 'project_managers_create','project_managers_store'
                ,'project_managers_edit','project_managers_update','project_managers_destroy','users','users_create'
                ,'users_store','users_edit','pusers_update','users_destroy','statistical_project'
                ,'statistical_project_post','statistical_month','statistical_month_post','pdf_project','pdf_month'];
            $user = Auth::user();
            if ($user->level != 1){
                if (in_array($permission, $permissionCurrent)) {
                    abort(403);
                }
            }
        }
        return $next($request);
    }
}
