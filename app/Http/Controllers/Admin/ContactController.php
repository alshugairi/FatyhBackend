<?php

namespace App\Http\Controllers\Admin;

use App\{Http\Controllers\Controller,
    Services\ContactService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse};
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(private readonly ContactService $service)
    {
    }

    public function index(): View
    {
        return view('admin.modules.contact.index', get_defined_vars());
    }

    public function list(Request $request): JsonResponse
    {
        return $this->service->list();
    }
}
