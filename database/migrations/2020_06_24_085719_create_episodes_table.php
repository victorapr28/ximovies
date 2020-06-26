<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEpisodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('episodes', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('name');
			$table->text('description', 65535)->nullable();
			$table->string('poster')->nullable();
			$table->string('release_date', 191)->nullable();
			$table->bigInteger('title_id')->unsigned()->index();
			$table->bigInteger('season_id')->unsigned()->index();
			$table->integer('season_number')->unsigned()->default(1)->index();
			$table->integer('episode_number')->unsigned()->default(1)->index();
			$table->boolean('allow_update')->default(1);
			$table->timestamps();
			$table->string('temp_id', 30)->nullable();
			$table->integer('tmdb_vote_count')->unsigned()->nullable();
			$table->decimal('tmdb_vote_average', 3, 1)->nullable();
			$table->decimal('local_vote_average', 3, 1)->nullable();
			$table->smallInteger('year')->unsigned()->nullable();
			$table->integer('popularity')->unsigned()->nullable()->index();
			$table->integer('local_vote_count')->unsigned()->default(0)->index();
			$table->unique(['episode_number','season_number','title_id'], 'ep_s_title_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('episodes');
	}

}
