@extends('admin.layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="page-title">{{ __('admin.products') }}</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <x-datatable.export/>
                    <x-datatable.filter>
                        <x-slot name="form">
                            <div class="row">
                                <x-form.input col="col-12" name="filter_name" key="filter_name" value="{{ request('name') }}" labelName="{{ __('admin.name') }}"/>
                                <x-form.select col="col-12" name="filter_category_id" key="filter_categoryId" classes="category-select" select2="true" labelName="{{ __('admin.category') }}"/>
                                <x-form.input col="col-12" type="date" name="filter_date_from" key="filter_dateFrom" value="{{ request('date_from') }}" labelName="{{ __('admin.date_from') }}"/>
                                <x-form.input col="col-12" type="date" name="filter_date_to" key="filter_dateTo" value="{{ request('date_to') }}" labelName="{{ __('admin.date_to') }}"/>
                            </div>
                        </x-slot>
                    </x-datatable.filter>
                    @can('admins.create')
                        <x-datatable.create href="{{ route('admin.products.create') }}" module="{{ __('admin.product') }}"/>
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
                                <th>{{ __('admin.category') }}</th>
                                <th>{{ __('admin.sku') }}</th>
                                <th>{{ __('admin.sell_price') }}</th>
                                <th>{{ __('admin.created_at') }}</th>
                                @canany(['products.edit','products.delete'])
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
                ajax: {
                    url: '{!! route('admin.products.list') !!}',
                    data: function (d) {
                        d.name = $('#filterForm #filter_name').val();
                        d.category_id = $('#filterForm #filter_categoryId').val();
                        d.date_from = $('#filterForm #filter_dateFrom').val();
                        d.date_to = $('#filterForm #filter_dateTo').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id',visible: false},
                    { data: 'name', name: 'name' },
                    { data: 'category', name: 'category_id' },
                    { data: 'sku', name: 'sku' },
                    { data: 'sell_price', name: 'sell_price' },
                    { data: 'formatted_created_at', name: 'created_at' },
                    @canany(['products.edit','products.delete'])
                    {data: 'actions',name: 'actions',orderable: false,searchable: false},
                    @endcanany
                ],
                columnDefs: [
                    @canany(['products.edit','products.delete'])
                    {
                        "targets": -1,
                        "render": function (data, type, row) {
                            var editUrl = '{{ route("admin.products.edit", ":id") }}';
                            editUrl = editUrl.replace(':id', row.id);

                            var viewUrl = '{{ route("admin.products.show", ":id") }}';
                            viewUrl = viewUrl.replace(':id', row.id);

                            var deleteUrl = '{{ route("admin.products.destroy", ":id") }}';
                            deleteUrl = deleteUrl.replace(':id', row.id);

                            return `<div class='btn-actions'>
                                       <a class="btn btn-success-light" href="${viewUrl}"><i class="fa-solid fa-eye"></i></a>
                                       @can('products.edit')
                                       <a class="btn btn-info-light" href="${editUrl}"><i class="fa-solid fa-pen-to-square"></i></a>
                                       @endcan
                                       @can('products.delete')
                                       <a class="confirm-delete btn btn-danger-light" data-url="${deleteUrl}"><i class="fa-solid fa-trash-can"></i></a>
                                       @endcan
                                   </div>`;
                        }
                    }
                    @endcanany
                ]
            });

            $('.export-excel').on('click', function(e) {
                e.preventDefault();
                window.location.href = "{{ route('admin.products.export', ['type' => 'excel']) }}";
            });

            $('.export-pdf').on('click', function(e) {
                e.preventDefault();
                window.location.href = "{{ route('admin.products.export', ['type' => 'pdf']) }}";
            });
        });
    </script>
@endpush
