<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavorite extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('favorite_topic', function(Blueprint $table)
		{
			$table->increments('favorite_id');
			
			$table->integer('users_id')->unsigned();
			$table->foreign('users_id')->references('id')->on('users');

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
