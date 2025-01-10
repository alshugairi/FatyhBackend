<div class="tab-pane fade" id="videos" role="tabpanel" aria-labelledby="v-pills-videos-tab">
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">{{ __('admin.videos') }}</h3>
            <div class="card-tools">
                <a class="btn btn-md btn-primary-light" data-bs-toggle="modal" data-bs-target="#uploadVideoModal">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span class="d-md-inline-block d-none">{{ __('admin.add_video') }}</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div id="productVideos">
                <div class="table-responsive">
                    <table id="dt" class="table w-100">
                        <thead>
                            <tr>
                                <th>{{ __('admin.provider') }}</th>
                                <th>{{ __('admin.link') }}</th>
                                <th>{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($product->videos as $productVideo)
                            <tr>
                                <td>{{ __('admin.'.$productVideo->provider) }}</td>
                                <td>{{ $productVideo->video_path }}</td>
                                <td>
                                    <div class='btn-actions'>
                                        <a class="confirm-delete btn btn-danger-light" data-url=""><i class="fa-solid fa-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade" id="uploadVideoModal" tabindex="-1" role="dialog" aria-labelledby="uploadVideoModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="videoForm" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h6 class="modal-title fw-bold">{{ __('admin.add_video') }}</h6>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="provider" class="form-label">{{ __('admin.provider') }} <sup class="text-danger">*</sup></label>
                                    <select class="form-control form-select" id="provider" name="provider" required>
                                        <option value="">{{ __('admin.select') }}</option>
                                        <option value="youtube">{{ __('admin.youtube') }}</option>
                                        <option value="vimeo">{{ __('admin.vimeo') }}</option>
                                        <option value="dailymotion">{{ __('admin.dailymotion') }}</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="video_path" class="form-label">{{ __('admin.link') }} <sup class="text-danger">*</sup></label>
                                    <input type="url" class="form-control" id="video_path" name="video_path" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger-light" data-bs-dismiss="modal">{{ __('admin.close') }}</button>
                                <button type="submit" class="btn btn-primary-light">{{ __('admin.add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#videoForm').validate({
                submitHandler: function(form) {
                    $.ajax({
                        url: '{{ route('admin.products.videos.upload', $product->id) }}',
                        method: 'POST',
                        data: $(form).serialize(),
                        success: function(response, status, xhr) {
                            if (xhr.status === 200) {
                                toastr.success("{{ __('admin.success_save') }}");
                                $(form)[0].reset();
                                $('.error').remove();
                                $('#uploadVideoModal').modal('hide');

                                var html = `<tr>
                                                <td>${ response.data.provider }</td>
                                                <td>${ response.data.video_path }</td>
                                                <td>
                                                    <div class='btn-actions'>
                                                        <a class="confirm-delete btn btn-danger-light" data-url=""><i class="fa-solid fa-trash-can"></i></a>
                                                    </div>
                                                </td>
                                            </tr>`;
                                $('#productVideos table tbody').append(html);
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
