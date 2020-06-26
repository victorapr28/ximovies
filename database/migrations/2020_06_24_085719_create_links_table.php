<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('links', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('url', 191)->unique();
			$table->string('type', 191)->default('embed');
			$table->string('label', 191)->nullable();
			$table->bigInteger('title_id')->unsigned()->nullable();
			$table->integer('season')->unsigned()->nullable();
			$table->integer('episode')->unsigned()->nullable();
			$table->integer('reports')->unsigned()->default(0);
			$table->timestamps();
			$table->string('temp_id', 30)->nullable();
			$table->integer('positive_votes')->default(0);
			$table->integer('negative_votes')->default(0);
			$table->string('quality', 191)->default('SD');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('links');
	}

}
