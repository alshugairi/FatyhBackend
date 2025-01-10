<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as PermissionModel;

class Permission extends PermissionModel
{
    use HasFactory, ModelAttributesTrait;

    protected $fillable = [
        'name',
        'guard_name'
    ];

    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'guard_name' => 'string',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'formatted_created_at'
    ];
}
