<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'deal_id')) {
                $table->foreignId('deal_id')->nullable()->after('user_id')->constrained('deals')->nullOnDelete();
            }
            if (! Schema::hasColumn('orders', 'merchant_id')) {
                $table->foreignId('merchant_id')->nullable()->after('deal_id')->constrained('merchants')->nullOnDelete();
            }
            if (! Schema::hasColumn('orders', 'quantity')) {
                $table->integer('quantity')->default(1)->after('merchant_id');
            }
            if (! Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('quantity');
            }
            if (Schema::hasColumn('orders', 'total') && ! Schema::hasColumn('orders', 'total_price')) {
                $table->decimal('total_price', 10, 2)->default(0)->after('payment_method');
            } elseif (! Schema::hasColumn('orders', 'total_price')) {
                $table->decimal('total_price', 10, 2)->default(0)->after('payment_method');
            }
            if (! Schema::hasColumn('orders', 'coupon_code')) {
                $table->string('coupon_code')->nullable()->after('total_price');
            }
            if (! Schema::hasColumn('orders', 'qr_code')) {
                $table->string('qr_code')->nullable()->after('coupon_code');
            }
            if (! Schema::hasColumn('orders', 'pin_code')) {
                $table->string('pin_code')->nullable()->after('qr_code');
            }
            if (! Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('pending')->after('pin_code');
            } else {
                $table->string('status')->default('pending')->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'deal_id')) {
                $table->dropForeign(['deal_id']);
                $table->dropColumn('deal_id');
            }
            if (Schema::hasColumn('orders', 'merchant_id')) {
                $table->dropForeign(['merchant_id']);
                $table->dropColumn('merchant_id');
            }
            foreach (['quantity','payment_method','total_price','coupon_code','qr_code','pin_code'] as $col) {
                if (Schema::hasColumn('orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};

