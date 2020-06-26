<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMailTemplatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mail_templates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('display_name', 191)->nullable();
			$table->string('file_name', 191)->unique();
			$table->string('subject', 191)->nullable();
			$table->boolean('markdown')->default(0);
			$table->string('action', 191)->nullable()->unique();
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
		Schema::drop('mail_templates');
	}

}
