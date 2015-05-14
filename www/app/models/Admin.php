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



    public static function checkAuthorized($controller, $method, $params)
    {
        $user_id = Auth::user()->id;
        $role_id = Auth::user()->roles;
        $authorized = true;

        if(Acl::isAllowed(Admin::getRoleName($role_id), $controller, $method) == false) {
            $authorized = false;
            
        }

        // Check for special authorized rules


        return $authorized;
    }
    public static function roles()
    {
        $roles = array(
            '' => 'Select Administrator Type',
            1 => 'Superadmin',
            2 => 'Admin',
            3 => 'Employee',
            4 => 'Member',
        );
        return $roles;
    }

}