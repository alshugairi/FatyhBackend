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
                    <form class="validate-form" action="{{ route('admin.faqs.update', $faq->id) }}" method="post" id="submitForm">
                        @method('put')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.edit') }} {{ __('admin.faq') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.faq') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                @php($appLanguages = get_languages())
                                <x-layouts.language-tabs :appLanguages="$appLanguages">
                                    @foreach($appLanguages as $appLanguage)
                                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}" id="navs-top-{{ $appLanguage->id }}" role="tabpanel">
                                            <x-form.input type="text" name="question[{{ $appLanguage->code }}]" required="true"
                                                          key="id-question-{{ $appLanguage->code }}"
                                                          value="{!! $faq->getTranslation('question', $appLanguage->code) !!}"
                                                          label="true" labelName="{{ __('admin.question') }}"/>
                                            <x-form.textarea name="answer[{{ $appLanguage->code }}]" required="true"
                                                             key="id-answer-{{ $appLanguage->code }}"
                                                             value="{!! $faq->getTranslation('answer', $appLanguage->code) !!}"
                                                             label="true" labelName="{{ __('admin.answer') }}"/>
                                        </div>
                                    @endforeach
                                </x-layouts.language-tabs>
                                <div class="row">
                                    <x-form.select col="col-md-4" required="true" :options="$categories" name="category_id" labelName="{{ trans('admin.category') }}" value="{{ $faq->category_id }}"/>
                                    <x-form.input col="col-md-4" required="true" type="number" name="order" value="{{ $faq->order }}" labelName="{{ trans('admin.order') }}"/>
                                    <x-form.switch col="col-md-4" name="is_active" value="{{ $faq->is_active }}" labelName="{{ trans('admin.active') }}"/>
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


