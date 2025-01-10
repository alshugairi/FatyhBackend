@extends('admin.layouts.app')
@php
    $precision = get_setting('site_precision', 2);
    $symbol = default_currency()?->symbol;
    $currencyPosition = get_setting('site_currency_position', 'left');
@endphp
@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="pos-container">
                <div class="products-section">
                    <div class="row mb-4">
                        <div class="col-md-4 mb-2">
                            <div class="input-group">
                                <input type="search" id="searchInput" class="form-control" placeholder="{{ __('admin.search') }}...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" onclick="fetchProducts()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <select id="categoryId" class="form-control form-select" onchange="fetchProducts()">
                                <option value="">{{ __('admin.select_category') }}</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-2">
                            <select id="brandId" class="form-control form-select" onchange="fetchProducts()">
                                <option value="">{{ __('admin.select_brand') }}</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row" id="productsGrid">
                    </div>
                </div>

                <div class="cart-section position-relative">
                    <div class="client-section py-1 px-2">
                        <div class="row m-0">
                            <div class="col-md-10 p-0">
                                <select class="form-select client-select" id="clientSelect"></select>
                            </div>
                            <div class="col-md-2 p-0">
                                <button type="button" class="btn btn-md btn-primary-light w-100" data-bs-toggle="modal" data-bs-target="#addClientModal">
                                    <i class="fa-solid fa-circle-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="cart-items"></div>
                    <div class="empty-cart text-center">
                        <img src="{{ asset('assets/admin') }}/images/empty-cart.gif" class="img-fluid">
                    </div>

                    <div class="cart-summary">
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ __('admin.subtotal') }}</span>
                            <span dir="ltr">
                                @if($currencyPosition === 'left')
                                    <span>{{ $symbol }}</span>
                                @endif
                                <span id="subtotal">0.00</span>
                                @if($currencyPosition === 'right')
                                    <span>{{ $symbol }}</span>
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ __('admin.tax') }} (14%)</span>
                            <span dir="ltr">
                                @if($currencyPosition === 'left')
                                    <span>{{ $symbol }}</span>
                                @endif
                                <span id="tax">0.00</span>
                                @if($currencyPosition === 'right')
                                    <span>{{ $symbol }}</span>
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ __('admin.discount') }}</span>
                            <div class="input-group input-group-sm" style="width: 130px;">
                                <input type="number" class="form-control" value="0">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary">{{ __('admin.apply') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="font-weight-bold">{{ __('admin.total') }}</span>
                            <span class="font-weight-bold" dir="ltr">
                                @if($currencyPosition === 'left')
                                    <span>{{ $symbol }}</span>
                                @endif
                                <span id="total">0.00</span>
                                @if($currencyPosition === 'right')
                                    <span>{{ $symbol }}</span>
                                @endif
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-md-6 p-1">
                                <button class="btn btn-success-light w-100 text-dark" onclick="submitOrder()">{{ __('admin.place_order') }}</button>
                            </div>
                            <div class="col-md-6 p-1">
                                <button class="btn btn-danger-light w-100" onclick="resetCart()">{{ __('admin.cancel_order') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partial.pos.invoice_modal')
    @include('admin.partial.pos.client_modal')
@endsection

@push('scripts')
    <script>
        let cart = [];
        let products = [];
        let default_precision = "{{ $precision }}";
        let symbol = "{{ $symbol }}";
        let currencyPosition = "{{ $currencyPosition }}";

        function fetchProducts() {
            var name = $('#searchInput').val();
            var categoryId = $('#categoryId').val();
            var brandId = $('#brandId').val();

            $.ajax({
                url: `{{ route('admin.products.listJson') }}?name=${name}&category_id=${categoryId}&brand_id=${brandId}`,
                method: 'GET',
                success: function (response) {
                    products = response.data;
                    renderProducts(products);
                },
                error: function () {
                    console.error("Failed to fetch products.");
                }
            });
        }

        function renderProducts(products) {
            const productsGrid = document.getElementById('productsGrid');
            productsGrid.innerHTML = products.map(product => `
                <div class="col-md-2 col-lg-3 mb-4">
                    <div class="card product-card" onclick="addToCart(${product.id})">
                        <div class="product-img-container">
                            ${product.isFlashSale ? '<span class="flash-sale-badge">Flash Sale</span>' : ''}
                            <img src="${product.image}" alt="${product.name}">
                        </div>
                        <div class="card-body">
                            <h5 class="product-title text-purple">${product.name}</h5>
                            <div class="mb-1 product-stars">
                                ${renderStars(product.rating)}
                            </div>
                            <div class="price-container">
                                <span class="h6 fw-bold"><span dir="ltr">${product.formatted_price}</span></span>
                                ${product.original_price > product.price ? `<span class="original-price">${product.original_price}</span>` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function renderStars(rating) {
            return Array(5).fill().map((_, i) =>
                `<i class="fas fa-star ${i < rating ? 'star-rating text-warning' : 'star-empty'}"></i>`
            ).join('');
        }

        function addToCart(product_id) {
            const product = products.find(p => p.id === product_id);
            const cartItem = cart.find(item => item.product_id === product_id);

            if (cartItem) {
                cartItem.quantity++;
            } else {
                cart.push({
                    product_id,
                    quantity: 1,
                    price: product.price
                });
            }
            $('.empty-cart').hide();
            renderCart();
            updateTotals();
        }

        function renderCart() {
            const cartItems = document.querySelector('.cart-items');
            cartItems.innerHTML = cart.map(item => {
                const product = products.find(p => p.id === item.product_id);
                const price = parseFloat(product.price);
                var cartTotal = price.toFixed(default_precision) * item.quantity;
                return `
                    <div class="cart-item">
                        <img src="${product.image}" alt="${product.name}">
                        <div class="cart-item-details">
                            <div class="font-weight-bold">${product.name}</div>
                            <div class="text-info">
                                <span dir="ltr">${currencyPosition === 'left' ? symbol + ' ' + cartTotal : cartTotal + ' ' + symbol}</span>
                            </div>
                        </div>
                        <div class="quantity-control">
                            <button class="quantity-btn" onclick="updateQuantity(${item.product_id}, -1)">-</button>
                            <span>${item.quantity}</span>
                            <button class="quantity-btn" onclick="updateQuantity(${item.product_id}, 1)">+</button>
                        </div>
                        <button class="btn btn-link ml-2" onclick="removeFromCart(${item.product_id})">
                            <i class="fas fa-trash text-danger"></i>
                        </button>
                    </div>
                `;
            }).join('');
        }

        function updateQuantity(product_id, change) {
            const cartItem = cart.find(item => item.product_id === product_id);
            if (cartItem) {
                cartItem.quantity += change;
                if (cartItem.quantity <= 0) {
                    removeFromCart(product_id);
                } else {
                    renderCart();
                    updateTotals();
                }
            }
        }

        function removeFromCart(product_id) {
            cart = cart.filter(item => item.product_id !== product_id);
            renderCart();
            updateTotals();
        }

        function updateTotals() {
            const subtotal = cart.reduce((sum, item) => {
                const product = products.find(p => p.id === item.product_id);
                const price = parseFloat(product.price);
                return sum + (price * item.quantity);
            }, 0);

            const tax = subtotal * 0.14;
            const total = subtotal + tax;

            document.getElementById('subtotal').textContent = `${subtotal.toFixed(default_precision)}`;
            document.getElementById('tax').textContent = `${tax.toFixed(default_precision)}`;
            document.getElementById('total').textContent = `${total.toFixed(default_precision)}`;
        }

        fetchProducts();
        renderCart();
        updateTotals();

        function submitOrder() {

            if (cart.length === 0) {
                Swal.fire({
                    title: "{{ __('admin.error') }}",
                    text: "{{ __('admin.cart_is_empty') }}",
                    icon: "error",
                    buttons: false,
                    timer: 3000,
                });
                return;
            }

            const orderItems = cart.map(item => {
                const product = products.find(p => p.id === item.product_id);
                return {
                    product_id: item.product_id,
                    name: product.name,
                    price: product.price,
                    quantity: item.quantity
                };
            });

            const subtotal = parseFloat(document.getElementById('subtotal').textContent);
            const tax = parseFloat(document.getElementById('tax').textContent);
            const discount = parseFloat(document.querySelector('input[type="number"]').value || 0);
            const total = parseFloat(document.getElementById('total').textContent);

            const userId = $('#clientSelect').val();

            const orderData = {
                user_id: userId,
                items: orderItems,
                subtotal: subtotal,
                tax: tax,
                discount: discount,
                total: total,
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: '{{ route("admin.orders.store") }}',
                method: 'POST',
                data: orderData,
                success: function(response, status, xhr) {
                    if (xhr.status === 200) {
                        resetCart();

                        $.get(`{{ route('admin.orders.invoice', '') }}/${response.data.order_id}`, function(content) {
                            $('#invoiceModalBody').html(content);
                            $('#invoiceModal').modal('show');
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = "{{ __('admin.please_correct_errors') }}" + '\n';
                        Object.keys(errors).forEach(key => {
                            errorMessage += `- ${errors[key][0]}\n`;
                        });

                        Swal.fire({
                            title: "{{ __('admin.validation_error') }}",
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: "{{ __('admin.unknown_error') }}",
                            text: "{{ __('admin.failed_to_place_order') }}" +' '+ (xhr.responseJSON?.message || "{{ __('admin.unknown_error') }}"),
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        }

        function resetCart()
        {
            cart = [];
            renderCart();
            updateTotals();
            $('.empty-cart').show();
            $('#clientSelect').val(null).trigger('change');
        }

        function closeModal() {
            $('#invoiceModal').modal('hide');
        }

    </script>
@endpush
