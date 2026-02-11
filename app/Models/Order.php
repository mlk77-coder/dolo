<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'deal_id',
        'merchant_id',
        'order_number',
        'quantity',
        'unit_price',
        'payment_method',
        'total',
        'total_price',
        'discount_amount',
        'final_price',
        'payment_status',
        'order_status',
        'notes',
        'estimated_delivery',
        'cancelled_at',
        'cancellation_reason',
        'coupon_code',
        'qr_code',
        'pin_code',
        'status',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_price' => 'decimal:2',
        'quantity' => 'integer',
        'estimated_delivery' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(Str::random(10));
            }
        });
    }

    /**
     * Get the customer that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Customer::class, 'user_id');
    }

    /**
     * Alias for user() - Get the customer that owns the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Customer::class, 'user_id');
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Get all items for this order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the status history for this order.
     */
    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    /**
     * Add a status to the order history.
     */
    public function addStatusHistory(string $status, ?string $note = null): void
    {
        $this->statusHistory()->create([
            'status' => $status,
            'note' => $note,
        ]);
    }

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber(): string
    {
        $year = date('Y');
        $lastOrder = static::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        $nextNumber = $lastOrder ? ((int) substr($lastOrder->order_number, -5)) + 1 : 1;
        
        return sprintf('ORD-%s-%05d', $year, $nextNumber);
    }
}
