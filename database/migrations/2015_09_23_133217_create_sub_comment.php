<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubComment extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sub_comment', function(Blueprint $table)
		{
			$table->increments('sub_comment_id');
			$table->integer('users_id')->unsigned();
			$table->foreign('users_id')->references('id')->on('users');

			$table->integer('comment_id')->unsigned();
			$table->foreign('comment_id')->references('comment_id')->on('comment');

			//$table->integer('topic_id')->unsigned();
			//$table->foreign('topic_id')->references('topic_id')->on('topic');

			$table->string('sub_comment_body',10000);
			$table->string('sub_comment_status',20);
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
