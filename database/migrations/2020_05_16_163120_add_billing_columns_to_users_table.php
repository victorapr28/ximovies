<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBillingColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasColumn('users', 'card_brand')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('card_brand')->nullable();
            });
        }

        if ( ! Schema::hasColumn('users', 'card_last_four')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('card_last_four')->nullable();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
