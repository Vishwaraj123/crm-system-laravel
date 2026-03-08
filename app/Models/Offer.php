<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number',
        'year',
        'content',
        'date',
        'expired_date',
        'client_id',
        'tax_rate',
        'sub_total',
        'tax_total',
        'total',
        'credit',
        'currency',
        'discount',
        'notes',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'expired_date' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OfferItem::class);
    }
}
