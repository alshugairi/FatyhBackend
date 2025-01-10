<?php

namespace App\Http\Controllers\Account;

use App\{Http\Controllers\Controller,
    Http\Requests\Account\AddressRequest,
    Models\Address,
    Models\City,
    Models\Country,
    Pipelines\AddressFilterPipeline,
    Pipelines\SortFilterPipeline,
    Services\AddressService};
use Illuminate\{Contracts\View\View, Http\RedirectResponse, Http\Request};

class AddressController extends Controller
{
    public function __construct(private readonly AddressService $service)
    {
    }

    public function index(): View
    {
        $addresses = $this->service->index(filters: [
            new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc'),
            new AddressFilterPipeline(new Request(['user_id' => auth()->id()]))
        ], paginate: 100, relations: ['country','user']);

        return view('account.modules.address.index', get_defined_vars());
    }

    public function create(): View
    {
        $countries = Country::getAll();
        $cities = City::getAll();
        return view('account.modules.address.create', get_defined_vars());
    }

    public function store(AddressRequest $request): RedirectResponse
    {
        if ($request->input('is_default')) {
            Address::where('user_id', auth()->id())->update(['is_default' => 0]);
        }

        $this->service->create(data: array_merge($request->validated(), ['user_id' => auth()->id()]));
        flash(__('frontend.address_created_successfully'))->success();
        return redirect()->route(route: 'account.address.index');
    }

    public function edit(Address $address): View
    {
        $countries = Country::getAll();
        $cities = City::getAll();
        return view('account.modules.address.edit', get_defined_vars());
    }

    public function update(AddressRequest $request, Address $address): RedirectResponse
    {
        if ($request->input('is_default')) {
            Address::where('user_id', auth()->id())->where('id', '!=', $address->id)->update(['is_default' => 0]);
        }

        $this->service->update(data: $request->validated(), id: $address->id);

        flash(__('frontend.address_updated_successfully'))->success();
        return redirect()->route(route: 'account.address.index');
    }

    public function destroy(Address $address): RedirectResponse
    {
        $this->service->delete(id: $address->id);
        flash(__('frontend.address_deleted_successfully'))->success();
        return back();
    }
}
