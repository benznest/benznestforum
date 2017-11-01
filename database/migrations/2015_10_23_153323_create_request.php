<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequest extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('request', function(Blueprint $table)
		{
			$table->increments('request_id');
			$table->string('request_name',50);
			$table->string('request_target',50);
			
			$table->integer('users_id')->unsigned();
			$table->foreign('users_id')->references('id')->on('users');

			$table->integer('topic_id')->unsigned();
			$table->foreign('topic_id')->references('topic_id')->on('topic');

			$table->integer('comment_id')->unsigned();
			//$table->foreign('comment_id')->references('comment_id')->on('comment');

			$table->integer('sub_comment_id')->unsigned();
			//$table->foreign('sub_comment_id')->references('sub_comment_id')->on('sub_comment');

			$table->string('reason_main',100);
			$table->string('reason_detail',3000);
			$table->string('contact_detail',200);
			$table->string('request_status',50);

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
