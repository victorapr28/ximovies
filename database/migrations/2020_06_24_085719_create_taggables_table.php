<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaggablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taggables', function(Blueprint $table)
		{
			$table->integer('tag_id')->unsigned()->index();
			$table->integer('taggable_id')->unsigned()->index();
			$table->string('taggable_type', 80)->index();
			$table->integer('user_id')->unsigned()->nullable()->index();
			$table->unique(['tag_id','taggable_id','user_id','taggable_type']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('taggables');
	}

}
