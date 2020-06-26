<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reviews', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('author', 191)->nullable();
			$table->string('source', 191)->nullable();
			$table->text('body', 65535)->nullable();
			$table->integer('score')->nullable();
			$table->string('link', 191)->nullable();
			$table->integer('reviewable_id')->unsigned()->index('reviews_title_id_index');
			$table->integer('user_id')->unsigned()->nullable();
			$table->timestamps();
			$table->string('type', 50)->default('critic');
			$table->string('reviewable_type', 191)->nullable()->index();
			$table->unique(['reviewable_id','author'], 'author_title_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('reviews');
	}

}
