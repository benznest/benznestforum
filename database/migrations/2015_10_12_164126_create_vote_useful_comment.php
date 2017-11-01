<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoteUsefulComment extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vote_useful_comment', function(Blueprint $table)
		{
			$table->increments('vote_useful_comment_id');
			$table->integer('users_id')->unsigned();
			$table->foreign('users_id')->references('id')->on('users');

			$table->integer('comment_id')->unsigned();
			$table->foreign('comment_id')->references('comment_id')->on('comment');

			$table->integer('vote_value');

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
