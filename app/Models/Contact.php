<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory, ModelAttributesTrait;

    protected $table = 'contact';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'subject',
        'message',
        'platform'
    ];

    protected $casts = [
        'name' => 'string',
        'phone' => 'string',
        'email' => 'string',
        'subject' => 'string',
        'message' => 'string',
    ];

    protected $appends = [
        'formatted_created_at'
    ];
}
