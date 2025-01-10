<?php

namespace App\Models;

use App\Enums\TransactionType;
use App\Traits\ModelAttributesTrait;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use SoftDeletes, ModelAttributesTrait;

    protected $fillable = [
        'number',
        'type',
        'reference_type',
        'reference_id',
        'amount',
        'balance',
        'payment_method',
        'details',
        'notes',
        'creator_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'type' => 'string',
        'reference_type' => TransactionType::class,
        'details' => 'json',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForAccount($query, $accountId)
    {
        return $query->where('account_id', $accountId);
    }

    public function getFormattedAmountAttribute(): string
    {
        return format_currency($this->amount);
    }

    public function getFormattedBalanceAttribute(): string
    {
        return format_currency($this->balance);
    }

    public function isDebit(): bool
    {
        return TransactionType::getType($this->type) === 'debit';
    }

    public function isCredit(): bool
    {
        return TransactionType::getType($this->type) === 'credit';
    }
}
