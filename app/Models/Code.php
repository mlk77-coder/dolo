<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    protected $table = 'codes';

    protected $fillable = [
        'subject',
        'code',
        'discount_amount',
        'valid_to',
        'is_active',
        'image',
        'external_url',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'valid_to' => 'date',
    ];
}

