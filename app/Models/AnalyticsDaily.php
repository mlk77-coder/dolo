<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticsDaily extends Model
{
    use HasFactory;

    protected $table = 'analytics_daily';

    protected $fillable = [
        'date',
        'total_users',
        'new_users',
        'total_orders',
        'total_revenue',
        'total_deal_views',
        'total_deal_clicks',
        'total_page_views',
        'total_sessions',
        'average_session_duration',
        'additional_metrics',
    ];

    protected $casts = [
        'date' => 'date',
        'total_users' => 'integer',
        'new_users' => 'integer',
        'total_orders' => 'integer',
        'total_revenue' => 'decimal:2',
        'total_deal_views' => 'integer',
        'total_deal_clicks' => 'integer',
        'total_page_views' => 'integer',
        'total_sessions' => 'integer',
        'average_session_duration' => 'decimal:2',
        'additional_metrics' => 'array',
    ];
}

