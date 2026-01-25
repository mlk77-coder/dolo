<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all foreign keys on codes table
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'codes' 
            AND COLUMN_NAME = 'customer_id' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");
        
        // Drop each foreign key
        foreach ($foreignKeys as $fk) {
            try {
                DB::statement("ALTER TABLE `codes` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
            } catch (\Exception $e) {
                // Foreign key might not exist
            }
        }
        
        // Drop the column if it exists
        if (Schema::hasColumn('codes', 'customer_id')) {
            Schema::table('codes', function (Blueprint $table) {
                $table->dropColumn('customer_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('codes', function (Blueprint $table) {
            // Add back customer_id column
            $table->foreignId('customer_id')->nullable()->after('id')->constrained('customers')->onDelete('cascade');
        });
    }
};
