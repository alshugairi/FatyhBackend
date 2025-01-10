@extends('frontend.layouts.app')

@section('content')
    <div class="page-title" style="background-image: url()">
        <div class="wide-container">
            <h1>{{ __('frontend.checkout') }}</h1>
        </div>
    </div>

    <div class="wide-container mt-60 mb-60">
        @if($cartItems->count() > 0)
            <form id="checkout-form" action="{{ route('checkout.placeOrder') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-8">

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                        <h5 class="mb-4">{{ __('frontend.customer_information') }}</h5>
                        <div class="row">
                            <x-form.input col="col-md-6" name="customer_name" required="true" labelName="{{ trans('frontend.full_name') }}"/>
                            <x-form.input col="col-md-6" name="customer_phone" required="true" labelName="{{ trans('frontend.phone') }}"/>
                            <x-form.input col="col-md-6" name="customer_email" required="true" labelName="{{ trans('frontend.email') }}"/>
                        </div>

                        <h5 class="mt-5 mb-4">{{ __('frontend.shipping_information') }}</h5>
                        <div class="row">
                            <x-form.select col="col-md-6" name="shipping_country" required="true" :options="$countries" labelName="{{ trans('frontend.country') }}"/>
                            <x-form.select col="col-md-6" name="shipping_city" required="true" :options="$cities" labelName="{{ trans('frontend.city') }}"/>
                            <x-form.input col="col-md-6" name="shipping_postcode" required="true" labelName="{{ trans('frontend.postal_code') }}"/>
                            <x-form.input col="col-md-6" name="shipping_address" required="true" labelName="{{ trans('frontend.address_line1') }}"/>
                            <x-form.input col="col-md-6" name="shipping_address_line2" labelName="{{ trans('frontend.address_line2') }}"/>
                            <x-form.textarea col="col-md-12" name="customer_notes" labelName="{{ trans('frontend.notes') }}"/>
                        </div>

                        <h5 class="mt-5 mb-4">{{ __('frontend.billing_information') }}</h5>
                        <div class="row">
                            <x-form.select col="col-md-6" name="billing_country" :options="$countries" labelName="{{ trans('frontend.country') }}"/>
                            <x-form.select col="col-md-6" name="billing_city" :options="$cities" labelName="{{ trans('frontend.city') }}"/>
                            <x-form.input col="col-md-6" name="billing_postcode" labelName="{{ trans('frontend.postal_code') }}"/>
                            <x-form.input col="col-md-6" name="billing_address" labelName="{{ trans('frontend.address_line1') }}"/>
                            <x-form.input col="col-md-6" name="billing_address_line2" labelName="{{ trans('frontend.address_line2') }}"/>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="order-summary">
                            <h5 class="mb-4">{{ __('frontend.order_summary') }}</h5>
                            <div>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td class="fw-500 bg-gray">{{ __('frontend.product') }}</td>
                                        <td class="fw-500 bg-gray">{{ __('frontend.subtotal') }}</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td>{{ $item->name }} * {{ $item->quantity }}</td>
                                            <td>{{ format_currency((float)($item->quantity * $item->price)) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td class="fw-500 bg-gray">{{ __('frontend.subtotal') }}</td>
                                        <td class="fw-500">0</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-500 bg-gray">{{ __('frontend.shipping_cost') }}</td>
                                        <td class="fw-500">0</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-500 bg-gray">{{ __('frontend.tax') }}</td>
                                        <td class="fw-500">0</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-500 bg-gray">{{ __('frontend.total') }}</td>
                                        <td class="fw-500">{{ format_currency((float)$cartTotal) }}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="payment-methods mt-4">
                                <h5 class="mb-3">{{ __('frontend.payment_method') }}</h5>

                                <div class="payment-method-list">
                                    <div class="payment-method-item mt-3">
                                        <div class="payment-method-header">
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input payment-radio" type="radio" name="payment_method" id="stripe" value="stripe" checked>
                                                <label class="form-check-label ms-2 w-100" for="stripe">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fab fa-stripe me-2"></i>
                                                        <span class="ms-1">{{ __('frontend.stripe') }}</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="payment-method-content p-3 border-top d-none" id="stripe_content">
                                            <div class="text-center">
                                                <p class="mb-0">{{ __('frontend.redirect_to_stripe') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="payment-method-item mt-3">
                                        <div class="payment-method-header">
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input payment-radio" type="radio" name="payment_method" id="paypal" value="paypal">
                                                <label class="form-check-label ms-2 w-100" for="paypal">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fab fa-paypal me-2"></i>
                                                        <span class="ms-1">{{ __('frontend.paypal') }}</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="payment-method-content p-3 border-top d-none" id="paypal_content">
                                            <div class="text-center">
                                                <p class="mb-0">{{ __('frontend.redirect_to_paypal') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="payment-method-item mt-3">
                                        <div class="payment-method-header">
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input payment-radio" type="radio" name="payment_method" id="myfatoorah" value="myfatoorah">
                                                <label class="form-check-label ms-2 w-100" for="myfatoorah">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fab fa-paypal me-2"></i>
                                                        <span class="ms-1">{{ __('frontend.myfatoorah') }}</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="payment-method-content p-3 border-top d-none" id="myfatoorah_content">
                                            <div class="text-center">
                                                <p class="mb-0">{{ __('frontend.redirect_to_paypal') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="payment-method-item mt-3">
                                        <div class="payment-method-header">
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input payment-radio" type="radio" name="payment_method" id="kashier" value="kashier">
                                                <label class="form-check-label ms-2 w-100" for="kashier">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fab fa-paypal me-2"></i>
                                                        <span class="ms-1">{{ __('frontend.kashier') }}</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="payment-method-content p-3 border-top d-none" id="kashier_content">
                                            <div class="text-center">
                                                <p class="mb-0">{{ __('frontend.redirect_to_paypal') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 mt-4 place-order-btn">
                                <span class="btn-text">{{ __('frontend.place_order') }}</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <p>{{ __('frontend.empty_cart') }}</p>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.payment-radio').on('change', function() {
                $('.payment-method-content').addClass('d-none');
                $(`#${$(this).val()}_content`).removeClass('d-none');
            });

            $('.card-number').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                value = value.replace(/(.{4})/g, '$1 ').trim();
                $(this).val(value);

                const firstDigit = value.charAt(0);
                let cardIcon = 'fa-credit-card';

                if (firstDigit === '4') cardIcon = 'fa-cc-visa';
                else if (firstDigit === '5') cardIcon = 'fa-cc-mastercard';
                else if (firstDigit === '3') cardIcon = 'fa-cc-amex';

                $('.card-type-icon').attr('class', `fab ${cardIcon}`);
            });

            $('.card-expiry').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length > 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                $(this).val(value);
            });

            $('.card-cvv').on('input', function() {
                $(this).val($(this).val().replace(/\D/g, ''));
            });

            $('#checkout-form').on('submit', function(e) {
                //e.preventDefault();
            });
        });
    </script>
@endpush
