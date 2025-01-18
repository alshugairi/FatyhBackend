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
                    <form class="validate-form" action="{{ route('admin.pages.store') }}" method="post" id="submitForm">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.create') }} {{ __('admin.page') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.page') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                @php($appLanguages = get_languages())
                                <x-layouts.language-tabs :appLanguages="$appLanguages">
                                    @foreach($appLanguages as $appLanguage)
                                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}" id="navs-top-{{ $appLanguage->id }}" role="tabpanel">
                                            <div class="row">
                                                <x-form.input type="text" name="name[{{ $appLanguage->code }}]" required="true"
                                                              key="id-name-{{ $appLanguage->code }}"
                                                              value="{!! old('name.'.$appLanguage->code) !!}"
                                                              label="true" labelName="{{ __('admin.name') }}"/>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label">{{ __('admin.content') }}</label>
                                                    <textarea class="form-control quill-editor"
                                                              id="content_{{ $appLanguage->code }}"
                                                              name="content[{{ $appLanguage->code }}]"
                                                              style="display: none;">{{ old('content.'.$appLanguage->code) }}</textarea>
                                                    <div id="editor_content_{{ $appLanguage->code }}"
                                                         class="quill-container">{!! old('content.'.$appLanguage->code) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </x-layouts.language-tabs>
                                <div>
                                    <label class="form-label">
                                        <span>Page Slug: </span>
                                        <sup class="text-danger">*</sup>
                                        <a class="mx-2 text-primary" href="javascript:void(0)">
                                            {{ url('/').'/page/' }}<span class="slug-preview"></span>
                                        </a>
                                    </label>
                                    <input type="text" class="form-control slug-input @error('slug') is-invalid @enderror"
                                           name="slug" value="{{ old('slug') }}" required>
                                    @error('slug') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#submitForm').on('submit', function(e) {
            $('.quill-editor').each(function() {
                const textareaId = $(this).attr('id');
                $(this).val(quillEditors[textareaId].root.innerHTML);
            });
        });
    </script>
@endpush

