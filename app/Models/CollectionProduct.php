<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Illuminate\{Database\Eloquent\Factories\HasFactory, Database\Eloquent\Model, Database\Eloquent\Relations\BelongsTo};

class CollectionProduct extends Model
{
    use HasFactory, ModelAttributesTrait;

    protected $table = 'collection_products';

    protected $fillable = [
        'collection_id',
        'product_id',
        'creator_id'
    ];

    protected $casts = [
        'collection_id' => 'int',
        'product_id' => 'int',
        'creator_id' => 'int',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(CollectionModel::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
