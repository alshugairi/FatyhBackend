<?php

namespace App\Models;

use Illuminate\{Database\Eloquent\Factories\HasFactory, Database\Eloquent\Model};

class OrderPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
        'payment_data',
    ];

    protected $casts = [
        'order_id' => 'integer',
        'amount' => 'decimal:2',
        'payment_method' => 'string',
        'transaction_id' => 'string',
        'status' => 'string',
        'payment_data' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
