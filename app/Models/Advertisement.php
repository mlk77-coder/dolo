<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'link_url',
        'position',
        'start_date',
        'end_date',
        'clicks',
        'views',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'clicks' => 'integer',
        'views' => 'integer',
        'sort_order' => 'integer',
    ];

    public function isActive(): bool
    {
        $now = Carbon::now();
        return ($this->status === 'active')
            && (!$this->start_date || $now->gte($this->start_date))
            && (!$this->end_date || $now->lte($this->end_date));
    }
}

