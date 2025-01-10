@extends('admin.layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="page-title">{{ __('admin.online_orders') }}</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <x-datatable.export/>
                    <x-datatable.filter>
                        <x-slot name="form">
                            <div class="row">
                                <x-form.select col="col-12" label="true" name="filter_user_id" key="filter_userId" classes="ajax_clients" select2="true" labelName="{{ __('ticket.client') }}"/>
                                <x-form.input col="col-12" type="date" name="filter_date_from" key="filter_dateFrom" value="{{ request('date_from') ?? date('Y-m-d') }}" label="true" labelName="{{ __('admin.date_from') }}"/>
                                <x-form.input col="col-12" type="date" name="filter_date_to" key="filter_dateTo" value="{{ request('date_to') ?? date('Y-m-d')  }}" label="true" labelName="{{ __('admin.date_to') }}"/>
                            </div>
                        </x-slot>
                    </x-datatable.filter>
                    @can('admins.create')
                        <x-datatable.create href="{{ route('admin.orders.create') }}" module="{{ __('admin.supplier') }}"/>
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
                                <th>{{ __('admin.id') }}</th>
                                <th>{{ __('admin.order_id') }}</th>
                                <th>{{ __('admin.total') }}</th>
                                <th>{{ __('admin.client') }}</th>
                                <th>{{ __('admin.created_at') }}</th>
                                <th>{{ __('admin.actions') }}</th>
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
            $('#dt').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                order: [[ 0, "desc" ]],
                ajax: {
                    url: '{!! route('admin.orders.list') !!}',
                    data: function (d) {
                        d.platform = "{{ request('platform') }}";
                    }
                },
                columns: [
                    { data: 'id', name: 'id'},
                    { data: 'number', name: 'number' },
                    { data: 'total', name: 'total' },
                    { data: 'user', name: 'user_id' },
                    { data: 'formatted_created_at', name: 'created_at' },
                    {data: 'actions',name: 'actions',orderable: false,searchable: false},
                ],
                columnDefs: [
                    {
                        "targets": -1,
                        "render": function (data, type, row) {
                            var viewUrl = '{{ route("admin.orders.show", ":id") }}';
                            viewUrl = viewUrl.replace(':id', row.id);

                            var printUrl = '{{ route("admin.orders.invoice", ":id") }}';
                            printUrl = printUrl.replace(':id', row.id);

                            return `<div class='btn-actions'>
                                       <a class="btn btn-success-light" href="${viewUrl}"><i class="fa-solid fa-eye"></i></a>
                                       <a class="btn btn-primary-light" href="${printUrl}"><i class="fa-solid fa-print"></i></a>
                                    </div>`;
                        }
                    }
                ]
            });
        });
    </script>
@endpush
