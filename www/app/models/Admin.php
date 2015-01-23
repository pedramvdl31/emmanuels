<?php

class Admin extends \Eloquent {
	protected $fillable = [];
    public static function getRoleName($id)
    {
    	switch($id) {
    		case 1: // Superadmin
    		$role = 'Superadmins';
    		break;
    		case 2: // Admin
    		$role = 'Admins';
    		break;
    		case 3:
    		$role = 'Owners';
    		break;
    		case 4: // Employee
    		$role = 'Employees';
    		break;
    		case 5: // Member
    		$role = 'Members';
    		break;
    		default: // Guest
    		$role = 'Guests';
    		break;
    	}

    	return $role;
    }

}