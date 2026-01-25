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
        Schema::table('codes', function (Blueprint $table) {
            // Drop category and description columns if they exist
            if (Schema::hasColumn('codes', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('codes', 'description')) {
                $table->dropColumn('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('codes', function (Blueprint $table) {
            $table->string('category')->nullable();
            $table->text('description')->nullable();
        });
    }
};
