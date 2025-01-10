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
                    <form action="{{ route('admin.translations.update', [$lang, $file]) }}" method="post" id="submitForm">
                        @method('put')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.edit') }} {{ __('admin.translations') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.translations') }}"/>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                        <tr>
                                            <th style="width: 30%;">{{ __('admin.key') }}</th>
                                            <th>{{ __('admin.value') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($translations as $key => $value)
                                            <tr>
                                                <td>
                                                    <code>{{ $key }}</code>
                                                </td>
                                                <td>
                                                    @if(is_array($value))
                                                        @foreach($value as $subKey => $subValue)
                                                            <div class="form-group">
                                                                <label><code>{{ $subKey }}</code></label>
                                                                <input type="text" name="translations[{{ $key }}][{{ $subKey }}]"
                                                                       value="{{ htmlspecialchars_decode(is_array($subValue) ? json_encode($subValue) : $subValue) }}"
                                                                       class="form-control">
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <input type="text" name="translations[{{ $key }}]"
                                                               value="{{ htmlspecialchars_decode($value) }}" class="form-control">
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

