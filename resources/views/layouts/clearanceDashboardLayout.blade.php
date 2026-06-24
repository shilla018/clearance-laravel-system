<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Clearance System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/rootcolor.css') }}" rel="stylesheet">
    <link href="{{ asset('css/clearanceHeader.css') }}" rel="stylesheet">
    <link href="{{ asset('css/clearanceSidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/clearanceLayout.css') }}" rel="stylesheet">
    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body data-disable-navigation-overlay="1">
    @php
        $user = auth()->user();
        $pageHeader = match (true) {
            request()->is('dashboard') || request()->routeIs('dashboard.index') => [
                'title' => $user?->isAdmin() ? 'Admin Dashboard' : ($user?->isOfficer() ? 'Department Dashboard' : 'Student Dashboard'),
                'subtitle' => $user?->isAdmin() ? 'Monitor clearance applications, support requests, and institutional progress.' : ($user?->isOfficer() ? 'Review student clearance requests assigned to your department.' : 'View your registration status, payments, results, and clearance readiness.'),
            ],
            request()->routeIs('dashboard.payments.*') => [
                'title' => 'Student Payments',
                'subtitle' => 'Review paid invoices, pending balances, and payment control numbers.',
            ],
            request()->routeIs('dashboard.results.*') => [
                'title' => 'Published Results',
                'subtitle' => 'Check your semester results, GPA, points, and remarks.',
            ],
            request()->routeIs('dashboard.accommodation.*') => [
                'title' => 'Accommodation',
                'subtitle' => 'Review hostel debts, room assignment, and return items.',
            ],
            request()->routeIs('dashboard.library.*') => [
                'title' => 'Library',
                'subtitle' => 'Review borrowed books and pending library returns.',
            ],
            request()->routeIs('dashboard.clearance.*') => [
                'title' => 'Clearance Application',
                'subtitle' => 'Submit and track your institutional clearance request.',
            ],
            request()->routeIs('dashboard.applications.*') => [
                'title' => 'Clearance Applications',
                'subtitle' => 'Search, view, and process student clearance applications.',
            ],
            request()->routeIs('dashboard.statistics.*') => [
                'title' => 'Statistical Dashboard',
                'subtitle' => 'Track clearance completion, on-time processing, and support indicators.',
            ],
            request()->routeIs('dashboard.support.*') => [
                'title' => 'Notification and Support',
                'subtitle' => 'Submit, review, resolve, and respond to student support issues.',
            ],
            request()->is('dashboard/notifications*') => [
                'title' => 'Direct Notifications',
                'subtitle' => 'Review alerts, updates, and messages for your account.',
            ],
            request()->is('dashboard/profile*') => [
                'title' => 'User Profile',
                'subtitle' => 'Manage your account information and preferences.',
            ],
            request()->is('dashboard/settings*') => [
                'title' => 'System Settings',
                'subtitle' => 'Adjust your application behavior and personal settings.',
            ],
            default => [
                'title' => 'User Panel',
                'subtitle' => 'Manage your activities from this workspace.',
            ],
        };
    @endphp

    @include('components.clearanceHeader')
    @include('components.clearanceSidebar')

    <main class="dashboard-page-content" @if($pageHeader) data-dashboard-page-header="true" @endif>
        @if ($pageHeader)
            <div class="px-3 px-lg-4 pt-4">
                <section class="dashboard-shared-page-header">
                    <div class="dashboard-shared-page-header__content">
                        <x-clearance-page-header :title="$pageHeader['title']" :subtitle="$pageHeader['subtitle']" />
                    </div>

                    @hasSection('page_header_actions')
                        <div class="dashboard-shared-page-header__actions">
                            @yield('page_header_actions')
                        </div>
                    @endif
                </section>
            </div>
        @endif

        <div class="dashboard-page-body">
            @yield('content')
        </div>
    </main>

    <style>
        .dashboard-shared-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.4rem 0 1.1rem;
            margin-bottom: 1.2rem;
            border-bottom: 1px solid rgba(var(--color-primary-500-rgb), 0.18);
        }
        .dashboard-shared-page-header__content {
            min-width: 0;
            flex: 1 1 auto;
        }
        .dashboard-shared-page-header__actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.75rem;
            flex-shrink: 0;
        }
        .clearance-shared-page-header__title {
            margin: 0;
            font-size: clamp(1.2rem, 1.5vw, 1.5rem);
            line-height: 1.25;
            font-weight: 700;
            color: var(--color-primary-600);
            letter-spacing: 0.01em;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
        }

        .clearance-shared-page-header__subtitle {
            max-width: 760px;
            margin: 0.45rem 0 0;
            color: var(--color-slate-500);
            font-size: 0.85rem;
            line-height: 1.55;
        }
        .dashboard-page-content[data-dashboard-page-header="true"] .dashboard-page-body > .container:first-child > :is(h1, h2, h3, h4):first-child {
            display: none !important;
        }
        @media (max-width: 768px) {
            .dashboard-shared-page-header {
                flex-direction: column;
                align-items: stretch;
                padding-bottom: 1rem;
            }
            .dashboard-shared-page-header__actions {
                justify-content: flex-start;
                flex-wrap: wrap;
            }
            .clearance-shared-page-header__subtitle {
                font-size: 0.8rem;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/clearanceSidebar.js') }}"></script>
    <script src="{{ asset('js/clearanceButtonSpinner.js') }}"></script>
    <script src="{{ asset('js/clearanceAlerts.js') }}"></script>
    @yield('scripts')

    @if (session('success') && ! View::hasSection('disable_success_swal'))
        <script>
            if (typeof showSystemAlert === 'function') {
                showSystemAlert({
                    theme: 'success',
                    title: 'Action completed',
                    text: @js(session('success')),
                    timer: 2600,
                    showConfirmButton: false
                });
            }
        </script>
    @endif

    @if (session('error'))
        <script>
            if (typeof showSystemAlert === 'function') {
                showSystemAlert({
                    theme: 'danger',
                    title: 'Something went wrong',
                    text: @js(session('error')),
                    showConfirmButton: true,
                    confirmButtonText: '<i class="bi bi-arrow-repeat me-1"></i> OK'
                });
            }
        </script>
    @endif

    @stack('scripts')
</body>
</html>
