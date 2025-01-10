@php
    $referenceTypes = [
        'opening_balance' => __('admin.opening_balance'),
        'capital' => __('admin.capital'),
        'expense' => __('admin.expense'),
        'deposit' => __('admin.deposit'),
        'withdrawal' => __('admin.withdrawal'),
        'adjustment_add' => __('admin.adjustment_add'),
        'adjustment_subtract' => __('admin.adjustment_subtract'),
    ];

    $paymentMethods = [
        'cash' => __('admin.cash'),
        'bank' => __('admin.bank'),
        'stripe' => __('admin.stripe')
    ];
@endphp
<div class="modal fade" id="addTransactionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">{{ __('admin.create_transaction') }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="transactionForm">
                    @csrf
                    <div class="row">
                        <x-form.select col="col-md-6" name="reference_type" :options="$referenceTypes" required="true" labelName="{{ trans('admin.reference_type') }}"/>
                        <x-form.input col="col-md-6" type="number" name="amount" required="true" labelName="{{ trans('admin.amount') }}"/>
                        <x-form.input col="col-md-6" name="reference_id" labelName="{{ trans('admin.reference_id') }}"/>
                        <x-form.select col="col-md-6" name="payment_method" :options="$paymentMethods" required="true" labelName="{{ trans('admin.payment_method') }}"/>
                        <x-form.textarea col="col-md-12" name="notes" labelName="{{ trans('admin.notes') }}"/>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-danger-light" data-bs-dismiss="modal">{{ __('admin.close') }}</button>
                        <button type="submit" class="btn btn-primary-light">{{ __('admin.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
