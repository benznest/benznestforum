<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
			$table->string('username')->unique();
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->string('gender', 10);
			$table->date('birthday');
			$table->string('photo', 100);
			$table->string('level', 20)->default('member');
			$table->string('status', 20)->default('active');
			$table->rememberToken();
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
