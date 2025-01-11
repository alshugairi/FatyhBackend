<aside class="app-sidebar shadow1" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a class='brand-link' href="{{ route('admin.dashboard') }}">
            <img src="{{ get_setting('theme_logo', asset('assets/admin/images/logo-icon.png')) }}" alt="Fatyh Logo" class="brand-image">
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['admin/dashboard'])}}' href="{{ route('admin.dashboard') }}">
                        <i class="nav-icon fa-solid fa-house"></i>
                        <p>{{ __('admin.dashboard') }}</p>
                    </a>
                </li>
                <li class="nav-header">{{ __('admin.catalog') }}</li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['products'])}}' href="{{ route('admin.products.index') }}">
                        <i class="nav-icon fa-solid fa-box"></i>
                        <p>{{ __('admin.products') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['categories'])}}' href="{{ route('admin.categories.index') }}">
                        <i class="nav-icon fa-solid fa-list"></i>
                        <p>{{ __('admin.categories') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['brands'])}}' href="{{ route('admin.brands.index') }}">
                        <i class="nav-icon fa-solid fa-trademark"></i>
                        <p>{{ __('admin.brands') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['units'])}}' href="{{ route('admin.units.index') }}">
                        <i class="nav-icon fa-solid fa-cubes"></i>
                        <p>{{ __('admin.units') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['attributes'])}}' href="{{ route('admin.attributes.index') }}">
                        <i class="nav-icon fa-solid fa-tags"></i>
                        <p>{{ __('admin.attributes') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['collections'])}}' href="{{ route('admin.collections.index') }}">
                        <i class="nav-icon fa-solid fa-layer-group"></i>
                        <p>{{ __('admin.collections') }}</p>
                    </a>
                </li>
                <li class="nav-header">{{ __('admin.sales') }}</li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['coupons'])}}' href="{{ route('admin.coupons.index') }}">
                        <i class="nav-icon fa-solid fa-ticket"></i>
                        <p>{{ __('admin.coupons') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['orders'])}}' href="{{ route('admin.orders.index') }}?platform=online">
                        <i class="nav-icon fa-solid fa-cart-shopping"></i>
                        <p>{{ __('admin.online_orders') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['orders'])}}' href="{{ route('admin.orders.index') }}?platform=pos">
                        <i class="nav-icon fa-solid fa-cash-register"></i>
                        <p>{{ __('admin.pos_orders') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-file-invoice"></i>
                        <p>
                            {{ __('admin.finance') }}
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class='nav-link {{ $designHelper::isActive(['transactions'])}}' href="{{ route('admin.transactions.index') }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>{{ __('admin.transactions') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class='nav-link' href="{{ route('admin.admins.index') }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>{{ __('admin.admins') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-chart-line"></i>
                        <p>
                            {{ __('admin.reports') }}
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class='nav-link' href="{{ route('admin.reports.creditBalance') }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>{{ __('admin.credit_balance_report') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class='nav-link' href="{{ route('admin.reports.products') }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>{{ __('admin.products_report') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">{{ __('admin.inventory') }}</li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['suppliers'])}}' href="{{ route('admin.suppliers.index') }}">
                        <i class="nav-icon fa-solid fa-boxes"></i>
                        <p>{{ __('admin.suppliers') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['purchases'])}}' href="{{ route('admin.purchases.index') }}">
                        <i class="nav-icon fa-solid fa-receipt"></i>
                        <p>{{ __('admin.purchases') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['inventory'])}}' href="{{ route('admin.inventory.index') }}">
                        <i class="nav-icon fa-solid fa-warehouse"></i>
                        <p>{{ __('admin.inventory') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['stock_movements'])}}' href="{{ route('admin.stock_movements.index') }}">
                        <i class="nav-icon fa-solid fa-arrow-right-arrow-left"></i>
                        <p>{{ __('admin.stock_movements') }}</p>
                    </a>
                </li>
                <li class="nav-header">{{ __('admin.users') }}</li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['admins'])}}' href="{{ route('admin.admins.index') }}">
                        <i class="nav-icon fa-solid fa-user-tie"></i>
                        <p>{{ __('admin.admins') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='nav-link {{ $designHelper::isActive(['clients'])}}' href="{{ route('admin.clients.index') }}">
                        <i class="nav-icon fa-solid fa-users"></i>
                        <p>{{ __('admin.clients') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='nav-link' href="{{ route('admin.contact.index') }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>{{ __('admin.contact') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='nav-link' href="{{ route('admin.settings.company') }}">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>{{ __('admin.settings') }}</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
