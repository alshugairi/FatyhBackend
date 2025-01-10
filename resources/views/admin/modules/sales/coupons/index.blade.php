@extends('admin.layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="page-title">{{ __('admin.coupons') }}</h3>
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
                        <x-datatable.create href="{{ route('admin.coupons.create') }}" module="{{ __('admin.coupon') }}"/>
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
                                <th>{{ __('admin.code') }}</th>
                                <th>{{ __('admin.type') }}</th>
                                <th>{{ __('admin.value') }}</th>
                                <th>{{ __('admin.max_usage') }}</th>
                                <th>{{ __('admin.start_date') }}</th>
                                <th>{{ __('admin.end_date') }}</th>
                                <th>{{ __('admin.usage_count') }}</th>
                                <th>{{ __('admin.created_at') }}</th>
                                @canany(['coupons.edit','coupons.delete'])
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
                ajax: '{!! route('admin.coupons.list') !!}',
                columns: [
                    { data: 'id', name: 'id',visible: false},
                    { data: 'name', name: 'name' },
                    { data: 'code', name: 'code' },
                    { data: 'type', name: 'type' },
                    { data: 'value', name: 'value' },
                    { data: 'max_usage', name: 'max_usage' },
                    { data: 'formatted_start_date', name: 'start_date' },
                    { data: 'formatted_end_date', name: 'end_date' },
                    { data: 'usage_count', name: 'usage_count' },
                    { data: 'formatted_created_at', name: 'created_at' },
                        @canany(['coupons.edit','coupons.delete'])
                    {data: 'actions',name: 'actions',orderable: false,searchable: false},
                    @endcanany
                ],
                columnDefs: [
                        @canany(['coupons.edit','coupons.delete'])
                    {
                        "targets": -1,
                        "render": function (data, type, row) {
                            var editUrl = '{{ route("admin.coupons.edit", ":id") }}';
                            editUrl = editUrl.replace(':id', row.id);

                            var deleteUrl = '{{ route("admin.coupons.destroy", ":id") }}';
                            deleteUrl = deleteUrl.replace(':id', row.id);

                            return `<div class='btn-actions'>
                                       @can('coupons.edit')
                                       <a class="btn btn-info-light" href="${editUrl}"><i class="fa-solid fa-pen-to-square"></i></a>
                                       @endcan
                                       @can('coupons.delete')
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
