<?php

namespace App\Models;

use Illuminate\{Database\Eloquent\Factories\HasFactory, Database\Eloquent\Model};

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status',
        'comment',
        'notify_customer',
        'creator_id',
    ];

    protected $casts = [
        'order_id' => 'integer',
        'status' => 'string',
        'comment' => 'string',
        'notify_customer' => 'boolean',
        'creator_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
