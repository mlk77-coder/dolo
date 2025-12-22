<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->string('sku')->nullable()->after('title_en');
            $table->integer('buyer_counter')->default(0)->after('discount_percentage');
            $table->boolean('show_buyer_counter')->default(true)->after('buyer_counter');
            $table->boolean('show_savings_percentage')->default(true)->after('show_buyer_counter');
            $table->text('deal_information')->nullable()->after('description');
            $table->string('video_url')->nullable()->after('deal_information');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->dropColumn([
                'sku',
                'buyer_counter',
                'show_buyer_counter',
                'show_savings_percentage',
                'deal_information',
                'video_url'
            ]);
        });
    }
};
