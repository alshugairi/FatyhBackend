@extends('admin.layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="page-title">{{ __('admin.purchases') }}</h3>
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
                    @can('purchases.create')
                        <x-datatable.create href="{{ route('admin.purchases.create') }}" module="{{ __('admin.purchase') }}"/>
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
                                <th>{{ __('admin.supplier') }}</th>
                                <th>{{ __('admin.reference_no') }}</th>
                                <th>{{ __('admin.date') }}</th>
                                <th>{{ __('admin.total') }}</th>
                                <th>{{ __('admin.created_at') }}</th>
                                @canany(['purchases.edit','purchases.delete'])
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
            $('#dt').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                order: [[ 0, "desc" ]],
                ajax: '{!! route('admin.purchases.list') !!}',
                columns: [
                    { data: 'id', name: 'id',visible: false},
                    { data: 'supplier', name: 'supplier_id' },
                    { data: 'number', name: 'number' },
                    { data: 'formatted_date', name: 'date' },
                    { data: 'total', name: 'total' },
                    { data: 'formatted_created_at', name: 'created_at' },
                    @canany(['purchases.edit','purchases.delete'])
                    {data: 'actions',name: 'actions',orderable: false,searchable: false},
                    @endcanany
                ],
                columnDefs: [
                    @canany(['purchases.view','purchases.edit','purchases.delete'])
                    {
                        "targets": -1,
                        "render": function (data, type, row) {
                            var editUrl = '{{ route("admin.purchases.edit", ":id") }}';
                            editUrl = editUrl.replace(':id', row.id);

                            var viewUrl = '{{ route("admin.purchases.show", ":id") }}';
                            viewUrl = viewUrl.replace(':id', row.id);

                            var deleteUrl = '{{ route("admin.purchases.destroy", ":id") }}';
                            deleteUrl = deleteUrl.replace(':id', row.id);

                            return `<div class='btn-actions'>
                                       <a class="btn btn-success-light" href="${viewUrl}"><i class="fa-solid fa-eye"></i></a>
                                       @can('purchases.edit')
                                       <a class="btn btn-info-light" href="${editUrl}"><i class="fa-solid fa-pen-to-square"></i></a>
                                       @endcan
                                       @can('purchases.delete')
                                       <a class="confirm-delete btn btn-danger-light" data-url="${deleteUrl}"><i class="fa-solid fa-trash-can"></i></a>
                                       @endcan
                                   </div>`;
                        }
                    }
                    @endcanany
                ]
            });
        });
    </script>
@endpush
