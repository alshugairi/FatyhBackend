<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() === 'ar') dir="rtl" @endif>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ get_setting('company_name', 'Shopifyze') }} | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ get_setting('theme_favicon') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/overlayscrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/adminlte.rtl.css">
        <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/rtl.css">
    @else
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/adminlte.css">
    @endif
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/custom.css">
    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary">
<div class="app-wrapper">
