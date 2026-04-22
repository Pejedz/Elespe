<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'total',
        'pay_total',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'total' => 'integer',
            'pay_total' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function getChangeAttribute(): int
    {
        return $this->pay_total - $this->total;
    }
}
