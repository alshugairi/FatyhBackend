<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};

class Comparison extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id'
    ];

    protected $casts = [
        'user_id' => 'int',
        'session_id' => 'string',
        'product_id' => 'int',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
