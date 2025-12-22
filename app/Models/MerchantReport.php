<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MerchantReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'report_date',
        'total_orders',
        'total_deals',
        'total_revenue',
        'total_views',
        'total_clicks',
        'conversion_rate',
        'details',
    ];

    protected $casts = [
        'report_date' => 'date',
        'total_orders' => 'integer',
        'total_deals' => 'integer',
        'total_revenue' => 'decimal:2',
        'total_views' => 'integer',
        'total_clicks' => 'integer',
        'conversion_rate' => 'decimal:2',
        'details' => 'array',
    ];

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }
}

