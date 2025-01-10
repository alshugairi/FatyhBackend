<footer>
    <div class="wide-container">
        <div class="row">
            <div class="col-md-3 mb-4">
                <img src="{{ get_setting('theme_light_logo') }}" alt="{{ get_setting('company_name') }}" class="mb-4" style="height: 40px;">
                <div class="subscribe-form">
                    <form class="d-flex">
                        <input type="email" class="form-control" placeholder="Your email address">
                        <button class="btn btn-danger" type="submit">Subscribe</button>
                    </form>
                </div>
                <div class="social-links mt-4">
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
            <div class="col-md-1 mb-4"></div>

            @php
                $footerMenu = get_menu(position: 'footer');

                $menuItems = $footerMenu->items;
                $halfCount = ceil($menuItems->count() / 2);

                $firstColumnItems = $menuItems->slice(0, $halfCount);
                $secondColumnItems = $menuItems->slice($halfCount);
            @endphp

            <div class="col-md-2 mb-4">
                <ul class="list-unstyled">
                    @foreach($firstColumnItems as $menuItem)
                        <li><a href="{{ $menuItem->url }}">{{ !empty($menuItem->translation_key) ? __('frontend.'.$menuItem->translation_key) : $menuItem->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <ul class="list-unstyled">
                    @foreach($secondColumnItems as $menuItem)
                        <li><a href="{{ $menuItem->url }}">{{ !empty($menuItem->translation_key) ? __('frontend.'.$menuItem->translation_key) : $menuItem->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-3 mb-4">
                <h5>{{ __('frontend.contact') }}</h5>
                <ul class="list-unstyled">
                    <li>{{ get_setting('company_address') }}</li>
                    <li><a href="mailto:{{ get_setting('company_email') }}">{{ get_setting('company_email') }}</a></li>
                    <li><a href="tel:{{ get_setting('company_phone') }}">{{ get_setting('company_phone') }}</a></li>
                </ul>
                <div class="store-badges mt-3">
                    @php
                        $androidLink = get_setting('site_android_app_link');
                        $iosLink = get_setting('site_ios_app_link');
                    @endphp
                    @if($androidLink)
                        <a href="{{ $androidLink }}"><img src="{{ asset('assets/frontend') }}/images/google-play.svg" alt="{{ __('frontend.get_from_google_play') }}"></a>
                    @endif
                    @if($iosLink)
                        <a href="{{ $iosLink }}"><img src="{{ asset('assets/frontend') }}/images/app-store.svg" alt="{{ __('frontend.get_from_app_store') }}"></a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom text-center">
            <p class="mb-0">© {{ __('frontend.copyrights') }}</p>
        </div>
    </div>
</footer>

<script src="{{ asset('assets/frontend') }}/js/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/jquery-migrate-1.2.1.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/toastr.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/scripts.js"></script>
@stack('scripts')
<script>
    const appLocale = "{{ app()->getLocale() }}";
    const textDirection = appLocale === 'ar' ? 'rtl' : 'ltr';
</script>
</body>
</html>
