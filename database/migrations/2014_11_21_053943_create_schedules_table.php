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
	        $table->string('title');
	        $table->text('description');
	        $table->tinyInteger('status');
	        $table->timestamps();
	        $table->softDeletes();
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
