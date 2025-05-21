<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ get_setting('company_name', 'Fatyh') }} | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ get_setting('theme_favicon') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/overlayscrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/adminlte.rtl.css">
        <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/rtl.css">
    @else
        <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/adminlte.css">
    @endif
    <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/custom.css">
</head>
<body>
<div class="container-register">
    <div class="left-panel position-relative d-block">
        <div class="position-absolute hand-icon">
            <img class="w-100" src="{{ asset('public/assets/admin/images/hand.png') }}" alt="Hand Icon">
        </div>

        <div class="bottom-0 left-0 position-absolute mb-5 w-100 p-2">
            <h4 class="text-white">
                Partnership for <br> Business Growth
            </h4>
            <small class="text-gray">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididun.</small>
        </div>
    </div>
    <div class="right-panel d-block">
        <div class="mt-2 text-center">
            <img src="{{ asset('public/assets/admin/images/ic_h.svg') }}" alt="User Icon" class="user-icon">
        </div>
        <h2 class="h4 text-center fw-bold">Sign Up Your Account</h2>

        <div class="my-4 text-center">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="accountType" id="individual" value="individual" checked>
                <label class="form-check-label" for="individual">Individual</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="accountType" id="company" value="company">
                <label class="form-check-label" for="company">Company</label>
            </div>
        </div>

        <div id="signupWizard" class="">
            @include('admin.partial.register.individual')
        </div>

        <div id="companyWizard" class="d-none">
{{--            @include('admin.partial.register.company')--}}
        </div>

        <div class="clearfix"></div>
        <div class="mb-3 mt-4 text-center fw-bold">
            <small class="text-muted">Do you have an account?</small>
            <a href="{{ route('admin.login') }}">Log in</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const individualTabs = $('#signupWizard');
        const companyTabs = $('#companyWizard');
        const progressBar = $('.progress-bar');

        // Initial setup for Individual
        updateProgress(100, individualTabs);

        // Switch between Individual and Company
        $('input[name="accountType"]').on('change', function() {
            if ($(this).val() === 'individual') {
                companyTabs.addClass('d-none');
                individualTabs.removeClass('d-none');
                updateProgress(100, individualTabs);
            } else if ($(this).val() === 'company') {
                individualTabs.addClass('d-none');
                companyTabs.removeClass('d-none');
                updateProgress(0, companyTabs);
                updateTab('company-info-tab', companyTabs, companyContent);
                validateAndUpdateTabState('company-info');
            }
        });

        // Next button handlers for Company with validation
        $('#nextCompany').on('click', function() {
            if (validateTab('company-info')) {
                updateTab('owner-info-tab', companyTabs, companyContent);
                updateProgress(25, companyTabs);
                validateAndUpdateTabState('company-info');
            }
        });
        $('#nextOwner').on('click', function() {
            if (validateTab('owner-info')) {
                updateTab('directory-info-tab', companyTabs, companyContent);
                updateProgress(50, companyTabs);
                validateAndUpdateTabState('owner-info');
            }
        });
        $('#nextDirectory').on('click', function() {
            if (validateTab('directory-info')) {
                updateTab('partners-info-tab', companyTabs, companyContent);
                updateProgress(75, companyTabs);
                validateAndUpdateTabState('directory-info');
            }
        });
        $('#nextPartners').on('click', function() {
            updateTab('password-tab', companyTabs, companyContent);
            updateProgress(100, companyTabs);
            validateAndUpdateTabState('partners-info');
        });

        // Back button handlers for Company
        $('#backOwner').on('click', function() {
            updateTab('company-info-tab', companyTabs, companyContent);
            updateProgress(0, companyTabs);
        });
        $('#backDirectory').on('click', function() {
            updateTab('owner-info-tab', companyTabs, companyContent);
            updateProgress(25, companyTabs);
        });
        $('#backPartners').on('click', function() {
            updateTab('directory-info-tab', companyTabs, companyContent);
            updateProgress(50, companyTabs);
        });
        $('#backPassword').on('click', function() {
            updateTab('partners-info-tab', companyTabs, companyContent);
            updateProgress(75, companyTabs);
        });

        function updateTab(tabId, tabList, content) {
            tabList.find('.nav-link').removeClass('active');
            content.find('.tab-pane').removeClass('show active');
            $('#' + tabId).addClass('active');
            $('#' + tabId.replace('-tab', '')).addClass('show active');
        }

        function updateProgress(percentage, tabList) {
            progressBar.css('width', percentage + '%');
            progressBar.attr('aria-valuenow', percentage);
        }

        function validateTab(tabId) {
            let isValid = true;
            $('#' + tabId + ' .required-field').each(function() {
                if ($(this).is('select') && $(this).val() === '') {
                    isValid = false;
                } else if ($(this).is('input') && !$(this).val()) {
                    isValid = false;
                } else if ($(this).is('input[type="file"]') && !$(this)[0].files.length) {
                    isValid = false;
                }
            });
            return isValid;
        }

        function validateAndUpdateTabState(tabId) {
            const tabIndex = $('#' + tabId).index();
            if (validateTab(tabId)) {
                companyTabs.find('.nav-link').eq(tabIndex).addClass('completed').removeClass('active');
                companyTabs.find('.nav-link').eq(tabIndex).find('span').removeClass('dot-active').addClass('dot-completed');
            }
        }

        // Real-time validation on input change
        $('.required-field').on('change', function() {
            const tabId = $(this).closest('.tab-pane').attr('id');
            if (validateTab(tabId)) {
                const tabIndex = $('#' + tabId).index();
                companyTabs.find('.nav-link').eq(tabIndex).addClass('completed').removeClass('active');
                companyTabs.find('.nav-link').eq(tabIndex).find('span').removeClass('dot-active').addClass('dot-completed');
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
