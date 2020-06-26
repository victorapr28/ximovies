<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('content', 65535);
			$table->integer('parent_id')->unsigned()->nullable()->index();
			$table->string('path', 191)->index();
			$table->integer('user_id')->unsigned()->index();
			$table->integer('commentable_id')->unsigned()->index();
			$table->string('commentable_type', 30)->index();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comments');
	}

}
