<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersNameColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop first_name and last_name
            $table->dropColumn(['first_name', 'last_name']);

            // Add a single name column
            $table->string('name')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add first_name and last_name back
            $table->string('first_name')->after('user_id');
            $table->string('last_name')->after('first_name');

            // Drop name column
            $table->dropColumn('name');
        });
    }
}
