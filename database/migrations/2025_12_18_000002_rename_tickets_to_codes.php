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
        // Check if tickets table exists
        if (Schema::hasTable('tickets')) {
            // First, add new columns to tickets table before renaming
            Schema::table('tickets', function (Blueprint $table) {
                // Add new columns if they don't exist
                if (!Schema::hasColumn('tickets', 'image')) {
                    $table->string('image')->nullable()->after('description');
                }
                
                if (!Schema::hasColumn('tickets', 'external_url')) {
                    $table->string('external_url')->nullable()->after('image');
                }
                
                if (!Schema::hasColumn('tickets', 'code')) {
                    $table->string('code')->nullable()->after('external_url');
                }
            });
            
            // Rename user_id to customer_id using raw SQL (more reliable)
            if (Schema::hasColumn('tickets', 'user_id')) {
                // Get foreign key constraint name
                $foreignKeys = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'tickets' 
                    AND COLUMN_NAME = 'user_id' 
                    AND REFERENCED_TABLE_NAME IS NOT NULL
                ");
                
                // Drop foreign key if exists
                foreach ($foreignKeys as $fk) {
                    try {
                        DB::statement("ALTER TABLE `tickets` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
                    } catch (\Exception $e) {
                        // Foreign key might not exist
                    }
                }
                
                // Rename column
                DB::statement('ALTER TABLE `tickets` CHANGE `user_id` `customer_id` BIGINT UNSIGNED NOT NULL');
                
                // Add new foreign key constraint (only if customers table exists)
                if (Schema::hasTable('customers')) {
                    try {
                        DB::statement('ALTER TABLE `tickets` ADD CONSTRAINT `tickets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE');
                    } catch (\Exception $e) {
                        // Constraint might already exist
                    }
                }
            }
            
            // Rename table
            Schema::rename('tickets', 'codes');
        } else {
            // Create codes table if tickets doesn't exist
            Schema::create('codes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
                $table->string('subject');
                $table->string('category')->nullable();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->string('external_url')->nullable();
                $table->string('code')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('codes')) {
            Schema::table('codes', function (Blueprint $table) {
                if (Schema::hasColumn('codes', 'customer_id')) {
                    $table->renameColumn('customer_id', 'user_id');
                }
                
                if (Schema::hasColumn('codes', 'image')) {
                    $table->dropColumn('image');
                }
                
                if (Schema::hasColumn('codes', 'external_url')) {
                    $table->dropColumn('external_url');
                }
                
                if (Schema::hasColumn('codes', 'code')) {
                    $table->dropColumn('code');
                }
            });
            
            Schema::rename('codes', 'tickets');
        }
    }
};

