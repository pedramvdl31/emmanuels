<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		Session::flash('redirect', URL::full()); // Grab the intended page 
		return Redirect::guest('admins.login');

	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});


Route::filter('acl', function($route, $request)
{
    // we need this because laravel delete form sends POST request with {_method: 'DELETE'} as parameter
    $method = $request->has('_method') ? $request->input('_method') : $request->server('REQUEST_METHOD');
	$routes = explode("@", Route::currentRouteAction(), 2);     
    $controller = strtolower(str_replace('Controller', '', $routes[0]));
    $method = $routes[1];
    $parameters = Route::current()->parameters();

    if(Auth::guest()) {
    	Session::flash('redirect', URL::full()); // Grab the intended page 
    	return Redirect::to('admins/login')
	        ->with('message', 'You do not have access to this content.')
	        ->with('alert_type','alert-danger')
	        ->withInput();
    } elseif(Admin::checkAuthorized($controller,$method, $parameters) == false) {
		return Redirect::to('/admins')
			->with('message','You are not authorized to view this page!')
			->with('alert_type','alert-danger')
			->withInput();
		
	} 

});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	$token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');
	if (Session::token() != $token)
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
