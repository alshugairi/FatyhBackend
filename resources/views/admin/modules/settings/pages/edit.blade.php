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
                    <form action="{{ route('admin.pages.update', $page->id) }}" method="post" id="submitForm">
                        @method('put')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.edit') }} {{ __('admin.page') }}</h3>
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
                                                              value="{!! $page->getTranslation('name', $appLanguage->code) !!}"
                                                              label="true" labelName="{{ __('admin.name') }}"/>
                                                <x-form.textarea name="content[{{ $appLanguage->code }}]" required="true"
                                                                 key="id-content-{{ $appLanguage->code }}"
                                                                 classes="editor"
                                                                 value="{!! $page->getTranslation('content', $appLanguage->code) !!}"
                                                                 label="true" labelName="{{ __('admin.content') }}"/>
                                            </div>
                                        </div>
                                    @endforeach
                                </x-layouts.language-tabs>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/ckeditor5-classic-free-full-feature@35.4.1/build/ckeditor.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.editor').forEach(function (editorElement) {
                ClassicEditor
                    .create(editorElement, {

                        removePlugins: ['Markdown'],
                        htmlSupport: {
                            allow: [
                                {
                                    name: /.*/,
                                    attributes: true,
                                    classes: true,
                                    styles: true
                                }
                            ]
                        }
                    })
                    .then(editor => {
                        editor.model.document.on('change:data', () => {
                            const data = editor.getData();
                            const cleanData = data.replace(/\*\*(.*?)\*\*/g, '$1');
                            editorElement.value = cleanData;
                            console.log('Editor content:', cleanData);
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>
@endpush

