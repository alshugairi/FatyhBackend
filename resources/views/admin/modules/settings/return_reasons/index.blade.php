@extends('admin.layouts.app')

@section('content')
    @include('admin.partial.settings.page_header')

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    @include('admin.partial.settings.sidebar')
                </div>
                <div class="col-lg-9 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('admin.return_reasons') }}</h3>
                            <div class="card-tools">
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
                                @can('admins.create')
                                    <x-datatable.create href="{{ route('admin.return_reasons.create') }}" module="{{ __('admin.return_reason') }}"/>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dt" class="table w-100">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>{{ __('admin.name') }}</th>
                                        <th>{{ __('admin.created_at') }}</th>
                                        @canany(['return_reasons.edit','return_reasons.delete'])
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
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(function() {
            dataTable = $('#dt').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                order: [[ 0, "desc" ]],
                ajax: {
                    url: '{!! route('admin.return_reasons.list') !!}',
                    data: function (d) {
                        d.type = "{{ request('type') }}";
                    }
                },
                columns: [
                    { data: 'id', name: 'id',visible: false},
                    { data: 'name', name: 'name' },
                    { data: 'formatted_created_at', name: 'created_at' },
                    @canany(['return_reasons.edit','return_reasons.delete'])
                    {data: 'actions',name: 'actions',orderable: false,searchable: false},
                    @endcanany
                ],
                columnDefs: [
                        @canany(['return_reasons.edit','return_reasons.delete'])
                    {
                        "targets": -1,
                        "render": function (data, type, row) {
                            var editUrl = '{{ route("admin.return_reasons.edit", ":id") }}';
                            editUrl = editUrl.replace(':id', row.id);

                            var deleteUrl = '{{ route("admin.return_reasons.destroy", ":id") }}';
                            deleteUrl = deleteUrl.replace(':id', row.id);

                            return `<div class='btn-actions'>
                                       @can('admins.edit')
                                       <a class="btn btn-info-light" href="${editUrl}"><i class="fa-solid fa-pen-to-square"></i></a>
                                       @endcan
                                       @can('admins.delete')
                                       <a class="confirm-delete btn btn-danger-light" data-url="${deleteUrl}"><i class="fa-solid fa-trash-can"></i></a>
                                       @endcan
                                  </div>`;
                        }
                    }
                    @endcanany
                ],
                select: { style: 'multi', selector: 'td:first-child' },
            });
        });
    </script>
@endpush
