<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreteTagTopic extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tag_topic', function(Blueprint $table)
		{
			$table->increments('tag_topic_id');
			$table->integer('tag_id')->unsigned();
			$table->foreign('tag_id')->references('tag_id')->on('tag');

			$table->integer('topic_id')->unsigned();
			$table->foreign('topic_id')->references('topic_id')->on('topic');

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
