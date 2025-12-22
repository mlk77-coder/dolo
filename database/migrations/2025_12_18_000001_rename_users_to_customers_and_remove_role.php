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
        // Add is_admin column to mark admin users before removing role
        if (!Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_admin')->default(false)->after('email');
            });
        }

        // Mark existing admin users - check if role column exists first
        if (Schema::hasColumn('users', 'role')) {
            // Mark users with role = 'admin'
            DB::table('users')
                ->where('role', 'admin')
                ->update(['is_admin' => true]);
        }
        
        // Also mark users with 'admin' in email (regardless of role column)
        DB::table('users')
            ->where('email', 'like', '%admin%')
            ->update(['is_admin' => true]);

        // Remove role column if it exists
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }

        // Rename table from users to customers
        Schema::rename('users', 'customers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename table back
        Schema::rename('customers', 'users');

        // Add role column back
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('email');
        });

        // Restore role from is_admin
        DB::table('users')
            ->where('is_admin', true)
            ->update(['role' => 'admin']);

        // Remove is_admin column
        if (Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_admin');
            });
        }
    }
};

