<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
	/**
	* Frontend Routing with filter
	*/
	Route::get('/', array('as' => 'home', 'uses' => 'HomeController@home'));
		Route::get('/services', 'HomeController@services');
		Route::get('/marketplace', 'HomeController@marketplace');
		Route::get('/aboutus', 'HomeController@aboutus');
		Route::get('/advice', 'HomeController@advice');
		Route::get('/contactus', 'HomeController@contactus'); 		

	Route::get('/admins/login', 'AdminsController@getLogin');
	Route::post('/admins/login','AdminsController@postLogin');
	Route::get('/admins/logout', 'AdminsController@getLogout');
	// // API CONTROLLER
	// Route::controller('api','ApisController');


	// //WORLDS CONTROLLER	
	// Route::controller('worlds','WorldsController');
	// 	Route::post('/worlds/cities', 'WorldsController@getCities');
	/**
	* ACL route filtering
	*/
	Route::group(array('before' => 'acl'), function()
	{
		//ADMINS CONTROLLER

		Route::get('/admins', 'AdminsController@getIndex');	

		// Route::post('/api/payables-calendar','ApiController@postPayablesCalendar');


		// //COMPANIES CONTROLLER
		Route::controller('/companies','CompaniesController');

		// // INVOICES CONTROLLER
		// Route::controller('/invoices','InvoicesController');	

		// // INVOICE ITEMS CONTROLLER
		// Route::controller('/invoice-items','InvoiceItemsController');

		// //MENUS CONTROLLER
		// Route::controller('menus', 'MenusController');
		// 	Route::get('/menus/organize/*', 'MenuController@getOrganize');	
		// //MENU ITEMS CONTROLLER
		// Route::controller('menu-items', 'MenuItemsController');
		

		// RESOURCES CONTROLLER
		Route::controller('/resources','ResourcesController');

		// // TAXES CONTROLLER
		// Route::controller('/taxes','TaxesController');

		// //USERS CONTROLLER
		Route::controller('users', 'UsersController');


		// WEBSITES CONTROLLER
		Route::controller('websites','WebsitesController');
	
		

	});

