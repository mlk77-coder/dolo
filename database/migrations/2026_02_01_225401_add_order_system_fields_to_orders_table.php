<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add new fields for order system
            if (!Schema::hasColumn('orders', 'unit_price')) {
                $table->decimal('unit_price', 10, 2)->after('quantity');
            }
            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->decimal('discount_amount', 10, 2)->default(0)->after('total_price');
            }
            if (!Schema::hasColumn('orders', 'final_price')) {
                $table->decimal('final_price', 10, 2)->after('discount_amount');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'order_status')) {
                $table->string('order_status')->default('pending')->after('payment_status');
            }
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('order_status');
            }
            if (!Schema::hasColumn('orders', 'estimated_delivery')) {
                $table->timestamp('estimated_delivery')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('orders', 'cancelled_at')) {
                $table->timestamp('cancelled_at')->nullable()->after('estimated_delivery');
            }
            if (!Schema::hasColumn('orders', 'cancellation_reason')) {
                $table->text('cancellation_reason')->nullable()->after('cancelled_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = [
                'unit_price',
                'discount_amount',
                'final_price',
                'payment_status',
                'order_status',
                'notes',
                'estimated_delivery',
                'cancelled_at',
                'cancellation_reason'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
