<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->tinyInteger('type');
			$table->text('description')->nullable();
			$table->tinyInteger('quantity')->nullable();
			$table->decimal('pretax', 9,2)->nullable();
			$table->decimal('tax', 9,2)->nullable();
			$table->decimal('interest', 9,2)->nullable();
			$table->decimal('total', 9,2)->nullable();
			$table->tinyInteger('status');
			$table->dateTime('completed_on')->nullable();
			$table->string('payer_id',50)->nullable();
			$table->string('payment_id',100)->nullable();
			$table->string('payment_token',50)->nullable();
			$table->string('token',20)->nullable();
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
		Schema::drop('invoices');
	}

}
