<div class="tab-pane fade" id="variation" role="tabpanel" aria-labelledby="v-pills-variation-tab">
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin.variation') }}</h3>
            <div class="card-tools">
                <a class="btn btn-md btn-primary-light" data-bs-toggle="modal" data-bs-target="#addVariationModal">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span class="d-md-inline-block d-none">{{ __('admin.add_variation') }}</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div id="productVariations">
                <div class="table-responsive">
                    <table id="variants-table" class="table w-100">
                        <thead>
                        <tr>
                            <th>{{ __('admin.name') }}</th>
                            <th>{{ __('admin.sku') }}</th>
                            <th>{{ __('admin.price') }}</th>
                            <th>{{ __('admin.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($product->variants as $variant)
                            <tr id="variant-{{ $variant->id }}">
                                <td>
                                    {{ $variant->attributeOptions->map(function($opt) { return $opt->name; })->join(' | ') }}
                                </td>
                                <td>{{ $variant->sku }}</td>
                                <td>{{ format_currency($variant->sell_price) }}</td>
                                <td>
                                    <div class='btn-actions'>
                                        <button class="delete-variant btn btn-danger-light" data-id="{{ $variant->id }}">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade" id="addVariationModal" tabindex="-1" role="dialog" aria-labelledby="addVariationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form id="variationForm">
                            <div class="modal-header">
                                <h6 class="modal-title fw-bold">{{ __('admin.add_variation') }}</h6>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="sku" class="form-label">{{ __('admin.sku') }} <sup class="text-danger">*</sup></label>
                                            <input type="text" class="form-control" id="sku" name="sku" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="sell_price" class="form-label">{{ __('admin.price') }} <sup class="text-danger">*</sup></label>
                                            <input type="number" step="0.01" class="form-control" id="sell_price" name="sell_price" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="stock_quantity" class="form-label">{{ __('admin.stock') }} <sup class="text-danger">*</sup></label>
                                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @foreach($attributes as $attribute)
                                            <div class="form-group mb-3">
                                                <label class="form-label">
                                                    {{ $attribute->name }}
                                                    @if($attribute->is_required)
                                                        <sup class="text-danger">*</sup>
                                                    @endif
                                                </label>
                                                <select class="form-control form-select attributes_options"
                                                        name="attributes[{{ $attribute->id }}][option_id]"
                                                        data-type="{{ $attribute->type }}"
                                                        @if($attribute->is_required) required @endif>
                                                    <option value="">{{ __('admin.select') }}</option>
                                                    @foreach($attribute->options as $option)
                                                        <option value="{{ $option->id }}"
                                                                data-value="{{ $option->value }}">
                                                            {{ $option->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger-light" data-bs-dismiss="modal">{{ __('admin.close') }}</button>
                                <button type="submit" class="btn btn-primary-light">{{ __('admin.add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.attributes_options').each(function() {
                const $select = $(this);
                var dropdownParent = $select.closest('.offcanvas, .modal').length ? $select.closest('.offcanvas, .modal') : $(document.body);
                const attributeType = $select.data('type');

                if (attributeType === 'color') {
                    $select.select2({
                        dropdownParent: dropdownParent,
                        templateResult: formatColorOption,
                        templateSelection: formatColorOption,
                        width: '100%'
                    });
                } else {
                    $select.select2({
                        dropdownParent: dropdownParent,
                        width: '100%'
                    });
                }
            });

            function formatColorOption(option) {
                if (!option.id) {
                    return option.text;
                }

                const $option = $(option.element);
                const colorValue = $option.data('value');

                return $('<span>').append(
                    $('<span>').css({
                        display: 'inline-block',
                        width: '20px',
                        height: '20px',
                        backgroundColor: colorValue,
                        border: '1px solid #ddd',
                        marginRight: '10px',
                        verticalAlign: 'middle'
                    }),
                    $('<span>').text(option.text)
                );
            }

            const productId = '{{ $product->id }}';

            $('#variationForm').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                $.ajax({
                    url: `/admin/products/${productId}/variants`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        const variant = response.data;
                        const newRow = `
                            <tr id="variant-${variant.id}">
                                <td>${variant.names}</td>
                                <td>${variant.sku}</td>
                                <td>${variant.formatted_price}</td>
                                <td>
                                    <div class='btn-actions'>
                                        <button class="delete-variant btn btn-danger-light" data-id="${variant.id}">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        `;
                        $('#variants-table tbody').append(newRow);

                        $('#addVariationModal').modal('hide');
                        $('#variationForm')[0].reset();
                        $('.attributes_options').val('').trigger('change');
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(key => {
                                toastr.error(errors[key][0]);
                            });
                        } else {
                            toastr.error(xhr.responseJSON.message || 'An error occurred');
                        }
                    }
                });
            });

            $('#addVariationModal').on('hidden.bs.modal', function () {
                $('#variationForm')[0].reset();
                $('.attributes_options').val('').trigger('change');
            });

            $(document).on('click', '.delete-variant', function() {
                const variantId = $(this).data('id');
                const $row = $(this).closest('tr');

                Swal.fire({
                    title: '{{ __("admin.are_you_sure") }}',
                    text: '{{ __("admin.delete_confirm_text") }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __("admin.yes_delete") }}',
                    cancelButtonText: '{{ __("admin.cancel") }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/product-variants/${variantId}`,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                $row.remove(); // Remove the row from table
                                toastr.success(response.message);
                            },
                            error: function(xhr) {
                                toastr.error(xhr.responseJSON.message || 'An error occurred');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
