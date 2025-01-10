<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PlatformType;
use App\Traits\ModelAttributesTrait;
use Illuminate\{Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\Relations\BelongsTo,
    Database\Eloquent\Relations\HasMany,
    Database\Eloquent\SoftDeletes};

class Order extends Model
{
    use HasFactory, SoftDeletes, ModelAttributesTrait;

    protected $fillable = [
        'number',
        'user_id',
        'customer_email',
        'customer_name',
        'customer_phone',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_country',
        'billing_postcode',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_country',
        'shipping_postcode',
        'subtotal',
        'shipping_cost',
        'tax',
        'discount',
        'discount_code',
        'total',
        'payment_status',
        'payment_method',
        'payment_id',
        'paid_amount',
        'status',
        'payment_session_id',
        'shipping_method',
        'tracking_number',
        'shipping_metadata',
        'customer_notes',
        'admin_notes',
        'platform',
        'creator_id'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'customer_email' => 'string',
        'customer_name' => 'string',
        'customer_phone' => 'string',
        'billing_address' => 'string',
        'billing_city' => 'string',
        'billing_state' => 'string',
        'billing_country' => 'string',
        'billing_postcode' => 'string',
        'shipping_address' => 'string',
        'shipping_city' => 'string',
        'shipping_state' => 'string',
        'shipping_country' => 'string',
        'shipping_postcode' => 'string',
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'discount_code' => 'string',
        'total' => 'decimal:2',
        'payment_status' => 'string',
        'payment_method' => 'string',
        'payment_id' => 'string',
        'paid_amount' => 'decimal:2',
        'status' => OrderStatus::class,
        'payment_session_id' => 'string',
        'shipping_method' => 'string',
        'tracking_number' => 'string',
        'shipping_metadata' => 'array',
        'customer_notes' => 'string',
        'admin_notes' => 'string',
        'platform' => PlatformType::class,
        'creator_id' => 'string'
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
