<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username', 191)->nullable()->index();
			$table->string('first_name', 191)->nullable();
			$table->string('last_name', 191)->nullable();
			$table->string('avatar_url', 191)->nullable();
			$table->string('gender', 191)->nullable();
			$table->text('legacy_permissions', 65535)->nullable();
			$table->string('email', 191)->unique();
			$table->string('password', 60)->nullable();
			$table->string('api_token', 80)->nullable()->unique();
			$table->string('card_brand', 191)->nullable();
			$table->string('card_last_four', 191)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->string('background', 191)->nullable();
			$table->boolean('confirmed')->default(1);
			$table->string('confirmation_code', 191)->nullable();
			$table->string('language', 191)->nullable();
			$table->string('country', 191)->nullable();
			$table->string('timezone', 191)->nullable();
			$table->string('avatar', 191)->nullable();
			$table->string('stripe_id', 191)->nullable();
			$table->bigInteger('available_space')->unsigned()->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
