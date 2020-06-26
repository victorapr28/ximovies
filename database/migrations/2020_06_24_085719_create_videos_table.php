<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->string('thumbnail', 191)->nullable();
			$table->text('url', 65535);
			$table->string('type', 50);
			$table->string('quality', 50)->nullable();
			$table->integer('title_id')->unsigned()->index();
			$table->integer('season')->unsigned()->nullable()->index();
			$table->integer('episode')->unsigned()->nullable()->index();
			$table->string('source', 191)->default('local')->index();
			$table->integer('negative_votes')->unsigned()->default(0)->index();
			$table->integer('positive_votes')->unsigned()->default(0)->index();
			$table->integer('reports')->unsigned()->default(0);
			$table->integer('approved')->unsigned()->default(1)->index();
			$table->integer('order')->unsigned()->default(0)->index();
			$table->timestamps();
			$table->integer('user_id')->unsigned()->nullable()->index();
			$table->string('language', 5)->default('en')->index();
			$table->string('category', 20)->default('trailer')->index();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('videos');
	}

}
