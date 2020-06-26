<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubscriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscriptions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('plan_id', 191);
			$table->string('gateway', 191)->default('none')->index();
			$table->string('gateway_id', 191)->default('none');
			$table->integer('quantity')->default(1);
			$table->text('description', 65535)->nullable();
			$table->dateTime('trial_ends_at')->nullable();
			$table->dateTime('ends_at')->nullable();
			$table->dateTime('renews_at')->nullable();
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
		Schema::drop('subscriptions');
	}

}
