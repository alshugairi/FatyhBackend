<?php

namespace App\Http\Controllers\Admin;

use App\{Enums\UserType, Http\Controllers\Controller, Utils\HttpFoundation\Response};
use Illuminate\{Contracts\View\View, Support\Facades\DB};

class DashboardController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.dashboard.index', get_defined_vars());
    }

    public function loadData()
    {
        $counts = DB::query()
                    ->selectRaw('(SELECT COUNT(*) FROM users WHERE type = '.UserType::CLIENT->value.' ) as clients_count')
                    ->selectRaw('(SELECT COUNT(*) FROM products WHERE deleted_at IS NULL) as products_count')
                    ->selectRaw('(SELECT COUNT(*) FROM orders) as orders_count')
                    ->first();

        $orderCountsByStatus = DB::table('orders')
            ->selectRaw('
                                COUNT(CASE WHEN status = "pending" THEN 1 END) as pending_count,
                                COUNT(CASE WHEN status = "processing" THEN 1 END) as processing_count,
                                COUNT(CASE WHEN status = "on_hold" THEN 1 END) as on_hold_count,
                                COUNT(CASE WHEN status = "shipped" THEN 1 END) as shipped_count,
                                COUNT(CASE WHEN status = "delivered" THEN 1 END) as delivered_count,
                                COUNT(CASE WHEN status = "cancelled" THEN 1 END) as cancelled_count,
                                COUNT(CASE WHEN status = "refunded" THEN 1 END) as refunded_count
                             ')
            ->first();

        $salesData = DB::table('orders')
            ->selectRaw('
                MONTH(created_at) as month,
                SUM(total) as total_sales
            ')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthNames = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];

        $monthlySales = [];
        foreach ($monthNames as $number => $name) {
            $monthlySales[$name] = 0;
        }

        foreach ($salesData as $data) {
            $monthName = $monthNames[$data->month];
            $monthlySales[$monthName] = $data->total_sales;
        }

        return Response::response(
            data: [
                'counts' => $counts,
                'orders_by_status' => $orderCountsByStatus,
                'monthly_sales' => ['labels' => array_keys($monthlySales), 'values' => array_values($monthlySales)],
            ]
        );
    }
}
