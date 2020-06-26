<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePeopleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('people', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('name', 191)->index('people_name_fulltext');
			$table->text('description', 65535)->nullable();
			$table->string('gender', 10)->nullable();
			$table->string('birth_date')->nullable();
			$table->string('birth_place')->nullable();
			$table->string('poster')->nullable();
			$table->string('imdb_id')->nullable();
			$table->bigInteger('views')->default(1);
			$table->bigInteger('tmdb_id')->unsigned()->nullable()->unique();
			$table->boolean('allow_update')->default(1);
			$table->timestamps();
			$table->boolean('fully_synced');
			$table->string('known_for', 50)->nullable();
			$table->integer('popularity')->default(0)->index();
			$table->string('death_date', 191)->nullable();
			$table->boolean('adult')->default(0);
			$table->index(['adult','popularity']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('people');
	}

}
