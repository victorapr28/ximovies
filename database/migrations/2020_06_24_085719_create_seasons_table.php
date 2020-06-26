<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSeasonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seasons', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('release_date', 191)->nullable();
			$table->string('poster', 191)->nullable();
			$table->integer('number')->default(1);
			$table->bigInteger('title_id')->unsigned()->nullable()->index();
			$table->bigInteger('title_tmdb_id')->unsigned()->nullable()->index();
			$table->boolean('allow_update')->default(1);
			$table->timestamps();
			$table->integer('episode_count');
			$table->boolean('fully_synced')->default(0);
			$table->unique(['title_id','number'], 'tile_number_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('seasons');
	}

}
