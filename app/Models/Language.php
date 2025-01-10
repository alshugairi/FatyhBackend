<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use HasFactory, SoftDeletes, ModelAttributesTrait;

    protected $table = 'languages';
    protected $fillable = [
        'name',
        'code',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'name' => 'string',
        'code' => 'string',
        'status' => 'boolean',
        'created_by'  => 'int',
        'updated_by'  => 'int',
    ];

    protected $appends = [
        'formatted_created_at'
    ];
}
