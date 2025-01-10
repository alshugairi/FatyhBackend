<div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="v-pills-seo-tab">
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin.seo') }}</h3>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="" id="seoForm">
                @csrf
                <div class="mb-3">
                    <label for="meta_title" class="form-label">{{ __('admin.meta_title') }} <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title" required value="{{ old('meta_title', $product->meta_title) }}">
                </div>

                <!-- First Quill Editor -->
                <div class="mb-3">
                    <label for="meta_description" class="form-label">{{ __('admin.meta_description') }} <sup class="text-danger">*</sup></label>
                    <textarea class="form-control quill-editor" id="meta_description" name="meta_description" style="display: none;">{{ old('meta_description', $product->meta_description) }}</textarea>
                    <div id="editor_meta_description" class="quill-container">{!! old('meta_description', $product->meta_description) !!}</div>
                </div>

                <div class="mb-3">
                    <label for="focus_keywords" class="form-label">{{ __('admin.meta_keywords') }} <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" required value="{{ old('meta_keywords', $product->meta_keywords) }}">
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary-light">{{ __('admin.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')

    <script>
        $(document).ready(function() {
            $('#seoForm').validate({
                submitHandler: function(form) {
                    $('.quill-editor').each(function() {
                        const textareaId = $(this).attr('id');
                        $(this).val(quillEditors[textareaId].root.innerHTML);
                    });

                    $.ajax({
                        url: '{{ route('admin.products.seo.update', $product->id) }}',
                        method: 'POST',
                        data: $(form).serialize(),
                        success: function(response, status, xhr) {
                            if (xhr.status === 200) {
                                toastr.success("{{ __('admin.success_save') }}");
                                $('.error').remove();
                            }
                        },
                        error: function(xhr) {
                            handleAjaxErrors(xhr);
                        }
                    });
                }
            });
        });
    </script>
@endpush
