<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomDomainsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('custom_domains', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('host', 100)->unique();
			$table->integer('user_id')->index();
			$table->timestamps();
			$table->boolean('global')->default(0)->index();
			$table->integer('resource_id')->unsigned()->nullable()->index();
			$table->string('resource_type', 20)->nullable()->index();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('custom_domains');
	}

}
