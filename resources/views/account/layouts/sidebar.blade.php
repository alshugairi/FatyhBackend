<div class="p-4 text-white" style="background: #333333; border-radius: 24px">
    <div class="text-center1 mb-4 px-3">
        <div class="rounded-circle bg-secondary mx-auto1 mb-3 text-center" style="width: 80px; height: 80px;">
            <i class="fas fa-user text-white" style="font-size: 2.5rem; line-height: 80px;"></i>
        </div>
        <h5 class="mb-1">{{ auth()->user()->name }}</h5>
        <small class="text-white">
            <i class="fa-solid fa-mobile-screen"></i>
            {{ auth()->user()->phone }}
        </small>
    </div>

    <nav class="nav flex-column">
        <a class="nav-link text-white active mb-2" href="{{ route('account.dashboard') }}"><i class="fas fa-th-large me-2"></i>
            {{ __('frontend.overview') }}</a>
        <a class="nav-link text-white mb-2" href="{{ route('account.orders.index') }}"><i class="fas fa-shopping-cart me-2"></i> {{ __('frontend.my_orders') }}</a>
        <a class="nav-link text-white mb-2" href="{{ route('account.orders.return') }}"><i class="fas fa-undo me-2"></i> {{ __('frontend.return_orders') }}</a>
        <a class="nav-link text-white mb-2" href="{{ route('account.info') }}"><i class="fas fa-user me-2"></i> {{ __('frontend.account_info') }}</a>
        <a class="nav-link text-white mb-2" href="{{ route('account.change_password') }}"><i class="fas fa-lock me-2"></i> {{ __('frontend.change_password') }}</a>
        <a class="nav-link text-white mb-2" href="{{ route('account.address.index') }}"><i class="fas fa-map-marker-alt me-2"></i> {{ __('frontend.address') }}</a>
    </nav>
</div>
