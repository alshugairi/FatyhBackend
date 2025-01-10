<?php

namespace App\Http\Controllers\Admin\Finance;

use App\{Enums\TransactionType,
    Http\Controllers\Controller,
    Http\Requests\Admin\Finance\TransactionRequest,
    Services\Finance\TransactionService,
    Utils\HttpFoundation\Response};
use Illuminate\{Contracts\View\View, Http\JsonResponse};
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(private readonly TransactionService $service)
    {
    }

    public function index(): View
    {
        return view('admin.modules.finance.transactions.index', get_defined_vars());
    }

    public function create(): View
    {
        return view('admin.modules.finance.transactions.create', get_defined_vars());
    }

    public function store(TransactionRequest $request)
    {
        $data = $request->validated();


        $this->service->create(data: $data);
        return Response::response(
            message: __('admin.created_successfully', ['module' => __('admin.transaction')]),
        );
    }

    public function list(Request $request): JsonResponse
    {
        return $this->service->list();
    }
}
