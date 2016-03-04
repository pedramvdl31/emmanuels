<?php

use Illuminate\Database\Seeder;

class RoleUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('role_user')->insert([
		    [
		        'id' => '1',
		        'role_id' => '1',
		        'user_id' => '1'
		    ],
		    [
		        'id' => '2',
		        'role_id' => '1',
		        'user_id' => '2'
		    ]
		]);
    }
}
