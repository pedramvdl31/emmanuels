<?php

use Illuminate\Database\Seeder;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
		    [
		        'id' => '1',
		        'role_title' => 'Superadmins',
		        'role_slug' => 'superadmins'
		    ],
		    [
		        'id' => '2',
		        'role_title' => 'Admins',
		        'role_slug' => 'admins'
		    ],
		    [
		        'id' => '3',
		        'role_title' => 'Admins (Simple)',
		        'role_slug' => 'admins'
		    ],
		    [
		        'id' => '4',
		        'role_title' => 'Employees',
		        'role_slug' => 'employees'
		    ],
		    [
		        'id' => '5',
		        'role_title' => 'Users',
		        'role_slug' => 'users'
		    ],
		    [
		        'id' => '6',
		        'role_title' => 'Guest',
		        'role_slug' => 'Guest'
		    ]

        ]);
    }
}
