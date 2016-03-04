<?php

use Illuminate\Database\Seeder;

class SUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->insert([
		    [
		        'id' => '1',
		        'username' => 'wondo',
		        'email' => 'wondo@eyelevate.com',
		        'role' => '1',
		        'password' => bcrypt('0987poiu')
		    ],
		    [
		        'id' => '2',
		        'username' => 'pedram',
		        'email' => 'pedram@eyelevate.com',
		        'role' => '1',
		        'password' => bcrypt('110110')
		    ]
		 ]);
    }
}
