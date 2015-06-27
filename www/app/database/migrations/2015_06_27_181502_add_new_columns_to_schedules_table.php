<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNewColumnsToSchedulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('schedules', function(Blueprint $table)
		{
			$table->tinyInteger('type')->nullable()->after('status');
			$table->boolean('will_phone')->nullable()->after('type');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('schedules', function(Blueprint $table)
		{
			
		});
	}

}
