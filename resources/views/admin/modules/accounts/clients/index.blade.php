@extends('admin.layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="page-title">{{ __('admin.clients') }}</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <x-datatable.export/>
                    <x-datatable.filter>
                        <x-slot name="form">
                            <div class="row">
                                <x-form.select col="col-12" label="true" name="filter_user_id" key="filter_userId" classes="ajax_clients" select2="true" labelName="{{ __('ticket.client') }}"/>
                                <x-form.input col="col-12" type="date" name="filter_date_from" key="filter_dateFrom" value="{{ request('date_from') ?? date('Y-m-d') }}" label="true" labelName="{{ __('share.date_from') }}"/>
                                <x-form.input col="col-12" type="date" name="filter_date_to" key="filter_dateTo" value="{{ request('date_to') ?? date('Y-m-d')  }}" label="true" labelName="{{ __('share.date_to') }}"/>
                            </div>
                        </x-slot>
                    </x-datatable.filter>
                    @can('clients.create')
                        <x-datatable.create href="{{ route('admin.clients.create') }}" module="{{ __('admin.client') }}"/>
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
                                <th>{{ __('admin.email') }}</th>
                                <th>{{ __('admin.phone') }}</th>
                                <th>{{ __('admin.active') }}</th>
                                <th>{{ __('admin.created_at') }}</th>
                                @canany(['clients.edit','clients.delete'])
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
                ajax: '{!! route('admin.clients.list') !!}',
                columns: [
                    { data: 'id', name: 'id',visible: false,},
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'status', name: 'status' },
                    { data: 'formatted_created_at', name: 'created_at' },
                        @canany(['clients.edit','clients.delete'])
                    {data: 'actions',name: 'actions',orderable: false,searchable: false},
                    @endcanany
                ],
                columnDefs: [
                    @canany(['clients.edit','clients.delete'])
                    {
                        "targets": -1,
                        "render": function (data, type, row) {
                            var editUrl = '{{ route("admin.clients.edit", ":id") }}';
                            editUrl = editUrl.replace(':id', row.id);

                            var deleteUrl = '{{ route("admin.clients.destroy", ":id") }}';
                            deleteUrl = deleteUrl.replace(':id', row.id);

                            return `<div class='btn-actions'>
                                       @can('clients.edit')
                                        <a class="btn btn-info-light" href="${editUrl}"><i class="fa-solid fa-pen-to-square"></i></a>
                                       @endcan
                                       @can('clients.delete')
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
