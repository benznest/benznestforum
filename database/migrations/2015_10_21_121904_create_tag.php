<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTag extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tag', function(Blueprint $table)
		{
			$table->increments('tag_id');
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('category_id')->on('category');

			$table->string('tag_name',50);
			$table->string('tag_status',50);
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
