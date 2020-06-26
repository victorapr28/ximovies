<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVideoCaptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('video_captions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 50);
			$table->string('language', 5)->default('en')->index();
			$table->char('hash', 36)->unique();
			$table->string('url', 191)->nullable();
			$table->integer('video_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->nullable()->index();
			$table->integer('order')->unsigned()->default(0)->index();
			$table->timestamps();
			$table->unique(['name','video_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('video_captions');
	}

}
