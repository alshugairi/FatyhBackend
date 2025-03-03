<?php

namespace App\Models;

use App\Traits\ModelAttributesTrait;
use Carbon\Carbon;
use Illuminate\{Database\Eloquent\Casts\Attribute,
    Database\Eloquent\Factories\HasFactory,
    Database\Eloquent\Model,
    Database\Eloquent\Relations\BelongsTo,
    Database\Eloquent\Builder,
    Database\Eloquent\SoftDeletes,
    Support\Facades\DB};
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, ModelAttributesTrait;

    protected $table = 'products';

    public $translatable = [
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected $fillable = [
        'business_id',
        'name',
        'sku',
        'slug',
        'description',
        'status',
        'is_featured',
        'barcode',
        'sell_price',
        'purchase_price',
        'discount_price',
        'cost_price',
        'stock_quantity',
        'has_variants',
        'category_id',
        'brand_id',
        'parent_product_id',
        'rating',
        'image',
        'gallery_images',
        'favourites_count',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'creator_id',
        'editor_id'
    ];

    protected $casts = [
        'business_id' => 'integer',
        'name' => 'array',
        'sku' => 'string',
        'slug' => 'string',
        'description' => 'array',
        'status' => 'integer',
        'is_featured' => 'integer',
        'barcode' => 'string',
        'sell_price' => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'has_variants' => 'bool',
        'category_id' => 'integer',
        'brand_id' => 'integer',
        'parent_product_id' => 'integer',
        'rating' => 'decimal:1',
        'image' => 'string',
        'gallery_images' => 'array',
        'favourites_count' => 'integer',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'meta_keywords' => 'array',
        'creator_id' => 'integer',
        'editor_id' => 'integer',
    ];

    protected $appends = [
        'formatted_created_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            if ($product->image) {
                delete_file($product->image);
            }
        });
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function parentProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'parent_product_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    public function defaultImage()
    {
        return $this->hasOne(ProductImage::class)->orderBy('position');
    }

    public function videos()
    {
        return $this->hasMany(ProductVideo::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function reviewsCount()
    {
        return $this->reviews()->count();
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishlistCount()
    {
        return $this->wishlist()->count();
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function stockReservations()
    {
        return $this->hasMany(StockReservation::class);
    }

    public function stockAlerts()
    {
        return $this->hasMany(StockAlert::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeWithWishlists(Builder $query, string $joinType = 'leftJoin'):?Builder
    {
        $joinMethod = $joinType === 'join' ? 'join' : 'leftJoin';

        return $query->$joinMethod('wishlists', function ($join) {
            $join->on('wishlists.product_id', '=', 'products.id');

            if (auth()->check()) {
                $join->where('wishlists.user_id', auth()->id());
            } else {
                $join->where('wishlists.user_id', -1);
            }
        })
        ->select('products.*', DB::raw('(CASE WHEN wishlists.id is not null THEN 1 ELSE 0 END) as is_wishlist'));
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public static function getAll(): array
    {
        $products = [];
        $data = self::all();
        foreach ($data as $product) {
            $products[$product->id] = ucfirst($product->name);
        }
        return $products;
    }

    public function scopeLowStock($query, $threshold = null)
    {
        return $query->whereColumn('stock_quantity', '<=', $threshold ?? 'alert_threshold');
    }

    public function updateStock(int $quantity, string $type, string $referenceType = null, string $referenceId = null, array $metadata = [])
    {
        $quantityBefore = $this->stock_quantity;
        $quantityAfter = $quantityBefore + $quantity;

        $this->stock_quantity = $quantityAfter;
        $this->save();

        return $this->stockMovements()->create([
            'type' => $type,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'quantity_change' => $quantity,
            'quantity_before' => $quantityBefore,
            'quantity_after' => $quantityAfter,
            'metadata' => $metadata,
            'movement_date' => now(),
            'creator_id' => auth()->id()
        ]);
    }

    public function reserve(int $quantity, string $reservationType, string $referenceId, ?\DateTime $expiresAt = null)
    {
        if ($this->getAvailableStock() < $quantity) {
            throw new \Exception('Insufficient stock for reservation');
        }

        return $this->stockReservations()->create([
            'reservation_type' => $reservationType,
            'reference_id' => $referenceId,
            'quantity' => $quantity,
            'expires_at' => $expiresAt
        ]);
    }

    public function getAvailableStock(): int
    {
        $reservedQuantity = $this->stockReservations()
            ->whereNull('released_at')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->sum('quantity');

        return $this->stock_quantity - $reservedQuantity;
    }

    public static function allProducts(): array
    {
        $arr = [];
        $data = self::get();
        foreach ($data as $model) {
            $arr[$model->id] = ucfirst($model->name);
        }
        return $arr;
    }
}
