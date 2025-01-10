<?php

namespace App\Pipelines\Catalog;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductFilterPipeline
{
    /**
     * @param Request $request
     */
    public function __construct(private readonly Request $request)
    {

    }

    public function handle($query, \Closure $next): mixed
    {
        $theQuery = $next($query);
        if($this->request->filled('name') || $this->request->filled('q')) {
            $searchTerm = strtolower($this->request->name ?? $this->request->q);

            $theQuery->where(function ($query) use ($searchTerm) {
                foreach (get_languages() as $language) {
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.\"{$language->code}\"'))) LIKE ?", ["%{$searchTerm}%"]);
                    // can search tea,Tea,TEA
                }
            });
        }

//        if($this->request->filled('categoryIds')) {
//            $theQuery->whereIn('products.category_id', $this->request->categoryIds);
//        }
        if($this->request->filled('category')) {
            $inputCategory = $this->request->category;

            if (is_string($inputCategory)) {
                $catIds = explode(',', $this->request->category);
            } elseif (is_array($inputCategory)) {
                $catIds = $inputCategory;
            }
            $theQuery->whereIn('products.category_id', $catIds);
        }
        if($this->request->filled('category_id')) {
            $theQuery->where('products.category_id', $this->request->category_id);
        }
        if($this->request->filled('brand_id')) {
            $theQuery->where('products.brand_id', $this->request->brand_id);
        }
        if($this->request->filled('brand')) {
            $brandsIds = explode(',', $this->request->brand);
            $theQuery->whereIn('products.brand_id', $brandsIds);
        }
        if($this->request->filled('is_featured')) {
            $theQuery->where('products.is_featured', $this->request->is_featured);
        }
        if($this->request->filled('arrival_date')) {
            $theQuery->whereDate('products.created_at', '>=', $this->request->arrival_date);
        }
        if ($this->request->filled('min_price') || $this->request->filled('max_price')) {
            $minPrice = $this->request->get('min_price', 0);
            $maxPrice = $this->request->get('max_price', PHP_INT_MAX);
            $theQuery->whereBetween('products.sell_price', [$minPrice, $maxPrice]);
        }
        if ($this->request->filled('rating')) {
            $rating = (int) $this->request->rating;
            $theQuery->where('products.rating', '>=', $rating)
                     ->where('products.rating', '<', $rating + 1);
        }
        if($this->request->filled('date_from')) {
            $theQuery->whereDate('products.created_at', '>=', $this->request->date_from);
        }
        if($this->request->filled('date_to')) {
            $theQuery->whereDate('products.created_at', '<=', $this->request->date_to);
        }
        return $theQuery;
    }
}

