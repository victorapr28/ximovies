<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFileEntriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('file_entries', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191)->index('uploads_name_index');
			$table->string('file_name', 50)->unique('uploads_file_name_unique');
			$table->bigInteger('file_size')->unsigned()->default(0);
			$table->string('mime', 100)->nullable();
			$table->string('extension', 10)->nullable();
			$table->string('user_id', 191)->nullable()->index('uploads_user_id_index');
			$table->timestamps();
			$table->boolean('public')->default(0)->index('uploads_public_index');
			$table->string('disk_prefix', 191)->nullable();
			$table->integer('parent_id')->nullable()->index();
			$table->string('description', 150)->nullable()->index();
			$table->string('password', 50)->nullable();
			$table->string('type', 20)->nullable()->index();
			$table->softDeletes()->index();
			$table->string('path', 191)->nullable()->index();
			$table->string('preview_token', 15)->nullable();
			$table->boolean('thumbnail')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('file_entries');
	}

}
