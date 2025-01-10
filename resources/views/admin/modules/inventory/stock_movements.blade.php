@extends('admin.layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="page-title">{{ __('admin.stock_movements') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
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
                                <th>{{ __('admin.notes') }}</th>
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
            const table = $('#movements-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                order: [[0, 'desc']],
                ajax: {
                    url: '{{ route("admin.stock_movements.list") }}',
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
                    },
                    {data: 'notes'}
                ]
            });
        });
    </script>
@endpush
