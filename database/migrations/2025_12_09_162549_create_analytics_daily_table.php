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
        Schema::create('analytics_daily', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('total_users')->default(0);
            $table->integer('new_users')->default(0);
            $table->integer('total_orders')->default(0);
            $table->decimal('total_revenue', 10, 2)->default(0);
            $table->integer('total_deal_views')->default(0);
            $table->integer('total_deal_clicks')->default(0);
            $table->integer('total_page_views')->default(0);
            $table->integer('total_sessions')->default(0);
            $table->decimal('average_session_duration', 8, 2)->default(0);
            $table->json('additional_metrics')->nullable();
            $table->timestamps();
            
            $table->unique('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics_daily');
    }
};
