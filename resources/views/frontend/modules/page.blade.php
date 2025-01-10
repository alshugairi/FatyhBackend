@extends('frontend.layouts.app')

@section('content')
    <div class="page-title" style="background-image: url()">
        <div class="wide-container">
            <h1>{{ $page->name }}</h1>
        </div>
    </div>

    <div class="wide-container mt-60 mb-60">
        {!! $page->content !!}
    </div>
@endsection
