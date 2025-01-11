<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasRoles,HasApiTokens, ModelAttributesTrait;

    public const TokenName = 'Project Token';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'business_id',
        'name',
        'type',
        'email',
        'password',
        'country_code',
        'phone',
        'country_id',
        'city_id',
        'timezone',
        'wallet',
        'avatar',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'name' => 'string',
            'country_code' => 'string',
            'type' => 'string',
            'phone' => 'string',
            'avatar' => 'string',
            'wallet' => 'float',
            'timezone' => 'string',
            'status' => 'int',
            'country_id' => 'int',
            'city_id' => 'int',
        ];
    }

    protected $appends = [
        'formatted_created_at'
    ];

    /**
     * @return Attribute
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            set: static fn($value) => bcrypt($value)
        );
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
}
