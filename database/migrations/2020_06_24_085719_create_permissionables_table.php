<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permissionables', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('permission_id')->index();
			$table->integer('permissionable_id')->index();
			$table->string('permissionable_type', 40)->index();
			$table->text('restrictions', 65535)->nullable();
			$table->unique(['permission_id','permissionable_id','permissionable_type'], 'permissionable_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('permissionables');
	}

}
