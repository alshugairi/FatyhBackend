<div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add-client-form">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold">{{ __('admin.new_client') }}</h6>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label" for="client-name">{{ __('admin.name') }}</label>
                        <input type="text" class="form-control" id="client-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="client-phone">{{ __('admin.phone') }}</label>
                        <input type="text" class="form-control" id="client-phone" name="phone">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger-light" data-bs-dismiss="modal">{{ __('admin.close') }}</button>
                    <button type="submit" class="btn btn-primary-light">{{ __('admin.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#add-client-form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('admin.clients.ajaxStore') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response, status, xhr) {
                        if (xhr.status === 200) {
                            var newClient = response.data;
                            $('#clientSelect').append(new Option(newClient.name, newClient.id));
                            $('#clientSelect').val(newClient.id).trigger('change');
                            $('#addClientModal').modal('hide');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = "{{ __('admin.please_correct_errors') }}" + '\n';
                            Object.keys(errors).forEach(key => {
                                errorMessage += `- ${errors[key][0]}\n`;
                            });

                            Swal.fire({
                                title: "{{ __('admin.validation_error') }}",
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: "{{ __('admin.unknown_error') }}",
                                text: "{{ __('admin.failed_to_place_order') }}" +' '+ (xhr.responseJSON?.message || "{{ __('admin.unknown_error') }}"),
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
