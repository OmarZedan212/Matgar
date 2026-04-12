<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStoreFieldsToSellersTable extends Migration
{
    public function up(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            // مثال للحقول الجديدة (من الفورم اللي عندك)
            $table->string('business_email')->nullable()->after('description');
            $table->string('support_phone')->nullable()->after('business_email');
            $table->string('address')->nullable()->after('support_phone');
            $table->string('facebook_page')->nullable()->after('address');
            $table->string('instagram_profile')->nullable()->after('facebook_page');
        });
    }

    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn([
                'business_email',
                'support_phone',
                'address',
                'facebook_page',
                'instagram_profile',
            ]);
        });
    }
}
