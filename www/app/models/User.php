<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Zend\Permissions\Acl\Role\RoleInterface;

class User extends Eloquent implements UserInterface, RemindableInterface, RoleInterface {
	use SoftDeletingTrait;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	public static $rules_add = array(
		'username'=>'required|alpha_num|min:4|unique:users',
		'firstname'=>'required|alpha|min:2',
		'lastname'=>'required|alpha|min:2',
		'email'=>'required|email|unique:users',
		'password'=>'required|between:6,25|confirmed',
		'password_confirmation'=>'required|between:6,25'
		);
	public static $rules_edit = array(
		'username'=>'required|alpha_num|min:4|unique:users',
		'firstname'=>'required|alpha|min:2',
		'lastname'=>'required|alpha|min:2',
		'email'=>'required|email',
		'password'=>'between:6,25|confirmed',
		'password_confirmation'=>'between:6,25'
		);
	public static $rules = array(
		'username'=>'required|alpha_num|min:4|unique:users',
		'firstname'=>'required|alpha|min:2',
		'lastname'=>'required|alpha|min:2',
		'email'=>'required|email|unique:users',
		'password'=>'required|between:6,25|confirmed',
		'password_confirmation'=>'required|between:6,25'
		);
	public static $edit_rules = array(
		'username'=>'required|alpha_num|min:4',
		'firstname'=>'required|alpha|min:2',
		'lastname'=>'required|alpha|min:2',
		'email'=>'required|email',
		'password'=>'between:6,25|confirmed',
		'password_confirmation'=>'between:6,25'
		);
	public static $rules_reset = array(
		'email'=>'required|email',
		'password'=>'required|between:6,25|confirmed',
		'password_confirmation'=>'required|between:6,25'
		);

	public static function prepare($data){
		if(isset($data)){
			foreach ($data as $key => $value) {
				if(isset($data[$key]['roles'])) {
					switch ($data[$key]['roles']) {
						case 1:// Super Admin
						$data[$key]['roles_formated'] = '<span class="label label-primary">Super Admin</span>';
						break;
						case 2:// Admin
						$data[$key]['roles_formated'] = '<span class="label label-primary">Admin</span>';
						break;
						case 3:// Employee
						$data[$key]['roles_formated'] = '<span class="label label-info">Employee</span>';
						break;
						case 4:// Member
						$data[$key]['roles_formated'] = '<span class="label label-info">Member</span>';
						break;
						default://errors
						$data[$key]['roles_formated'] = '<span class="label label-danger">Error</span>';
						break;
					}
				}

			}
		}
		return $data;
	}

	public static function getOwnerId($member_id) {
		$owner_id = (isset($member_id)) ? (isset(Auth::user()->parent_id)) ? Auth::user()->parent_id : Auth::user()->id : null;
		return $owner_id;
	}

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	* ACL
	*/
    /**
     * Returns role of the user
     * @return string
     */
    public function getRoleId()
    {
    	return $this->role;
    }

    /**
    * Public methods
    **/
    public static function prepareForSelect($data) {
    	$users = array(''=>'Select an employee');
    	if(isset($data)) {
    		foreach ($data as $key => $value) {
    			$id = $value['id'];
    			$username = $value['username'];
    			$first_name = $value['firstname'];
    			$last_name = $value['lastname'];
    			$users[$id] = $username.' ['.$first_name.' '.$last_name.']';
    		}
    	}

    	return $users;
    }

    public static function prepareForView($data) {

    	if(isset($data['phone'])) {
    		$data['country'];
    		$data['phone'] = Job::format_phone($data['phone'], $data['country']);
    	}

    	if(isset($data['billing_type'])) {
    		$data['billing_type_display'] = ($data['billing_type'] == false) ? 'Automatic payments are not set.' : 'Automatic payments are set.';
    	} else {
    		$data['billing_type'] = false;
    		$data['billing_type_display'] = 'Automatic payments are not set.';
    	}
    	return $data;
    }

}
