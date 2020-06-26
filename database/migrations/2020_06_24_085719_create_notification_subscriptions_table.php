<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationSubscriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notification_subscriptions', function(Blueprint $table)
		{
			$table->char('id', 36)->primary();
			$table->string('notif_id', 3)->index();
			$table->integer('user_id')->index();
			$table->string('channels', 191);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notification_subscriptions');
	}

}
