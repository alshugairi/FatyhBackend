<?php

namespace App\Services\Inventory;

use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use App\Models\{Product, ProductVariant};
use App\Repositories\Inventory\StockMovementRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StockMovementService extends BaseService
{
    public function __construct(StockMovementRepository $repository)
    {
        parent::__construct($repository);
    }

    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('movement_date', function ($item){ return format_date($item->movement_date); })
            ->editColumn('type', function ($item){ return __('admin.'. $item->type); })
            ->editColumn('reference_type', function ($item){ return __('admin.'. $item->reference_type); })
            ->toJson();
    }

    public function createFromPurchase(array $data): void
    {
        DB::transaction(function () use ($data) {
            $movementData = [
                'reference_type' => 'purchase',
                'reference_id' => $data['purchase_id'],
                'type' => 'purchase',
                'movement_date' => now(),
                'creator_id' => auth()->id(),
            ];

            if (isset($data['product_variant_id'])) {
                $this->handleVariantMovement($data, $movementData);
            } else {
                $this->handleProductMovement($data, $movementData);
            }
        });
    }

    public function createFromOrder(array $data): void
    {
        DB::transaction(function () use ($data) {
            $movementData = [
                'reference_type' => 'order',
                'reference_id' => $data['order_id'],
                'type' => $data['type'],
                'movement_date' => now(),
                'creator_id' => auth()->id(),
            ];

            if (isset($data['product_variant_id'])) {
                $this->handleVariantMovement($data, $movementData);
            } else {
                $this->handleProductMovement($data, $movementData);
            }
        });
    }

    private function handleProductMovement(array $data, array $movementData): void
    {
        $product = Product::findOrFail($data['product_id']);
        $currentStock = $product->stock_quantity ?? 0;
        $quantity = $data['quantity'];

        if ($movementData['reference_type'] === 'order' && !in_array($movementData['type'], ['return', 'cancel'])) {
            $quantity = -$quantity;
        }

        $newStock = $currentStock + $quantity;

        if ($newStock < 0) {
            throw new \Exception('Insufficient stock for product: ' . $product->name);
        }

        $this->repository->create(array_merge($movementData, [
            'product_id' => $data['product_id'],
            'quantity_change' => $quantity,
            'quantity_before' => $currentStock,
            'quantity_after' => $newStock,
            'notes' => $this->getMovementNote($movementData['reference_type'], $movementData['type'], $movementData['reference_id'])
        ]));

        $product->update(['stock_quantity' => $newStock]);
    }

    private function handleVariantMovement(array $data, array $movementData): void
    {
        $variant = ProductVariant::findOrFail($data['product_variant_id']);
        $currentStock = $variant->stock_quantity ?? 0;
        $quantity = $data['quantity'];

        if ($movementData['reference_type'] === 'order' && !in_array($movementData['type'], ['return', 'cancel'])) {
            $quantity = -$quantity;
        }

        $newStock = $currentStock + $quantity;

        if ($newStock < 0) {
            throw new \Exception('Insufficient stock for variant: ' . $variant->sku);
        }

        $this->repository->create(array_merge($movementData, [
            'product_id' => $data['product_id'],
            'product_variant_id' => $data['product_variant_id'],
            'quantity_change' => $quantity,
            'quantity_before' => $currentStock,
            'quantity_after' => $newStock,
            'notes' => $this->getMovementNote($movementData['reference_type'], $movementData['type'], $movementData['reference_id'])
        ]));

        $variant->update(['stock_quantity' => $newStock]);
    }

    private function getMovementNote(string $referenceType, string $type, int $referenceId): string
    {
        return match($referenceType) {
            'purchase' => "Stock added from purchase #{$referenceId}",
            'order' => match($type) {
                'sale' => "Stock reduced from order #{$referenceId}",
                'cancel' => "Stock returned from cancelled order #{$referenceId}",
                'return' => "Stock returned from returned order #{$referenceId}",
                default => "Stock movement from order #{$referenceId}"
            },
            default => "Stock movement reference #{$referenceId}"
        };
    }
}
