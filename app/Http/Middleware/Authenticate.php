<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Job;
use Laracasts\Flash\Flash;
use Session;
use URL;
class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {

            // Check where the user came from, if from admins then redirect accordingly
            $redirect_path = ($request->is('admins') || $request->is('admins/*')) ? '/admins/login' : '/users/login';
            // Set intended page
            Session::put('intended_url',$request->url());

            Flash::error('You must be logged in to view the page');
            return redirect($redirect_path);
        }
        return $next($request);
    }
}
