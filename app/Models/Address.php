<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, SoftDeletes};

class Address extends Model
{
    use HasFactory, SoftDeletes,ModelAttributesTrait;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'email',
        'address_type',
        'country_id',
        'city_id',
        'address_line_1',
        'address_line_2',
        'postal_code',
        'is_default',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'country_id' => 'integer',
        'city_id' => 'integer',
        'is_default' => 'boolean',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
