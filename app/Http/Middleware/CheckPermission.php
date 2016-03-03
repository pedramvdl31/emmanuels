<?php

namespace App\Http\Middleware;

use Closure;
use App\Job;
use Auth;
use Laracasts\Flash\Flash;
use Session;
use Redirect;
class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  $permission - from routes.php to determine what type of check we need to make
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (!app('Illuminate\Contracts\Auth\Guard')->guest()) {
            // If successful continue onto page request
            if ($request->user()->can($permission)) {
                return $next($request);
            }
            Flash::warning('You do not have authorization to view this page');
            return Redirect::route('home_index');
        }
    }
}
