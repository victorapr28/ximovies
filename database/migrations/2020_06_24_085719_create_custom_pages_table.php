<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomPagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('custom_pages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title', 191)->nullable();
			$table->text('body');
			$table->string('slug', 191)->unique('pages_slug_unique');
			$table->text('meta', 65535)->nullable();
			$table->string('type', 20)->default('default')->index('pages_type_index');
			$table->timestamps();
			$table->integer('user_id')->nullable()->index('pages_user_id_index');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('custom_pages');
	}

}
