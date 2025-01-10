<?php

namespace App\Models;

use App\Enums\PurchaseStatus;
use App\Traits\ModelAttributesTrait;
use Illuminate\{Database\Eloquent\Factories\HasFactory, Database\Eloquent\Model, Database\Eloquent\SoftDeletes};

class Purchase extends Model
{
    use HasFactory, SoftDeletes, ModelAttributesTrait;

    protected $fillable = [
        'number',
        'supplier_id',
        'date',
        'expected_date',
        'delivery_date',
        'status',
        'subtotal',
        'tax',
        'shipping',
        'total',
        'paid_amount',
        'notes',
        'image',
        'creator_id',
    ];

    protected $casts = [
        'number' => 'string',
        'supplier_id' => 'integer',
        'date' => 'string',
        'expected_date' => 'date',
        'delivery_date' => 'date',
        'status' => PurchaseStatus::class,
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'notes' => 'string',
        'image' => 'string',
        'creator_id' => 'integer',
    ];

    protected $appends = [
        'formatted_created_at', 'formatted_date'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function scopeWithDraftStatus($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeWithOrderedStatus($query)
    {
        return $query->where('status', 'ordered');
    }

    public function scopeWithReceivedStatus($query)
    {
        return $query->where('status', 'received');
    }
}
