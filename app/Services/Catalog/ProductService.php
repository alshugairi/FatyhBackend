<?php

namespace App\Services\Catalog;

use App\Enums\OrderStatus;
use App\Exports\ProductExport;
use App\Repositories\Catalog\ProductRepository;
use App\Services\BaseService;
use Illuminate\{Database\Eloquent\Model, Http\JsonResponse, Http\Request, Pipeline\Pipeline, Support\Facades\DB};
use Yajra\DataTables\DataTables;
use Exception;
use Rap2hpoutre\FastExcel\FastExcel;
use Mpdf\Mpdf;

class ProductService extends BaseService
{
    public function __construct(ProductRepository $repository)
    {
        parent::__construct($repository);
    }

    public function list(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()->with($relations);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('name', function ($item){ return $item->name; })
            ->editColumn('category', function ($item){ return $item->category?->name; })
            ->toJson();
    }

    public function getProductsByCollectionId(int $collectionId): mixed
    {
        return $this->repository->getModel()
                         ->join('collection_products', 'collection_products.product_id', '=', 'products.id')
                         ->with(['defaultImage'])
                         ->withWishlists()
                         ->where('collection_id', $collectionId)
                         ->paginate(24);
    }

    public function search(Request $request)
    {
        $term = $request->get('q');
        $products = $this->repository->getModel()->where('name', 'like', "%{$term}%")
                         ->select('id', 'name', 'has_variants', 'purchase_price', 'sell_price')
                         ->take(20)
                         ->get();
        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->id,
                'text' => $product->name,
                'has_variants' => $product->has_variants,
                'purchase_price' => $product->purchase_price,
                'sell_price' => $product->sell_price,
            ];
        }
        return $data;
    }

    public function soldQuantityList(array $filters = [], array $relations = [], array $withCount = []): JsonResponse
    {
        $query = $this->repository->getModel()
            ->select(
                'products.id',
                'products.name',
                'products.category_id',
                DB::raw('COALESCE(SUM(CASE WHEN orders.status = "' . OrderStatus::DELIVERED->value . '" THEN order_items.quantity ELSE 0 END), 0) as sold_quantity')
            )
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->groupBy('products.id', 'products.name', 'products.category_id')
            ->orderByDesc('sold_quantity');

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('name', function ($item){ return $item->name; })
            ->editColumn('category', function ($item){ return $item->category?->name; })
            ->toJson();
    }

    public function export(string $type, array $filters = []): mixed
    {
        $exporter = new ProductExport($filters);

        if ($type === 'excel') {
            return $this->exportToExcel($exporter);
        }

        return $this->exportToPdf($exporter);
    }

    protected function exportToExcel(ProductExport $exporter): mixed
    {
        $fileName = 'products_' . date('Y_m_d_His') . '.xlsx';

        return (new FastExcel($exporter->generator()))->download($fileName);
    }

    protected function exportToPdf(ProductExport $exporter): mixed
    {
        $tempDir = storage_path('app/public/temp/mpdf');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'orientation' => 'L',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
            'direction' => app()->getLocale() == 'ar' ? 'rtl' : 'ltr',
            'tempDir' => $tempDir
        ]);

        $data = [];
        foreach ($exporter->generator() as $row) {
            $data[] = $row;
        }

        $html = view('admin.modules.catalog.products.pdf', [
            'headings' => array_shift($data),
            'data' => $data,
            'filters' => request()->all()
        ])->render();

        $mpdf->WriteHTML($html);

        return $mpdf->Output('products_' . date('Y_m_d_His') . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }
}
