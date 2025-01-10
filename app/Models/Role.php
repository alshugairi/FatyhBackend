<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as RoleModel;

class Role extends RoleModel
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

    /**
     * @return string
     */
    final public static function IDField(): string
    {
        return (new self)->primaryKey;
    }

    /**
     * @return array
     */
    public static function allRoles(): array
    {
        $roles = [];
        $data = self::get();
        foreach ($data as $role) {
            $roles[$role->name] = ucfirst($role->name);
        }
        return $roles;
    }
}
