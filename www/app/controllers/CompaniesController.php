<?php

class CompaniesController extends \BaseController {
	//set layout
	protected $layout = "layouts.admin";
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function __construct() {
		// Set protection
		$this->beforeFilter('csrf', array('on'=>'post'));


		// Check if user is authorized to view the page
		$routes = explode("@", Route::currentRouteAction(), 2);     
        $this->controller = strtolower(str_replace('Controller', '', $routes[0]));
        $this->method = $routes[1];
        $this->parameters = Route::current()->parameters();

		// Set the layout
		switch(Auth::user()->roles){
			case 2:
				$this->layout = "layouts.admin";
			break;
			case 3:
				$this->layout = "layouts.admin_owner";
			break;
			case 4:
				$this->layout = "layouts.admin_employees";
			break;
			case 5:
				$this->layout = "layouts.admin_members";
			break;
			case 6:
				$this->layout = "layouts.admin";
			break;
		}
     
     	// Page content setup

        $this->company_id = 1;
        
        $role_id = (isset($member_id)) ? Auth::user()->roles : null;
        $role_name = Admin::getRoleName($role_id);
	
        View::share('role',$role_name);
       	View::share('controller',$this->controller);
		View::share('action',$this->method);

	}

	public function getAdd() {

		$time = Company::getDayHours();
		$country = Company::country_code();

		//var_dump($cities);
		$this->layout->content = View::make('companies.add')
			->with('time',$time)
			->with('country_code',$country);
	}
	/*
	* Processes the company form and redirect with a flash if successful else go back with errors
	*
	*/

	public function postAdd(){

		$validator = Validator::make(Input::all(), Company::$rules);
	 
	    if ($validator->passes()) {
			$store_hours = Company::prepareStoreHours(Input::get('hours'));

			$owner_id = (isset(Auth::user()->parent_id)) ? Auth::user()->parent_id : Auth::user()->id;	    	
	        // validation has passed, save user in DB
			$company = new Company;
			$company->name = Input::get('name');
			$company->phone = Input::get('phone');
			$company->email = Input::get('email');
			$company->street = Input::get('street');
			$company->zipcode = Input::get('zipcode');
			$company->city = Input::get('city');
			$company->state = Input::get('state');
			$company->region = Input::get('region');
			$company->country = Input::get('country');
			$company->store_hours = $store_hours;
			$company->status = 1;
			if($company->save()){

				/**
				* Begin Page Processing
				**/	
				$img_folder = 'img/'.$company->id;
				if (!is_dir($img_folder)){
				    mkdir($img_folder, 0755, true);
				}
			}

		    return Redirect::action('CompaniesController@getView')
		    	->with('message', 'Successfully Registered Company!')
		    	->with('alert_type','alert-success');

	    } else {
	        // validation has failed, display error messages    
	        return Redirect::to('/companies/add')
	        	->with('message', 'The following errors occurred')
	        	->with('alert_type','alert-danger')
	        	->withErrors($validator)
	        	->withInput();
	    }
	}	
	public function getEdit($id = null) {
		
		$owner_id = (isset(Auth::user()->parent_id)) ? Auth::user()->parent_id : Auth::user()->id;
		$companies_all_by_owner = (count(Company::where('owner_id',$owner_id)->get())) ? Company::where('owner_id',$owner_id)->get() : array();
		
		$company_list = array(
			''=>'Select which company that will use this printer'
		);
		if(count($companies_all_by_owner)) {
			foreach ($companies_all_by_owner as $c) {
				$company_list[$c['id']] = $c['name'].' : '.$c['nick_name'];
			}
		}
		$time = Company::getDayHours();
		$country = Company::country_code();
		$companies = Company::prepareForView(Company::find($id));
		View::share('companies',$companies);
		// $this->layout = View::make('layouts.admin_company'); // Override controller layout
		$this->layout->content = View::make('companies.edit')
			->with('company_list',$company_list)
			->with('time',$time)
			->with('country_code',$country);		
	}

	public function postEdit(){

		$store_hours = Company::prepareStoreHours(Input::get('hours'));

		$owner_id = (isset(Auth::user()->parent_id)) ? Auth::user()->parent_id : Auth::user()->id;	    	
        // validation has passed, save user in DB
		$id = Input::get('id');
		$company = Company::find($id);
		$company->name = Input::get('name');
		$company->nick_name = Input::get('nick_name');
		$company->phone = Input::get('phone');
		$company->email = Input::get('email');
		$company->street = Input::get('street');
		$company->zipcode = Input::get('zipcode');
		$company->city = Input::get('city');
		$company->state = Input::get('state');
		$company->region = Input::get('region');
		$company->country = Input::get('country');
		$company->store_hours = $store_hours;
		$company->url = Input::get('url');
		$company->payment_period = Input::get('payment_period');
		$company->status = 1;
		$company->save();

		return Redirect::action('CompaniesController@getIndex',Input::get('id'))
	    	->with('message', 'Successfully updated company!')
	    	->with('alert_type','alert-success');

	}
	public function getView(){

		$companies = Company::prepareForView(Company::find($this->company_id));
		$owners = User::prepareForView(User::find($companies->owner_id));
		View::share('companies',$companies);

		$website = array();
		// $website = Website::prepare(Website::where('company_id', '=', $this->company_id)->first());
		$this->layout->content = View::make('companies.view')
			->with('owners',$owners)
			->with('websites',$website);
	}

}