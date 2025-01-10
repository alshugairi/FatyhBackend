<div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="v-pills-gallery-tab">
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin.gallery') }}</h3>
            <div class="card-tools">
                <a class="btn btn-md btn-primary-light" data-bs-toggle="modal" data-bs-target="#uploadImageModal">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span class="d-md-inline-block d-none">
                                                {{ __('admin.upload_image') }}
                                            </span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-warning mb-4">{{ __('admin.image_sorting_alert') }}</div>
            <div class="row" id="productImages">
                @foreach($product->images as $productImage)
                    <div class="col-md-3 position-relative sortable-item" data-id="{{ $productImage->id }}">
                        <div class="card mb-3 border">
                            <button class="btn btn-danger btn-sm delete-image position-absolute rounded-circle" data-id="{{ $productImage->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <img src="{{ get_full_image_url($productImage->image_path) }}" alt="{{ $productImage->alt_text }}" class="card-img">
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal fade" id="uploadImageModal" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="imageForm" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h6 class="modal-title fw-bold">{{ __('admin.new_image') }}</h6>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="image_file" class="form-label">{{ __('admin.image') }} <sup class="text-danger">*</sup></label>
                                    <input type="file" class="form-control" id="image_file" name="image_file" accept="image/*" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger-light" data-bs-dismiss="modal">{{ __('admin.close') }}</button>
                                <button type="submit" class="btn btn-primary-light">{{ __('admin.upload') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        $(document).ready(function() {

            new Sortable(document.getElementById('productImages'), {
                animation: 150,
                handle: '.sortable-item',
                onEnd: function (evt) {
                    var positions = [];
                    $('.sortable-item').each(function(index) {
                        positions.push({
                            id: $(this).data('id'),
                            position: index + 1
                        });
                    });

                    $.ajax({
                        url: '{{ route('admin.products.images.reorder', $product->id) }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            positions: positions
                        },
                        success: function(response) {
                            toastr.success(response.message);
                        },
                        error: function(xhr) {
                            handleAjaxErrors(xhr);
                            $('#productImages').sortable('cancel');
                        }
                    });
                }
            });

            $('#imageForm').validate({
                submitHandler: function(form) {
                    let formData = new FormData(form);

                    $.ajax({
                        url: '{{ route('admin.products.images.upload', $product->id) }}',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response, status, xhr) {
                            if (xhr.status === 200) {
                                toastr.success("{{ __('admin.success_save') }}");
                                $(form)[0].reset();
                                $('.error').remove();
                                $('#uploadImageModal').modal('hide');

                                var html  = `<div class="col-md-3 position-relative sortable-item" data-id="${ response.data.id }">
                                        <div class="card mb-3">
                                            <button class="btn btn-danger btn-sm delete-image position-absolute rounded-circle" data-id="${ response.data.id }">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <img src="${ response.data.image_path }" alt="image" class="card-img">
                                        </div>
                                    </div>`;

                                $('#productImages').append(html);

                                var newSortableItem = $('#productImages').find('.sortable-item:last-child');
                                Sortable.onAdd(document.getElementById('productImages'), newSortableItem.get(0));
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
