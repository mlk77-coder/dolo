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
        // Rename the table first
        if (Schema::hasTable('discounts') && ! Schema::hasTable('deals')) {
            Schema::rename('discounts', 'deals');
        }

        // Adjust schema to the new deals structure
        Schema::table('deals', function (Blueprint $table) {
            // Drop legacy discount columns if they still exist
            foreach (['code', 'type', 'value', 'min_purchase', 'usage_limit', 'used_count'] as $column) {
                if (Schema::hasColumn('deals', $column)) {
                    $table->dropColumn($column);
                }
            }

            // Ensure nullable foreign keys for now (merchants table will arrive in a later phase)
            if (! Schema::hasColumn('deals', 'merchant_id')) {
                $table->unsignedBigInteger('merchant_id')->nullable()->after('id');
            }

            if (! Schema::hasColumn('deals', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('merchant_id');
            }

            if (! Schema::hasColumn('deals', 'title_ar')) {
                $table->string('title_ar')->after('category_id');
            }

            if (! Schema::hasColumn('deals', 'title_en')) {
                $table->string('title_en')->after('title_ar');
            }

            if (! Schema::hasColumn('deals', 'original_price')) {
                $table->decimal('original_price', 10, 2)->after('title_en');
            }

            if (! Schema::hasColumn('deals', 'discounted_price')) {
                $table->decimal('discounted_price', 10, 2)->after('original_price');
            }

            if (! Schema::hasColumn('deals', 'discount_percentage')) {
                $table->decimal('discount_percentage', 5, 2)->after('discounted_price');
            }

            if (! Schema::hasColumn('deals', 'description')) {
                $table->text('description')->nullable()->after('discount_percentage');
            }

            if (! Schema::hasColumn('deals', 'city')) {
                $table->string('city')->nullable()->after('description');
            }

            // start_date / end_date already exist from legacy table; make sure they exist
            if (! Schema::hasColumn('deals', 'start_date')) {
                $table->dateTime('start_date')->nullable()->after('city');
            }

            if (! Schema::hasColumn('deals', 'end_date')) {
                $table->dateTime('end_date')->nullable()->after('start_date');
            }

            if (! Schema::hasColumn('deals', 'status')) {
                $table->string('status')->default('draft')->after('end_date');
            }

            if (! Schema::hasColumn('deals', 'featured')) {
                $table->boolean('featured')->default(false)->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Attempt to revert columns to legacy structure (best-effort)
        Schema::table('deals', function (Blueprint $table) {
            foreach (['merchant_id', 'category_id', 'title_ar', 'title_en', 'original_price', 'discounted_price', 'discount_percentage', 'description', 'city', 'status', 'featured'] as $column) {
                if (Schema::hasColumn('deals', $column)) {
                    $table->dropColumn($column);
                }
            }

            if (Schema::hasColumn('deals', 'start_date')) {
                $table->dateTime('start_date')->change();
            }

            if (Schema::hasColumn('deals', 'end_date')) {
                $table->dateTime('end_date')->change();
            }

            // Recreate legacy columns if needed
            if (! Schema::hasColumn('deals', 'code')) {
                $table->string('code')->unique()->nullable();
            }

            if (! Schema::hasColumn('deals', 'type')) {
                $table->enum('type', ['percentage', 'fixed'])->nullable();
            }

            if (! Schema::hasColumn('deals', 'value')) {
                $table->decimal('value', 10, 2)->nullable();
            }

            if (! Schema::hasColumn('deals', 'min_purchase')) {
                $table->decimal('min_purchase', 10, 2)->nullable();
            }

            if (! Schema::hasColumn('deals', 'usage_limit')) {
                $table->integer('usage_limit')->nullable();
            }

            if (! Schema::hasColumn('deals', 'used_count')) {
                $table->integer('used_count')->default(0);
            }
        });

        if (Schema::hasTable('deals') && ! Schema::hasTable('discounts')) {
            Schema::rename('deals', 'discounts');
        }
    }
};

