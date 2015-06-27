<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNewColumnsToInvoiceItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('invoice_items', function(Blueprint $table)
		{
			$table->integer('height',false,true)->nullable()->after('total');
			$table->integer('length',false,true)->nullable()->after('total');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('invoice_items', function(Blueprint $table)
		{
			
		});
	}

}
