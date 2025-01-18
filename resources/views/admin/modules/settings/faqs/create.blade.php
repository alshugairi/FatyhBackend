@extends('admin.layouts.app')

@section('content')
    @include('admin.partial.settings.page_header')

    <div class="app-description">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    @include('admin.partial.settings.sidebar')
                </div>
                <div class="col-lg-9 col-md-6 col-sm-12">
                    <form class="validate-form" action="{{ route('admin.faqs.store') }}" method="post" id="submitForm">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.create') }} {{ __('admin.faq') }}</h3>
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
                                                          value="{!! old('question.'.$appLanguage->code) !!}"
                                                          label="true" labelName="{{ __('admin.question') }}"/>
                                            <x-form.textarea type="text" name="answer[{{ $appLanguage->code }}]" required="true"
                                                             key="id-answer-{{ $appLanguage->code }}"
                                                             value="{!! old('answer.'.$appLanguage->code) !!}"
                                                             label="true" labelName="{{ __('admin.answer') }}"/>
                                        </div>
                                    @endforeach
                                </x-layouts.language-tabs>
                                <div class="row">
                                    <x-form.select col="col-md-4" required="true" :options="$faqGroups" name="faq_group_id" labelName="{{ trans('admin.faq_group') }}"/>
                                    <x-form.input col="col-md-4" required="true" type="number" name="order" value="1" labelName="{{ trans('admin.order') }}"/>
                                    <x-form.switch col="col-md-4" name="is_active" value="1" labelName="{{ trans('admin.active') }}"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
