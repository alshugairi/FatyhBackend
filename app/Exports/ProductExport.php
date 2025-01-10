<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Routing\Pipeline;
use Illuminate\Support\Collection;

class ProductExport
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function headings(): array
    {
        return [
            __('admin.name'),
            __('admin.category'),
            __('admin.sku'),
            __('admin.sell_price'),
            __('admin.created_at'),
        ];
    }

    public function generator(): \Generator
    {
        yield $this->headings();

        $query = app(Pipeline::class)
            ->send(Product::query()
                ->with(['category'])
                ->orderBy('id', 'desc'))
            ->through($this->filters)
            ->thenReturn();

        foreach ($query->cursor() as $product) {
            yield [
                $product->name,
                $product->category?->name,
                $product->sku,
                $product->sell_price,
                $product->formatted_created_at,
            ];
        }
    }
}
