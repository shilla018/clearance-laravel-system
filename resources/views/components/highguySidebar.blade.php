@php
    $isAdministrationMenuOpen = request()->is('dashboard/profile*') || request()->is('dashboard/settings*');
    $isMonitoringMenuOpen = request()->is('dashboard/notifications*');
@endphp

<aside id="sidebar" class="HighGuy_37-sidebar">
    <div class="p-3 highguy-sidebar-inner">
        <div class="highguy-sidebar-brand mb-4">
            <div class="highguy-sidebar-logo" aria-hidden="true">
                <img src="{{ asset('img/logo.png') }}" alt="Logo"
                    style="width: 32px; height: 32px; border-radius: 6px;">
            </div>
            <div class="highguy-sidebar-brand-text">
                <div class="highguy-sidebar-brand-title">HighGuy_37</div>
                <div class="highguy-sidebar-brand-subtitle">Starter Kit</div>
            </div>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('dashboard.index') }}"
                    class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('dashboard.notifications.index') }}"
                    class="nav-link {{ request()->is('dashboard/notifications*') ? 'active' : '' }}">
                    <i class="bi bi-bell-fill"></i> Notifications
                </a>
            </li>


            <div class="highguy-sidebar-footer">
                <div class="highguy-sidebar-footer__copy">&copy; 2025 HighGuy_37 Kit</div>
            </div>
    </div>
</aside>

<style>
    .HighGuy_37-sidebar .nav-link {
        border-radius: 12px;
        margin-bottom: 4px;
        padding: 10px 16px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .HighGuy_37-sidebar .nav-link:hover {
        background: rgba(var(--color-primary-500-rgb), 0.08);
        color: var(--color-primary-500);
    }

    .HighGuy_37-sidebar .nav-link.active {
        background: var(--color-primary-500);
        color: var(--color-white);
        box-shadow: 0 8px 16px rgba(var(--color-primary-500-rgb), 0.2);
    }
</style>
