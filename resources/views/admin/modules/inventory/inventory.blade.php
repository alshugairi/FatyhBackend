@extends('admin.layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="page-title">{{ __('admin.inventory') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table w-100" id="inventory-table">
                            <thead>
                            <tr>
                                <th>{{ __('admin.name') }}</th>
                                <th>{{ __('admin.sku') }}</th>
                                <th>{{ __('admin.stock') }}</th>
                                <th>{{ __('admin.actions') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Movements Modal -->
    <div class="modal fade" id="movementsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('admin.stock_movements') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table w-100" id="movements-table">
                            <thead>
                            <tr>
                                <th>{{ __('admin.date') }}</th>
                                <th>{{ __('admin.type') }}</th>
                                <th>{{ __('admin.quantity_before') }}</th>
                                <th>{{ __('admin.change') }}</th>
                                <th>{{ __('admin.quantity_after') }}</th>
                                <th>{{ __('admin.reference') }}</th>
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
        $(document).ready(function() {
            const table = $('#inventory-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                ajax: '{{ route("admin.inventory.list") }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'sku', name: 'sku' },
                    {
                        data: 'stock_quantity',
                        render: function(data, type, row) {
                            const stockClass = data <= 0 ? 'text-danger' :
                                data < 10 ? 'text-warning' : 'text-success';
                            return `<strong class="${stockClass}">${data}</strong>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let dataType = 'product';
                            let id = row.id;

                            if (row.has_variants && row.variant_id) {
                                dataType = 'variant';
                                id = row.variant_id;
                            }

                            return `<div class='btn-actions'>
                                        <button type="button"
                                                class="btn btn-info-light view-movements"
                                                data-type="${dataType}"
                                                data-id="${id}">
                                            <i class="fas fa-history"></i>
                                        </button>
                                    </div>`;
                        }
                    }
                ]
            });

            $(document).on('click', '.view-movements', function() {
                const type = $(this).data('type');
                const id = $(this).data('id');

                if($('#movements-table').DataTable()) {
                    $('#movements-table').DataTable().destroy();
                }

                const movementsTable = $('#movements-table').DataTable({
                    processing: true,
                    serverSide: true,
                    bFilter: false,
                    bLengthChange: false,
                    pageLength: 50,
                    order: [[0, 'desc']],
                    ajax: {
                        url: '{{ route("admin.stock_movements.list") }}',
                        data: function(d) {
                            if (type === 'product') {
                                d.product_id = id;
                            } else {
                                d.product_variant_id = id;
                            }
                        }
                    },
                    columns: [
                        { data: 'movement_date', name: 'movement_date' },
                        { data: 'type', name: 'type' },

                        {data: 'quantity_before'},
                        {
                            data: 'quantity_change',
                            render: function(data) {
                                const color = data >= 0 ? 'text-success' : 'text-danger';
                                return `<strong class="${color}">${data}</strong>`;
                            }
                        },
                        {data: 'quantity_after'},
                        {
                            data: null,
                            render: function(data) {
                                return `${data.reference_type} #${data.reference_id}`;
                            }
                        }
                    ]
                });

                $('#movementsModal').modal('show');

                $('#movementsModal').on('shown.bs.modal', function () {
                    movementsTable.columns.adjust();
                });
            });

            $('#movementsModal').on('hidden.bs.modal', function () {
                if($('#movements-table').DataTable()) {
                    $('#movements-table').DataTable().destroy();
                }
            });
        });
    </script>
@endpush
