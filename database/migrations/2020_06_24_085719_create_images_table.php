<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('images', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('local', 191)->nullable()->unique();
			$table->string('web', 191)->nullable()->unique();
			$table->integer('title_id')->unsigned()->nullable()->index();
			$table->timestamps();
			$table->string('type', 50)->default('external');
			$table->string('url', 191)->nullable();
			$table->string('source', 191)->default('local')->index();
			$table->integer('model_id')->index();
			$table->string('model_type', 50)->index();
			$table->integer('order')->unsigned()->default(0)->index();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('images');
	}

}
