<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            if (Schema::hasColumn('deals', 'merchant_id')) {
                $table->foreign('merchant_id')->references('id')->on('merchants')->nullOnDelete();
            }
            if (Schema::hasColumn('deals', 'category_id')) {
                $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->dropForeign(['merchant_id']);
            $table->dropForeign(['category_id']);
        });
    }
};

