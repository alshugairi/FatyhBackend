<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row w-100 m-0">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-success-light w-100" onclick="printContent('invoiceModalBody')">
                            <i class="fa-solid fa-print"></i> {{ __('admin.print') }}
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-danger-light w-100" onclick="closeModal()">
                            <i class="fa-regular fa-circle-xmark"></i> {{ __('admin.close') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body" id="invoiceModalBody">
            </div>
        </div>
    </div>
</div>
