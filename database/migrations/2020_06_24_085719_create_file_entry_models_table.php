<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFileEntryModelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('file_entry_models', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('file_entry_id')->unsigned();
			$table->integer('model_id')->unsigned();
			$table->string('model_type', 60);
			$table->timestamps();
			$table->boolean('owner')->default(0)->index();
			$table->text('permissions', 65535)->nullable();
			$table->unique(['file_entry_id','model_id','model_type'], 'uploadables_upload_id_uploadable_id_uploadable_type_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('file_entry_models');
	}

}
