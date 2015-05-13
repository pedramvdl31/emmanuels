<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNewColumnsToTaxesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('taxes', function(Blueprint $table)
		{	
			$table->tinyInteger('type')->nullable()->after('id');
			$table->string('name',50)->nullable()->after('type');
			$table->text('description')->nullable()->after('name');
			$table->dateTime('end')->nullable()->after('description');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('taxes', function(Blueprint $table)
		{
			
		});
	}

}
