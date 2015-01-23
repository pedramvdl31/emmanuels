<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username', 25)->unique();
		    $table->string('firstname', 25);
		    $table->string('lastname', 25);
		    $table->string('email', 100)->unique();
		    $table->string('password', 64);
		    $table->string('remember_token',65)->nullable();
		    $table->tinyInteger('roles');
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
		Schema::drop('users');
	}

}
