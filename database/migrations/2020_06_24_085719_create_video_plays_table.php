<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVideoPlaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('video_plays', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->nullable()->index();
			$table->integer('video_id')->index();
			$table->dateTime('created_at')->nullable();
			$table->string('platform', 30)->nullable()->index();
			$table->string('device', 30)->nullable()->index();
			$table->string('browser', 30)->nullable()->index();
			$table->string('location', 5)->nullable()->index();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('video_plays');
	}

}
