@php
    $precision = get_setting('site_precision', 2);
    $symbol = default_currency()?->symbol;
    $currencyPosition = get_setting('site_currency_position', 'left');
@endphp
<div class="card mt-3">
    <div class="card-body">
        <div class="alert alert-warning">
            {{ __('admin.please_select_products') }}
        </div>

        <div class="border rounded p-3">
            <div class="fw-bold mb-2">{{ __('admin.add_product') }}</div>
            <select class="form-select product-select" id="productSelect">
                <option value="">{{ __('admin.select_product') }}</option>
            </select>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered" id="purchaseTable">
                <thead>
                <tr>
                    <th>{{ __('admin.product') }}</th>
                    <th>{{ __('admin.variant') }}</th>
                    <th>{{ __('admin.unit_price') }}</th>
                    <th>{{ __('admin.quantity') }}</th>
                    <th>{{ __('admin.discount') }} ({{ $symbol }})</th>
                    <th>{{ __('admin.tax') }} (%)</th>
                    <th>{{ __('admin.subtotal') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($purchase) && $purchase->items)
                    @foreach($purchase->items as $key => $item)
                        <tr id="product-{{ $item->product_id }}" data-product-id="{{ $item->product_id }}">
                            <td>
                                {{ $item->product->name }}
                                <input type="hidden" name="items[product-{{ $item->product_id }}-{{ $key }}][product_id]" value="{{ $item->product_id }}">
                            </td>
                            <td>
                                @if($item->product->has_variants)
                                    <select name="items[product-{{ $item->product_id }}-{{ $key }}][product_variant_id]"
                                            class="form-control form-select variant-select"
                                            required
                                            data-product-id="{{ $item->product_id }}">
                                        <option value="">{{ __('admin.select_variant') }}</option>
                                        @foreach($item->product->variants as $variant)
                                            <option value="{{ $variant->id }}"
                                                    data-price="{{ $variant->purchase_price }}"
                                                {{ $item->product_variant_id == $variant->id ? 'selected' : '' }}>
                                                {{ $variant->attributeOptions->map(fn($opt) => $opt->name)->join(' | ') }}
                                                ({{ $variant->sku }})
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    --
                                @endif
                            </td>
                            <td>
                                <input type="number" name="items[product-{{ $item->product_id }}-{{ $key }}][unit_price]"
                                       class="form-control unit-price" value="{{ number_format($item->unit_price, $precision, '.', '') }}"
                                       min="0" step="0.01" required>
                            </td>
                            <td>
                                <input type="number" name="items[product-{{ $item->product_id }}-{{ $key }}][quantity]"
                                       class="form-control quantity" value="{{ $item->quantity }}" min="1" required>
                            </td>
                            <td>
                                <input type="number" name="items[product-{{ $item->product_id }}-{{ $key }}][discount]"
                                       class="form-control discount" value="{{ number_format($item->discount, $precision, '.', '') }}"
                                       min="0" step="0.01">
                            </td>
                            <td>
                                <input type="number" name="items[product-{{ $item->product_id }}-{{ $key }}][tax]"
                                       class="form-control tax"
                                       value="{{ number_format($item->tax, $precision, '.', '') }}"
                                       min="0" max="100" step="0.01">
                            </td>
                            <td>
                                @if($currencyPosition === 'left')
                                    <span>{{ $symbol }}</span>
                                @endif
                                <span class="subtotal">{{ number_format($item->subtotal, $precision, '.', '') }}</span>
                                @if($currencyPosition === 'right')
                                    <span>{{ $symbol }}</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-item">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="6" class="text-end"><strong>{{ __('admin.grand_total') }}:</strong></td>
                    <td colspan="2">
                        @if($currencyPosition === 'left')
                            <span>{{ $symbol }}</span>
                        @endif
                        <span id="grandTotal">{{ isset($purchase) ? number_format($purchase->total, $precision, '.', '') : number_format(0, $precision, '.', '') }}</span>
                        @if($currencyPosition === 'right')
                            <span>{{ $symbol }}</span>
                        @endif
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        let default_precision = "{{ $precision }}";
        let symbol = "{{ $symbol }}";
        let currencyPosition = "{{ $currencyPosition }}";

        $(document).ready(function() {
            $('#productSelect').on('select2:select', function(e) {
                const product = e.params.data;
                addProductToTable(product);
                $(this).val(null).trigger('change');
            });

            function addProductToTable(item) {
                const rowId = `product-${item.id}-${Date.now()}`;

                if (!item.has_variants) {
                    const existingProduct = $(`tr[data-product-id="${item.id}"]:not([data-variant-id])`);
                    if (existingProduct.length) {
                        toastr.error("{{ __('admin.product_already_added_to_purchase') }}");
                        return;
                    }
                }

                const newRow = `
                    <tr id="${rowId}" data-product-id="${item.id}">
                        <td>
                            ${item.text}
                            <input type="hidden" name="items[${rowId}][product_id]" value="${item.id}">
                        </td>
                        <td>
                            ${item.has_variants ?
                            `<select name="items[${rowId}][product_variant_id]"
                                        class="form-control form-select variant-select"
                                        required
                                        data-product-id="${item.id}">
                                    <option value="">{{ __('admin.select_variant') }}</option>
                                </select>`
                            : '--'
                        }
                        </td>
                         <td>
                            <input type="number" name="items[${rowId}][unit_price]"
                                class="form-control unit-price" value="${Number(item.purchase_price).toFixed(default_precision)}"
                                min="0" step="${Math.pow(10, -default_precision)}" required>
                        </td>
                        <td>
                            <input type="number" name="items[${rowId}][quantity]"
                                class="form-control quantity" value="1" min="1" required>
                        </td>
                        <td>
                            <input type="number" name="items[${rowId}][discount]"
                                class="form-control discount" value="0"
                                min="0" step="${Math.pow(10, -default_precision)}">
                        </td>
                        <td>
                            <input type="number" name="items[${rowId}][tax]"
                                class="form-control tax" value="0"
                                min="0" max="100" step="${Math.pow(10, -default_precision)}">
                        </td>
                        <td>
                            @if($currencyPosition === 'left')
                            <span>{{ $symbol }}</span>
                            @endif
                            <span class="subtotal">{{ number_format(0, $precision, '.', '') }}</span>
                            @if($currencyPosition === 'right')
                            <span>{{ $symbol }}</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                $('#purchaseTable tbody').append(newRow);

                if (item.has_variants) {
                    loadVariantsForSelect(item.id, rowId);
                }

                updateTotals();
            }

            function loadVariantsForSelect11(productId, rowId) {
                const usedVariants = [];
                $(`tr[data-product-id="${productId}"]`).each(function() {
                    const selectedVariant = $(this).find('.variant-select').val();
                    if (selectedVariant) {
                        usedVariants.push(selectedVariant);
                    }
                });

                $.ajax({
                    url: `/admin/products/${productId}/variants`,
                    method: 'GET',
                    success: function(variants) {
                        const variantSelect = $(`#${rowId} .variant-select`);
                        variantSelect.html('<option value="">{{ __('admin.select_variant') }}</option>');

                        variants.forEach(function(variant) {
                            // Only add variant if it's not already used
                            if (!usedVariants.includes(variant.id.toString())) {
                                variantSelect.append(`
                        <option value="${variant.id}"
                                data-price="${variant.purchase_price}">
                            ${variant.name} (${variant.sku})
                        </option>
                    `);
                            }
                        });
                    }
                });
            }

            function loadVariantsForSelect(productId, rowId) {
                $.ajax({
                    url: `/admin/products/${productId}/variants`,
                    method: 'GET',
                    success: function(variants) {
                        const variantSelect = $(`#${rowId} .variant-select`);
                        variantSelect.html('<option value="">{{ __('admin.select_variant') }}</option>');

                        variants.forEach(function(variant) {
                            variantSelect.append(`
                                <option value="${variant.id}"
                                        data-price="${variant.purchase_price}">
                                    ${variant.name} (${variant.sku})
                                </option>
                            `);
                        });
                    }
                });
            }

            $(document).on('change', '.variant-select11', function() {
                const selectedOption = $(this).find('option:selected');
                const price = selectedOption.data('price');
                if (price) {
                    $(this).closest('tr').find('.unit-price').val(price);
                    updateTotals();
                }
            });

            $(document).on('click', '.remove-item', function() {
                $(this).closest('tr').remove();
                updateTotals();
            });

            $(document).on('input', '.unit-price, .quantity, .discount, .tax', function() {
                updateTotals();
            });

            function calculateSubtotal(unitPrice, quantity, discount, tax) {
                const baseAmount = unitPrice * quantity;
                const afterDiscount = baseAmount - discount;
                const taxAmount = afterDiscount * (tax / 100);
                return Number((afterDiscount + taxAmount).toFixed(default_precision));
            }

            function updateTotals() {
                let grandTotal = 0;

                $('#purchaseTable tbody tr').each(function() {
                    const unitPrice = parseFloat($(this).find('.unit-price').val()) || 0;
                    const quantity = parseInt($(this).find('.quantity').val()) || 0;
                    const discount = parseFloat($(this).find('.discount').val()) || 0;
                    const tax = parseFloat($(this).find('.tax').val()) || 0;

                    const subtotal = calculateSubtotal(unitPrice, quantity, discount, tax);
                    $(this).find('.subtotal').text(subtotal);
                    grandTotal = Number((grandTotal + subtotal).toFixed(default_precision));

                });

                $('#grandTotal').text(grandTotal);
            }

            $('#purchaseForm').on('submit', function(e) {
                const hasVariantProducts = $('#purchaseTable tbody tr').filter(function() {
                    return $(this).find('.variant-select').length > 0;
                });

                const hasEmptyVariants = hasVariantProducts.filter(function() {
                    return !$(this).find('.variant-select').val();
                });

                if (hasEmptyVariants.length > 0) {
                    e.preventDefault();
                    toastr.error("{{ __('admin.select_variants_for_variant_products') }}");
                    return false;
                }
            });
        });
    </script>
@endpush
