<div class="card">
    <div class="card-body">
        <div class="list-items">
            <a href="{{ route('admin.settings.company') }}" class="list-item d-block {{ $designHelper::isActive(['company'])}}">
                <i class="fa-solid fa-building me-2"></i> {{ __('admin.company') }}
            </a>
            <a href="{{ route('admin.settings.site') }}" class="list-item d-block {{ $designHelper::isActive(['site'])}}">
                <i class="fa-solid fa-server me-2"></i> {{ __('admin.site') }}
            </a>
            <a href="{{ route('admin.settings.social') }}" class="list-item d-block {{ $designHelper::isActive(['social'])}}">
                <i class="fa-solid fa-hashtag me-2"></i> {{ __('admin.social_media') }}
            </a>
            <a href="{{ route('admin.settings.mail') }}" class="list-item d-block {{ $designHelper::isActive(['mail'])}}">
                <i class="fa-solid fa-envelope me-2"></i> {{ __('admin.mail') }}
            </a>
            <a href="{{ route('admin.settings.map') }}" class="list-item d-block {{ $designHelper::isActive(['map'])}}">
                <i class="fa-solid fa-map-location-dot me-2"></i> {{ __('admin.map') }}
            </a>
            <a href="{{ route('admin.settings.otp') }}" class="list-item d-block {{ $designHelper::isActive(['otp'])}}">
                <i class="fa-solid fa-reply-all me-2"></i> {{ __('admin.otp') }}
            </a>
            <a href="{{ route('admin.settings.theme') }}" class="list-item d-block {{ $designHelper::isActive(['theme'])}}">
                <i class="fa-solid fa-moon me-2"></i> {{ __('admin.theme') }}
            </a>
            <a href="{{ route('admin.settings.notifications') }}" class="list-item d-block {{ $designHelper::isActive(['notifications'])}}">
                <i class="fa-solid fa-bullhorn me-2"></i> {{ __('admin.notifications') }}
            </a>
            <a href="{{ route('admin.countries.index') }}" class="list-item d-block {{ $designHelper::isActive(['countries'])}}">
                <i class="fa-solid fa-globe me-2"></i> {{ __('admin.location') }}
            </a>
            <a href="{{ route('admin.menus.index') }}" class="list-item d-block {{ $designHelper::isActive(['menus'])}}">
                <i class="fa-solid fa-list me-2"></i> {{ __('admin.menus') }}
            </a>
            <a href="{{ route('admin.currencies.index') }}" class="list-item d-block {{ $designHelper::isActive(['currencies'])}}">
                <i class="fa-solid fa-dollar-sign me-2"></i> {{ __('admin.currencies') }}
            </a>
            <a href="{{ route('admin.taxes.index') }}" class="list-item d-block {{ $designHelper::isActive(['taxes'])}}">
                <i class="fa-solid fa-tag me-2"></i> {{ __('admin.taxes') }}
            </a>
            <a href="{{ route('admin.return_reasons.index') }}" class="list-item d-block {{ $designHelper::isActive(['return_reasons'])}}">
                <i class="fa-solid fa-list-check me-2"></i> {{ __('admin.return_reasons') }}
            </a>
            <a href="{{ route('admin.roles.index') }}" class="list-item d-block {{ $designHelper::isActive(['roles'])}}">
                <i class="fa-solid fa-lock me-2"></i> {{ __('admin.roles') }}
            </a>
            <a href="{{ route('admin.pages.index') }}" class="list-item d-block {{ $designHelper::isActive(['pages'])}}">
                <i class="fa-regular fa-file me-2"></i> {{ __('admin.pages') }}
            </a>
            <a href="{{ route('admin.sliders.index') }}" class="list-item d-block {{ $designHelper::isActive(['sliders'])}}">
                <i class="fa-solid fa-images me-2"></i> {{ __('admin.sliders') }}
            </a>
            <a href="{{ route('admin.languages.index') }}" class="list-item d-block {{ $designHelper::isActive(['languages'])}}">
                <i class="fa-solid fa-language me-2"></i> {{ __('admin.languages') }}
            </a>
            <a href="{{ route('admin.settings.sms_gateways') }}" class="list-item d-block {{ $designHelper::isActive(['sms-gateways'])}}">
                <i class="fa-solid fa-comment-sms me-2"></i> {{ __('admin.sms_providers') }}
            </a>
            <a href="{{ route('admin.settings.payment_gateways') }}" class="list-item d-block {{ $designHelper::isActive(['payment-gateways'])}}">
                <i class="fa-solid fa-credit-card me-2"></i> {{ __('admin.payment_gateways') }}
            </a>
            <a href="{{ route('admin.translations.index') }}" class="list-item d-block {{ $designHelper::isActive(['translations'])}}">
                <i class="fa-solid fa-language me-2"></i> {{ __('admin.translations') }}
            </a>
        </div>
    </div>
</div>
