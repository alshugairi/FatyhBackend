@extends('frontend.layouts.app')

@section('content')
    <div class="page-title" style="background-image: url()">
        <div class="wide-container">
            <h1>{{ __('frontend.contact') }}</h1>
        </div>
    </div>

    <div class="wide-container mt-60 mb-60">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4" data-aos="fade-right">
                <div class="contact-info-box h-100 floating">
                    <div class="p-4">
                        <h3 class="fw-bold mb-4">{{ __('frontend.contact_information') }}</h3>
                        <div class="mb-4">
                            <h6 class="fw-bold">
                                <i class="fas fa-map-marker-alt fa-lg rounded-icon"></i>
                                <span class="mx-1">{{ __('frontend.address') }}</span>
                            </h6>
                            <p class="mb-0">{{ get_setting('company_address') }}</p>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold">
                                <i class="fas fa-phone fa-lg rounded-icon"></i>
                                <span class="mx-1">{{ __('frontend.phone') }}</span>
                            </h6>
                            <p class="mb-0">{{ get_setting('company_phone') }}</p>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold">
                                <i class="fas fa-envelope fa-lg rounded-icon"></i>
                                <span class="mx-1">{{ __('frontend.email') }}</span>
                            </h6>
                            <p class="mb-0">{{ get_setting('company_email') }}</p>
                        </div>
                        <div class="social-links mt-5 rounded-social">
                            @php
                                $facebook = get_setting('social_facebook');
                                $twitter = get_setting('social_twitter');
                                $instagram = get_setting('social_instagram');
                                $youtube = get_setting('social_youtube');
                                $linkedin = get_setting('social_linkedin');
                            @endphp

                            @if($facebook)
                                <a href="{{ $facebook }}" target="_blank"><i class="fab fa-facebook"></i></a>
                            @endif

                            @if($twitter)
                                <a href="{{ $twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
                            @endif

                            @if($instagram)
                                <a href="{{ $instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
                            @endif

                            @if($youtube)
                                <a href="{{ $youtube }}" target="_blank"><i class="fab fa-youtube"></i></a>
                            @endif

                            @if($linkedin)
                                <a href="{{ $linkedin }}" target="_blank"><i class="fab fa-linkedin"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8" data-aos="fade-left">
                <div class="contact-card p-4">
                    <form action="{{ route('contact.send') }}" method="post" id="contactForm">
                        @csrf
                        <div class="row g-3">
                            <x-form.input col="col-md-6" name="name" required="true" labelClass="fw-600" labelName="{{ __('frontend.name') }}"/>
                            <x-form.input col="col-md-6" name="email" required="true"  labelClass="fw-600" labelName="{{ __('frontend.email') }}"/>
                            <x-form.input col="col-md-6" name="phone" required="true"  labelClass="fw-600" labelName="{{ __('frontend.phone') }}"/>
                            <x-form.input col="col-md-6" name="subject" required="true"  labelClass="fw-600" labelName="{{ __('frontend.subject') }}"/>
                            <x-form.textarea col="col-md-12" name="message" required="true"  labelClass="fw-600" labelName="{{ __('frontend.message') }}"/>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="captcha">
                                        <img src="{{ url('/captcha') }}?{{ time() }}" alt="captcha" id="captcha-image">
                                        <button type="button" class="btn btn-danger" id="reload-captcha">
                                            &#x21bb;
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <input id="captcha" type="text" class="form-control" placeholder="{{ __('frontend.enter_captcha') }}" name="captcha" required>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-dark w-100">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    <span>{{ __('frontend.send_message') }}</span>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="messageBox" class="mt-3" style="display: none;"></div>
                </div>
            </div>
        </div>

        @if(get_setting('map_visible'))
        <div class="map-container mt-5" data-aos="zoom-in">
            <iframe
                src="https://www.google.com/maps?q={{ get_setting('map_latitude') }},{{ get_setting('map_longitude') }}&hl=es;z=14&output=embed"
                width="100%"
                height="500"
                style="border:0;"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#reload-captcha').click(function () {
                $.ajax({
                    type: 'GET',
                    url: '/reload-captcha',
                    success: function (data) {
                        $("#captcha-image").attr('src', data.captcha_url);
                    }
                });
            });

            $('#contactForm').on('submit', function(e) {
                e.preventDefault();

                var $submitButton = $(this).find('button[type="submit"]');
                $submitButton.prop('disabled', true);

                $.ajax({
                    url: "{{ route('contact.send') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#messageBox').html('<div class="alert alert-success">' + response.message + '</div>').show();
                        $('#contactForm')[0].reset();
                        $submitButton.prop('disabled', false);
                        $('#reload-captcha').click();
                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        var errorMessage = '<div class="alert alert-danger"><ul>';
                        $.each(errors, function(key, value) {
                            errorMessage += '<li>' + value + '</li>';
                        });
                        errorMessage += '</ul></div>';
                        $('#messageBox').html(errorMessage).show();
                        $submitButton.prop('disabled', false);
                        $('#reload-captcha').click();
                    }
                });
            });
        });
    </script>
@endpush
