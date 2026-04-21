@php
    $isAdministrationMenuOpen = request()->is('dashboard/profile*') || request()->is('dashboard/settings*');
    $isMonitoringMenuOpen = request()->is('dashboard/notifications*');
@endphp

<aside id="sidebar" class="highguy-sidebar">
    <div class="p-3 officer-sidebar-inner">
        <div class="officer-sidebar-brand mb-4">
            <div class="officer-sidebar-logo" aria-hidden="true">
                <img src="{{ asset('img/logo.png') }}" alt="Logo"
                    style="width: 32px; height: 32px; border-radius: 6px;">
            </div>
            <div class="officer-sidebar-brand-text">
                <div class="officer-sidebar-brand-title">HighGuy</div>
                <div class="officer-sidebar-brand-subtitle">Starter Kit</div>
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


            <div class="officer-sidebar-footer">
                <div class="officer-sidebar-footer__copy">&copy; 2025 HighGuy Kit</div>
            </div>
    </div>
</aside>

<style>
    .highguy-sidebar .nav-link {
        border-radius: 12px;
        margin-bottom: 4px;
        padding: 10px 16px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .highguy-sidebar .nav-link:hover {
        background: rgba(59, 130, 246, 0.05);
        color: #3b82f6;
    }

    .highguy-sidebar .nav-link.active {
        background: #3b82f6;
        color: #fff;
        box-shadow: 0 8px 16px rgba(59, 130, 246, 0.2);
    }
</style>
