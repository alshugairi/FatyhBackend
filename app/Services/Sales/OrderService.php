<?php

namespace App\Services\Sales;

use App\Enums\OrderStatus;
use App\Enums\PlatformType;
use App\Models\Product;
use App\Repositories\Sales\OrderRepository;
use App\Services\BaseService;
use App\Services\Inventory\StockMovementService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OrderService extends BaseService
{
    public function __construct(OrderRepository $repository,
                                private readonly StockMovementService $stockMovementService)
    {
        parent::__construct($repository);
    }

    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('user', function ($item){ return $item->user?->name; })
            ->toJson();
    }

    public function create(array $data): Model
    {
        if (isset($data['billing_address']) && is_array($data['billing_address'])) {
            unset($data['billing_address']);
        }

        return DB::transaction(function () use ($data) {
            $subtotal = 0;
            $total = 0;
            $data['number'] = 'ORD-' . date('Ymd') . '-' . random_int(1000, 9999);
            $data['subtotal'] = 0;
            $data['total'] = 0;
            $order = $this->repository->create($data);

            foreach ($data['items'] as $item) {
                $item['discount'] = 0;
                $item['tax'] = 0;
                $itemSubtotal = $item['price'] * $item['quantity'];
                $itemTotal = ($item['price'] * $item['quantity']) - $item['discount']  + $item['tax'];
                $subtotal += $itemSubtotal;
                $total += $itemTotal;

                $product = Product::find($item['product_id']);

                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'discount' => $item['discount'],
                    'tax' => $item['tax'],
                    'subtotal' => $itemSubtotal,
                    'total' => $itemTotal,
                    'name' => $product->name,
                    'sku' => $product->sku,
                ]);
            }


            $order->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);

            return $order;
        });
    }

    public function placeOrder(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $data['number'] = 'ORD-' . time();
            $data['user_id'] = auth()->id();
            $data['platform'] = PlatformType::Web;

            $order = $this->repository->create($data);

            foreach (\Cart::getContent() as $cartItem) {
                $itemSubtotal = $cartItem->price * $cartItem->quantity;
                $itemTotal = $itemSubtotal;

                $product = Product::find($cartItem->id);

                $order->items()->create([
                    'product_id' => $cartItem->id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->price,
                    'discount' => 0,
                    'tax' => 0,
                    'subtotal' => $itemSubtotal,
                    'total' => $itemTotal,
                    'name' => $product->name,
                    'sku' => $product->sku,
                ]);
            }

            return $order;
        });
    }

    public function updateStatus(int $id, string $status): Model
    {
        return DB::transaction(function () use ($id, $status) {
            $order = $this->repository->find($id);
            $oldStatus = $order->status;

            $order->update(['status' => $status]);

            $this->handleStockMovement($order, $oldStatus);

            return $order->fresh(['items']);
        });
    }

    private function handleStockMovement(Model $order, ?string $oldStatus): void
    {
        if ($oldStatus !== OrderStatus::CONFIRMED &&
            $order->status === OrderStatus::CONFIRMED) {
            foreach ($order->items as $item) {
                $this->stockMovementService->createFromOrder([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => -$item->quantity,
                    'type' => 'sale'
                ]);
            }
        }

        if (in_array($order->status, [
                OrderStatus::CANCELED,
                OrderStatus::RETURNED
            ]) && !in_array($oldStatus, [
                OrderStatus::CANCELED,
                OrderStatus::RETURNED
            ])) {
            foreach ($order->items as $item) {
                $this->stockMovementService->createFromOrder([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'type' => $order->status === OrderStatus::CANCELED ? 'cancel' : 'return'
                ]);
            }
        }
    }
}
