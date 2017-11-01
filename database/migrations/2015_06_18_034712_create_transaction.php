<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaction extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*
		Schema::create('transactions', function(Blueprint $table)
		{
			$table->increments('transactions_id');
			$table->integer('users_id')->unsigned();
			$table->foreign('users_id')->references('id')->on('users');

			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('category_id')->on('category');

			$table->string('description');
			$table->float('value');
			$table->float('balance');
			$table->timestamps();
		});
		*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Schema::drop('transactions');
	}

}
