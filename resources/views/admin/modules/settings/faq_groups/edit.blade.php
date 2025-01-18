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
                    <form class="validate-form" action="{{ route('admin.faq_groups.update', $faqGroup->id) }}" method="post" id="submitForm">
                        @method('put')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.edit') }} {{ __('admin.faq_group') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.faq_group') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                @php($appLanguages = get_languages())
                                <x-layouts.language-tabs :appLanguages="$appLanguages">
                                    @foreach($appLanguages as $appLanguage)
                                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}" id="navs-top-{{ $appLanguage->id }}" role="tabpanel">
                                            <x-form.input type="text" name="name[{{ $appLanguage->code }}]" required="true"
                                                          key="id-name-{{ $appLanguage->code }}"
                                                          value="{!! $faqGroup->getTranslation('name', $appLanguage->code) !!}"
                                                          label="true" labelName="{{ __('admin.name') }}"/>
                                            <x-form.textarea type="text" name="description[{{ $appLanguage->code }}]"
                                                             key="id-description-{{ $appLanguage->code }}"
                                                             value="{!! $faqGroup->getTranslation('description', $appLanguage->code) !!}"
                                                             label="true" labelName="{{ __('admin.description') }}"/>
                                        </div>
                                    @endforeach
                                </x-layouts.language-tabs>
                                <div class="row">
                                    <x-form.input col="col-md-4" required="true" type="number" name="order" value="{{ $faqGroup->order }}" labelName="{{ trans('admin.order') }}"/>
                                    <x-form.switch col="col-md-4" name="is_active" value="{{ $faqGroup->is_active }}" labelName="{{ trans('admin.active') }}"/>
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


