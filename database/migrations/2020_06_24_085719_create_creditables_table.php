<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCreditablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('creditables', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('person_id')->unsigned()->index('actors_titles_actor_id_index');
			$table->bigInteger('creditable_id')->unsigned()->index('actors_titles_title_id_index');
			$table->string('character', 191)->nullable();
			$table->integer('order')->unsigned()->default(0)->index();
			$table->string('department', 100)->nullable();
			$table->string('job', 100)->nullable();
			$table->string('creditable_type', 50)->nullable()->index();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('creditables');
	}

}
