<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInventoryItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventory_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('company_id',false,true)->nullable();
			$table->integer('owner_id',false,true)->nullable();
			$table->string('name',50)->nullable();
			$table->text('description')->nullable();
			$table->decimal('price',11,2)->nullable();
			$table->integer('order_number',false,true)->length(3)->nullable();
			$table->text('tags')->nullable();
			$table->tinyInteger('status');
			$table->integer('list_order',false,true)->length(11)->nullable();
			$table->unsignedInteger('inventory_id', false)->nullable();
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
		Schema::drop('inventory_items');
	}

}
