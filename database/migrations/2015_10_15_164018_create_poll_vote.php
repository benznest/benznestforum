<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollVote extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('poll_vote', function(Blueprint $table)
		{
			$table->increments('poll_vote_id');
			$table->integer('users_id')->unsigned();
			$table->foreign('users_id')->references('id')->on('users');

			$table->integer('topic_id')->unsigned();
			$table->foreign('topic_id')->references('topic_id')->on('topic');

			$table->integer('poll_id')->unsigned();
			$table->foreign('poll_id')->references('poll_id')->on('poll');

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
