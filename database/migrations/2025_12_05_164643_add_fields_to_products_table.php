<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'rating')) {
                $table->integer('rating')->default(0);
            }
            if (!Schema::hasColumn('products', 'old_price')) {
                $table->decimal('old_price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('products', 'badge')) {
                $table->string('badge')->nullable();
            }
            if (!Schema::hasColumn('products', 'img')) {
                $table->string('img')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['rating', 'old_price', 'badge', 'img']);
        });
    }
}
