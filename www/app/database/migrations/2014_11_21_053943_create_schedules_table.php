<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSchedulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedules', function(Blueprint $table)
		{
			$table->increments('id');	
			$table->unsignedInteger('user_id', false)->nullable();
			$table->unsignedInteger('invoice_id', false)->nullable();
			$table->string('firstname', 25)->nullable();
			$table->string('lastname', 25)->nullable();
			$table->string('email', 100)->nullable();
			$table->string('phone', 15)->nullable();
			$table->string('street',200)->nullable();
			$table->string('unit', 10)->nullable();
			$table->string('city',50)->nullable();
			$table->string('state', 50)->nullable();
			$table->string('zipcode', 10)->nullable();
			$table->tinyInteger('type')->nullable();
			$table->boolean('will_phone')->nullable();
			$table->tinyInteger('place')->nullable();
			$table->dateTime('pickup_date')->nullable();
			$table->dateTime('delivery_date')->nullable();
			$table->tinyInteger('status')->nullable();			
			$table->softDeletes();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('schedules');
	}

}
