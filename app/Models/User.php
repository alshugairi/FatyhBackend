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
        'first_name',
        'last_name',
        'nickname',
        'type',
        'email',
        'password',
        'country_code',
        'phone',
        'birthdate',
        'gender',
        'country_id',
        'city_id',
        'timezone',
        'wallet',
        'avatar',
        'status',
        'notify_email',
        'notify_sms',
        'notify_whatsapp',
        'verification_code',
        'verification_expires_at'
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
            'first_name' => 'string',
            'last_name' => 'string',
            'country_code' => 'string',
            'type' => 'string',
            'phone' => 'string',
            'birthdate' => 'date',
            'gender' => 'string',
            'avatar' => 'string',
            'wallet' => 'float',
            'timezone' => 'string',
            'status' => 'int',
            'country_id' => 'int',
            'city_id' => 'int',
            'notify_email' => 'bool',
            'notify_sms' => 'bool',
            'notify_whatsapp' => 'bool'
        ];
    }

    protected $appends = [
        'formatted_created_at'
    ];

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
}
