<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBillingPlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('billing_plans', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->decimal('amount', 13)->nullable();
			$table->string('currency', 191);
			$table->string('currency_symbol', 191)->default('$');
			$table->string('interval', 191)->default('month');
			$table->integer('interval_count')->default(1);
			$table->integer('parent_id')->nullable();
			$table->text('legacy_permissions', 65535)->nullable();
			$table->char('uuid', 36);
			$table->string('paypal_id', 50)->nullable();
			$table->boolean('recommended')->default(0);
			$table->boolean('free')->default(0);
			$table->boolean('show_permissions')->default(0);
			$table->text('features', 65535)->nullable();
			$table->integer('position')->default(0);
			$table->timestamps();
			$table->bigInteger('available_space')->unsigned()->nullable();
			$table->boolean('hidden')->default(0)->index();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('billing_plans');
	}

}
