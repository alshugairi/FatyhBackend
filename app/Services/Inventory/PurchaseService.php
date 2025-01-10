<?php

namespace App\Services\Inventory;

use Illuminate\{Database\Eloquent\Model, Http\JsonResponse, Pipeline\Pipeline, Support\Facades\DB};
use App\{Enums\PurchaseStatus, Repositories\Inventory\PurchaseRepository, Services\BaseService};
use Yajra\DataTables\DataTables;

class PurchaseService extends BaseService
{
    public function __construct(PurchaseRepository $repository,
                                private readonly StockMovementService $stockMovementService)
    {
        parent::__construct($repository);
    }

    public function create(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $subtotal = 0;
            $total = 0;
            $data['subtotal'] = 0;
            $data['total'] = 0;
            $purchase = $this->repository->create($data);

            foreach ($data['items'] as $item) {
                $totals = $this->calculateItemTotals($item);

                $subtotal += $totals['subtotal'];
                $total += $totals['total'];

                $purchase->items()->create([
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['product_variant_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount' => $item['discount'] ?? 0,
                    'tax' => $item['tax'] ?? 0,
                    'subtotal' => $totals['subtotal'],
                    'total' => $totals['total'],
                ]);
            }

            $purchase->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);

            if ($purchase->status === PurchaseStatus::RECEIVED) {
                $this->handleStockMovement($purchase);
            }

            return $purchase;
        });
    }

    public function update(array $data, int $id): Model
    {
        return DB::transaction(function () use ($data, $id) {
            $purchase = $this->repository->find($id);
            $oldStatus = $purchase->status;
            $subtotal = 0;
            $total = 0;

            $purchase = $this->repository->update(data: $data, id: $id);
            $purchase->items()->delete();

            foreach ($data['items'] as $item) {
                $totals = $this->calculateItemTotals($item);

                $subtotal += $totals['subtotal'];
                $total += $totals['total'];

                $purchase->items()->create([
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['product_variant_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount' => $item['discount'] ?? 0,
                    'tax' => $item['tax'] ?? 0,
                    'subtotal' => $totals['subtotal'],
                    'total' => $totals['total'],
                ]);
            }

            $purchase->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);

            if ($oldStatus !== PurchaseStatus::RECEIVED && $purchase->status === PurchaseStatus::RECEIVED) {
                $this->handleStockMovement($purchase);
            }

            return $purchase->fresh(['items', 'supplier']);
        });
    }

    private function handleStockMovement(Model $purchase): void
    {
        foreach ($purchase->items as $item) {
            $this->stockMovementService->createFromPurchase([
                'purchase_id' => $purchase->id,
                'product_id' => $item->product_id,
                'product_variant_id' => $item->product_variant_id,
                'quantity' => $item->quantity,
            ]);
        }
    }

    private function calculateItemTotals(array $item): array
    {
        $subtotal = $item['unit_price'] * $item['quantity'];
        $discount = $item['discount'] ?? 0;
        $afterDiscount = $subtotal - $discount;
        $tax = ($afterDiscount * ($item['tax'] / 100));
        $total = $afterDiscount + $tax;

        return [
            'subtotal' => $subtotal,
            'total' => $total
        ];
    }

    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('supplier', function ($item){ return $item->supplier?->name; })
            ->toJson();
    }
}
