<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'category_id',
        'title_ar',
        'title_en',
        'sku',
        'original_price',
        'discounted_price',
        'discount_percentage',
        'buyer_counter',
        'quantity',
        'show_buyer_counter',
        'show_savings_percentage',
        'description',
        'deal_information',
        'video_url',
        'city',
        'area',
        'location_name',
        'latitude',
        'longitude',
        'sort_order',
        'start_date',
        'end_date',
        'status',
        'featured',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'buyer_counter' => 'integer',
        'quantity' => 'integer',
        'show_buyer_counter' => 'boolean',
        'show_savings_percentage' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'featured' => 'boolean',
    ];

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(DealImage::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isActive(): bool
    {
        $now = Carbon::now();
        return ($this->status === 'active')
            && $this->start_date
            && $this->end_date
            && $now->between($this->start_date, $this->end_date);
    }
}

