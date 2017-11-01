<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoll extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('poll', function(Blueprint $table)
		{
			$table->increments('poll_id');
			$table->integer('users_id')->unsigned();
			$table->foreign('users_id')->references('id')->on('users');

			$table->integer('topic_id')->unsigned();
			$table->foreign('topic_id')->references('topic_id')->on('topic');

			$table->string('name');
			$table->string('detail');
			$table->string('option_status',20);

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
		//
	}

}
