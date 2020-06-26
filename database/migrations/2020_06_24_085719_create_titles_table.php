<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTitlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('titles', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('name')->nullable()->index('titles_name_fulltext');
			$table->string('type', 15)->default('movie');
			$table->decimal('tmdb_vote_average', 3, 1)->nullable();
			$table->string('release_date', 25)->nullable()->index();
			$table->smallInteger('year')->unsigned()->nullable();
			$table->text('description', 65535)->nullable();
			$table->string('genre', 191)->nullable();
			$table->string('tagline', 191)->nullable();
			$table->string('poster', 191)->nullable();
			$table->string('backdrop')->nullable();
			$table->integer('runtime')->unsigned()->nullable();
			$table->string('trailer', 191)->nullable();
			$table->bigInteger('budget')->unsigned()->nullable();
			$table->bigInteger('revenue')->unsigned()->nullable()->index();
			$table->bigInteger('views')->default(1);
			$table->integer('popularity')->unsigned()->nullable()->index('titles_tmdb_popularity_index');
			$table->string('imdb_id', 191)->nullable();
			$table->bigInteger('tmdb_id')->unsigned()->nullable();
			$table->integer('season_count')->unsigned()->nullable();
			$table->boolean('fully_synced')->nullable()->default(0);
			$table->boolean('allow_update')->default(1);
			$table->timestamps();
			$table->string('language', 191)->nullable();
			$table->string('country', 191)->nullable();
			$table->string('original_title', 191)->nullable();
			$table->string('affiliate_link', 191)->nullable();
			$table->integer('tmdb_vote_count')->unsigned()->nullable();
			$table->string('certification', 50)->nullable()->index();
			$table->integer('episode_count')->unsigned()->nullable();
			$table->boolean('series_ended')->default(0);
			$table->boolean('is_series')->default(0);
			$table->decimal('local_vote_average', 3, 1)->unsigned()->nullable();
			$table->boolean('show_videos')->default(0);
			$table->boolean('adult')->default(0);
			$table->integer('local_vote_count')->unsigned()->default(0)->index();
			$table->unique(['tmdb_id','is_series']);
			$table->index(['is_series','adult']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('titles');
	}

}
