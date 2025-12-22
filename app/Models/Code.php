<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Code extends Model
{
    use HasFactory;

    protected $table = 'codes';

    protected $fillable = [
        'customer_id',
        'subject',
        'category',
        'description',
        'image',
        'external_url',
        'code',
    ];

    protected $casts = [
        'customer_id' => 'integer',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Alias for backward compatibility
    public function user(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

