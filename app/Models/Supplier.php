<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Supplier extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, ModelAttributesTrait;

    protected $table = 'suppliers';

    public $translatable = ['name', 'company_name', 'address'];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'address',
        'image',
        'postal_code',
        'country_id',
        'city_id',
        'tax_id',
        'status',
        'additional_info',
        'creator_id',
        'editor_id',
    ];

    protected $casts = [
        'name' => 'array',
        'email' => 'string',
        'phone' => 'string',
        'company_name' => 'array',
        'additional_info' => 'json',
        'address' => 'string',
        'image' => 'string',
        'postal_code' => 'string',
        'country_id' => 'int',
        'city_id' => 'int',
        'tax_id' => 'string',
        'status' => 'int',
        'creator_id' => 'int',
        'editor_id' => 'int',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($supplier) {
            delete_file($supplier->image);
        });
    }

    public static function allSuppliers(): array
    {
        $arr = [];
        $data = self::get();
        foreach ($data as $model) {
            $arr[$model->id] = ucfirst($model->name);
        }
        return $arr;
    }
}
