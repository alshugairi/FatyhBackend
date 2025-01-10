@extends('admin.layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="page-title">{{ __('admin.products') }} : {{ $collection->name }}</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <x-datatable.export/>
                    @can('collections.add_products')
                        <a class="btn btn-md btn-primary-light" data-bs-toggle="modal" data-bs-target="#productModal">
                            <i class="fa-solid fa-circle-plus"></i>
                            <span class="d-md-inline-block d-none">{{ __('admin.add_product') }}</span>
                        </a>

                        <div class="modal fade" id="productModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="addProductForm" action="{{ route('admin.collections.products.store', $collection->id) }}" method="POST">
                                        @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('admin.select_product') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <select name="product_id" class="form-select product-select w-100" id="productSelect">
                                                <option value="">{{ __('admin.select_product') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin.close') }}</button>
                                            <button type="submit" class="btn btn-primary">{{ __('admin.add') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt" class="table w-100">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{ __('admin.name') }}</th>
                                <th>{{ __('admin.created_at') }}</th>
                                @canany(['collections.delete_products'])
                                    <th>{{ __('admin.actions') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            dataTable = $('#dt').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                order: [[ 0, "desc" ]],
                ajax: '{!! route('admin.collections.products.list', $collection->id) !!}',
                columns: [
                    { data: 'id', name: 'id',visible: false},
                    { data: 'product', name: 'product_id' },
                    { data: 'formatted_created_at', name: 'created_at' },
                    @canany(['collections.delete_products'])
                    {data: 'actions',name: 'actions',orderable: false,searchable: false},
                    @endcanany
                ],
                columnDefs: [
                    @canany(['collections.delete_products'])
                    {
                        "targets": -1,
                        "render": function (data, type, row) {
                            var deleteUrl = '{{ route("admin.collections.products.destroy", [":collectionId", ":productId"]) }}';
                            deleteUrl = deleteUrl.replace(':collectionId', '{{ $collection->id }}')
                                                 .replace(':productId', row.product_id);

                            return `<div class='btn-actions'>
                                       @can('collections.delete_products')
                                       <a class="confirm-delete btn btn-danger-light" data-url="${deleteUrl}"><i class="fa-solid fa-trash-can"></i></a>
                                       @endcan
                                   </div>`;
                        }
                    }
                    @endcanany
                ]
            });

            $('#addProductForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#productModal').modal('hide');
                        $('#product_id').val(null).trigger('change');
                        $('#dt').DataTable().ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON.errors) {
                            Object.values(xhr.responseJSON.errors).forEach(error => {
                                toastr.error(error[0]);
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
