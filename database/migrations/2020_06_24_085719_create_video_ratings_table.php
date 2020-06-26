<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVideoRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('video_ratings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('rating', 20);
			$table->integer('user_id')->unsigned()->nullable()->index();
			$table->integer('video_id')->unsigned()->index();
			$table->string('user_ip', 20)->index();
			$table->unique(['user_id','video_id']);
			$table->unique(['user_ip','video_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('video_ratings');
	}

}
