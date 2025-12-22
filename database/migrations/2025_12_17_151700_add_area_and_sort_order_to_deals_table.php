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
            if (!Schema::hasColumn('deals', 'area')) {
                $table->string('area')->nullable()->after('city');
            }
            if (!Schema::hasColumn('deals', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('area');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deals', function (Blueprint $table) {
            if (Schema::hasColumn('deals', 'area')) {
                $table->dropColumn('area');
            }
            if (Schema::hasColumn('deals', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }
};
