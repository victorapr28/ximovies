<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSocialProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('social_profiles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->index();
			$table->string('service_name', 20);
			$table->string('user_service_id', 191);
			$table->string('username', 191)->nullable();
			$table->timestamps();
			$table->unique(['service_name','user_service_id']);
			$table->unique(['user_id','service_name']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('social_profiles');
	}

}
