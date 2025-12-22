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
        Schema::create('merchant_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade');
            $table->date('report_date');
            $table->integer('total_orders')->default(0);
            $table->integer('total_deals')->default(0);
            $table->decimal('total_revenue', 10, 2)->default(0);
            $table->integer('total_views')->default(0);
            $table->integer('total_clicks')->default(0);
            $table->decimal('conversion_rate', 5, 2)->default(0);
            $table->json('details')->nullable(); // Additional report data
            $table->timestamps();
            
            $table->unique(['merchant_id', 'report_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_reports');
    }
};
