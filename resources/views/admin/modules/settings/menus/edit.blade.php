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
                    <form action="{{ route('admin.menus.update', $menu->id) }}" method="post" id="submitForm">
                        @method('put')
                        @csrf
                        <input type="hidden" name="menu_items_structure" id="menu_items_structure" value="@json($formattedItems)">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.edit') }} {{ __('admin.menu') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.menu') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                @php($appLanguages = get_languages())
                                <x-layouts.language-tabs :appLanguages="$appLanguages">
                                    @foreach($appLanguages as $appLanguage)
                                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}" id="navs-top-{{ $appLanguage->id }}" role="tabpanel">
                                            <div class="row">
                                                <x-form.input type="text" name="name[{{ $appLanguage->code }}]" required="true"
                                                              key="id-name-{{ $appLanguage->code }}" required="true"
                                                              value="{{ $menu->getTranslation('name', $appLanguage->code) }}"
                                                              label="true" labelName="{{__('admin.name') }}"/>
                                            </div>
                                        </div>
                                    @endforeach
                                </x-layouts.language-tabs>

                                <div class="row">
                                    <div class="col-md-4">
                                        @include('admin.partial.menus.menu_options')
                                    </div>

                                    <div class="col-md-8">
                                        <div class="border p-2 rounded mh-400">
                                            <div class="fw-600 mb-3">{{ __('admin.menu_items') }}</div>
                                            <div id="menu-items" class="accordion" style="min-height: 180px">
                                                @foreach($formattedItems as $menuItem)
                                                    @include('admin.partial.menus.menu_item', ['item' => $menuItem, 'level' => 0])
                                                @endforeach
                                            </div>

                                            <div>
                                                <x-form.switch name="status" value="1" labelName="{{ trans('admin.active') }}" value="{{ $menu->status }}"/>
                                                <label class="form-label fw-600">{{ __('admin.select_menu_position') }}</label>
                                                <div id="position-select" class="position-group">
                                                    <input type="hidden" name="position" id="position-value" value="{{ old('position', $menu->position ?? '') }}">

                                                    <div id="position-select" class="position-group @error('position') is-invalid @enderror">
                                                        <div>
                                                            <input type="checkbox" value="primary" id="primary" class="position-checkbox"
                                                                {{ $menu->position == 'primary' ? 'checked' : '' }}>
                                                            <label class="fw-500" for="primary">{{ __('admin.primary') }}</label>
                                                        </div>
                                                        <div>
                                                            <input type="checkbox" value="footer" id="footer" class="position-checkbox"
                                                                {{ $menu->position == 'footer' ? 'checked' : '' }}>
                                                            <label class="fw-500" for="footer">{{ __('admin.footer') }}</label>
                                                        </div>
{{--                                                        <div>--}}
{{--                                                            <input type="checkbox" value="topbar" id="topbar" class="position-checkbox"--}}
{{--                                                                {{ $menu->position == 'topbar' ? 'checked' : '' }}>--}}
{{--                                                            <label class="fw-500" for="topbar">{{ __('admin.topbar') }}</label>--}}
{{--                                                        </div>--}}
                                                    </div>
                                                    @error('position')
                                                    <span class="text-danger fw-bold">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                @error('position')
                                                <span class="text-danger fw-bold">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.partial.menus.scripts', ['counter' => $counter])
