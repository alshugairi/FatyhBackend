@extends('account.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">{{ __('frontend.address') }}</h5>
        <a href="{{ route('account.address.create') }}" class="btn btn-sm btn-dark">{{ __('frontend.add_address') }}</a>
    </div>

    <div class="row mt-5">
        @foreach($addresses as $address)
            <div class="col-md-4 mb-3">
                <div class="card rounded-25 border-2">
                    <div class="card-body">
                        <h6 class="card-title">{{ $address->full_name }}</h6>
                        <p class="card-text">
                            <strong>{{ __('frontend.phone') }}:</strong> {{ $address->phone }}<br>
                            <strong>{{ __('frontend.email') }}:</strong> {{ $address->email }}<br>
                            <strong>{{ __('frontend.address_line_1') }}:</strong> {{ $address->address_line_1 }}<br>
                            @if($address->address_line_2)
                                <strong>{{ __('frontend.address_line_2') }}:</strong> {{ $address->address_line_2 }}<br>
                            @endif
                            <strong>{{ __('frontend.city') }}:</strong> {{ $address->city?->name }}<br>
                            <strong>{{ __('frontend.country') }}:</strong> {{ $address->country?->name }}<br>
                            <strong>{{ __('frontend.postal_code') }}:</strong> {{ $address->postal_code }}<br>
                        </p>
                        @if($address->is_default)
                            <span class="badge bg-success">{{ __('frontend.default_address') }}</span>
                        @else
                            &nbsp;
                        @endif
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('account.address.edit', $address) }}" class="btn btn-sm btn-info mx-2"><i class="fa-solid fa-pen-to-square"></i></a>
                            <form action="{{ route('account.address.destroy', $address) }}" method="POST" onsubmit="return confirm('{{ __('frontend.confirm_delete') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
