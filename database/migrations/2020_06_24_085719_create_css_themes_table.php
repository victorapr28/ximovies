<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCssThemesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('css_themes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 100)->unique();
			$table->boolean('is_dark')->default(0);
			$table->boolean('default_light')->default(0)->index();
			$table->boolean('default_dark')->default(0)->index();
			$table->integer('user_id')->index();
			$table->text('colors', 65535);
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
		Schema::drop('css_themes');
	}

}
