<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (! Schema::hasColumn('categories', 'name_en')) {
                $table->string('name_en')->after('id')->nullable();
            }
            if (! Schema::hasColumn('categories', 'name_ar')) {
                $table->string('name_ar')->after('name_en')->nullable();
            }
            if (! Schema::hasColumn('categories', 'icon')) {
                $table->string('icon')->nullable()->after('slug');
            }
            // Backfill name_en from existing name if present
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'name_en')) {
                $table->dropColumn('name_en');
            }
            if (Schema::hasColumn('categories', 'name_ar')) {
                $table->dropColumn('name_ar');
            }
            if (Schema::hasColumn('categories', 'icon')) {
                $table->dropColumn('icon');
            }
        });
    }
};

