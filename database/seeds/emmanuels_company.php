<?php

use Illuminate\Database\Seeder;

class emmanuels_company extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('companies')->insert([
		        'id' => '1',
		        'name' => 'emmanuels',
		        'email' => 'tsand@yahoo.com',
		        'street' => '230 South Hinds Street',
		        'city' => 'Seattle',
		        'state' => 'WA',
		        'zipcode' => '98134 ',
		]);
    }
}
