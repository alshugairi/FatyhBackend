@extends('admin.layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="page-title">{{ __('admin.transactions') }}</h3>
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
                    <button type="button" class="btn btn-md btn-primary-light" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span class="d-none d-md-inline-block">{{ __('admin.add_transaction') }}</span>
                    </button>
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
                                <th>{{ __('admin.number') }}</th>
                                <th>{{ __('admin.type') }}</th>
                                <th>{{ __('admin.amount') }}</th>
                                <th>{{ __('admin.balance') }}</th>
                                <th>{{ __('admin.payment_method') }}</th>
                                <th>{{ __('admin.reference_type') }}</th>
                                <th>{{ __('admin.notes') }}</th>
                                <th>{{ __('admin.created_at') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partial.finance.transaction_modal')
@endsection

@push('scripts')
    <script>
        $(function() {
            const table = $('#dt').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 50,
                order: [[ 0, "desc" ]],
                ajax: '{!! route('admin.transactions.list') !!}',
                columns: [
                    { data: 'id', name: 'id', visible: false},
                    { data: 'number', name: 'number' },
                    { data: 'type', name: 'type',
                        render: function(data) {
                            return data === 'debit' ?
                                '<span class="badge bg-success">{{ __('admin.debit') }}</span>' :
                                '<span class="badge bg-danger">{{ __('admin.credit') }}</span>';
                        }
                    },
                    { data: 'amount', name: 'amount',
                        render: function(data, type, row) {
                            const color = row.type === 'debit' ? 'text-success' : 'text-danger';
                            return `<span class="${color}">${row.amount}</span>`;
                        }
                    },
                    { data: 'balance', name: 'balance'},
                    { data: 'payment_method', name: 'payment_method' },
                    { data: 'reference_type', name: 'reference_type' },
                    { data: 'notes', name: 'notes' },
                    { data: 'formatted_created_at', name: 'created_at' },
                ]
            });

            $('#transactionForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route("admin.transactions.store") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#addTransactionModal').modal('hide');
                        table.ajax.reload();
                        toastr.success(response.data.message);
                        $('#transactionForm')[0].reset();
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON.errors) {
                            Object.values(xhr.responseJSON.errors).forEach(error => {
                                toastr.error(error[0]);
                            });
                        } else {
                            toastr.error(xhr.responseJSON.message || 'An error occurred');
                        }
                    }
                });
            });

            $('#addTransactionModal').on('hidden.bs.modal', function() {
                $('#transactionForm')[0].reset();
            });
        });
    </script>
@endpush
