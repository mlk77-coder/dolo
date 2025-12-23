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
        Schema::table('customers', function (Blueprint $table) {
            // Add surname field after name (nullable for existing records)
            if (!Schema::hasColumn('customers', 'surname')) {
                $table->string('surname')->nullable()->after('name');
            }
            
            // Add phone field (unique, Syrian format, nullable for existing records)
            if (!Schema::hasColumn('customers', 'phone')) {
                $table->string('phone', 10)->nullable()->unique()->after('surname');
            }
            
            // Make email nullable
            $table->string('email')->nullable()->change();
            
            // Add date_of_birth field (nullable for existing records)
            if (!Schema::hasColumn('customers', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('email');
            }
            
            // Add gender field (enum: male, female, nullable for existing records)
            if (!Schema::hasColumn('customers', 'gender')) {
                $table->enum('gender', ['male', 'female'])->nullable()->after('date_of_birth');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Remove added columns
            $table->dropColumn(['surname', 'phone', 'date_of_birth', 'gender']);
            
            // Make email required again
            $table->string('email')->nullable(false)->change();
        });
    }
};
