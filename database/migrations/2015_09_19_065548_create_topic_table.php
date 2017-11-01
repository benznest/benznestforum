<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('topic', function(Blueprint $table)
		{
			$table->increments('topic_id');
			$table->integer('users_id')->unsigned();
			$table->foreign('users_id')->references('id')->on('users');

			$table->integer('topic_type_id')->unsigned();
			$table->foreign('topic_type_id')->references('topic_type_id')->on('topic_type');

			$table->string('title');
			$table->string('body',10000);
			$table->string('topic_status',20);

			//$table->float('value');
			//$table->float('balance');
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
