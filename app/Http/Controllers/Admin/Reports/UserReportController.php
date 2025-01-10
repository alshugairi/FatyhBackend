<?php

namespace App\Http\Controllers\Admin\Reports;

use App\{Enums\UserType, Http\Controllers\Controller, Pipelines\UserFilterPipeline, Services\UserService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class UserReportController extends Controller
{
    public function __construct(private readonly UserService $service)
    {
    }

    public function creditBalance(Request $request)
    {
        return view('admin.modules.reports.credit_balance', get_defined_vars());
    }

    public function creditBalanceList(Request $request): JsonResponse
    {
        return $this->service->list(filters: [
            new UserFilterPipeline(request: $request),
        ]);
    }
}
