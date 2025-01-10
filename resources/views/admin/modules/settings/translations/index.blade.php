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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('admin.translations') }}</h3>
                        </div>
                        <div class="card-datatable table-responsive p-0">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                <tr>
                                    <th>{{ __('admin.file') }}</th>
                                    @foreach($languages as $lang)
                                        <th>{{ strtoupper($lang) }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $uniqueFiles = array_unique(array_merge(...array_values($files)));
                                    sort($uniqueFiles);
                                @endphp
                                @foreach($uniqueFiles as $file)
                                    <tr>
                                        <td>{{ $file }}.php</td>
                                        @foreach($languages as $lang)
                                            <td>
                                                @if(isset($files[$lang]) && in_array($file, $files[$lang]))
                                                    <a href="{{ route('admin.translations.edit', [$lang, $file]) }}"
                                                       class="btn btn-md btn-primary-light">{{ __('admin.edit') }}</a>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
