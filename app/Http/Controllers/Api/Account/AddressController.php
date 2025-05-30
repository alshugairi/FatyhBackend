<?php

namespace App\Http\Controllers\Api\Account;

use App\{Http\Controllers\Controller,
    Http\Requests\Api\Account\AddressRequest,
    Http\Resources\AddressResource,
    Pipelines\AddressFilterPipeline,
    Services\AddressService,
    Utils\HttpFoundation\Response};
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(private readonly AddressService $addressService)
    {
    }

    public function index(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: AddressResource::collection(
                $this->addressService->index(filters: [
                    new AddressFilterPipeline(request: request()->merge(['user_id' => auth()->id()])),
                ], paginate: 24)
            )
        );
    }

    public function store(AddressRequest $request): Response
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $this->addressService->create(data: $data);
        return Response::response(
            message: __(key:'share.address_added_successfully'),
        );
    }
}
