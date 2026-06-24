@extends('layouts.app')

@section('title', 'Clearance - Simple Laravel Starter Kit')

@push('critical-head')
    <style>
        .hero-section {
            padding: 120px 0;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(59, 130, 246, 0.05) 0%, transparent 70%);
        }

        .home-hero-title {
            font-size: 4rem;
            line-height: 1.08;
        }

        .home-hero-copy {
            max-width: 600px;
            font-size: 1.25rem;
            line-height: 1.65;
        }

        .home-hero-actions {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            gap: 1rem;
        }

        .feature-card {
            background: white;
            padding: 24px;
            border-radius: 24px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            border-color: #3b82f6;
        }

        .icon-circle {
            width: 48px;
            height: 48px;
            background: #eff6ff;
            color: #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin: 0 auto 16px;
            transition: all 0.3s ease;
        }

        .feature-item-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.1rem;
        }

        .hero-feature-item {
            width: 100%;
            padding: 12px;
            border-radius: 14px;
            border: 1px solid transparent;
            background: transparent;
            transition: all 0.25s ease;
            cursor: pointer;
        }

        .hero-feature-item:hover,
        .hero-feature-item:focus-within {
            background: #eff6ff;
            border-color: #bfdbfe;
            transform: translateX(8px);
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.14);
        }

        .hero-feature-item:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
            transform: translateX(8px);
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.14);
        }

        .hero-feature-item .feature-item-icon {
            background: #dbeafe;
            color: #2563eb;
            transition: all 0.25s ease;
        }

        .hero-feature-item:hover .feature-item-icon,
        .hero-feature-item:focus-within .feature-item-icon {
            background: #2563eb;
            color: #ffffff;
            transform: scale(1.08);
        }

        .hero-feature-item span {
            transition: color 0.25s ease;
        }

        .hero-feature-item:hover span,
        .hero-feature-item:focus-within span {
            color: #2563eb;
        }

        .btn-premium {
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .tech-pill {
            display: inline-block;
            padding: 6px 16px;
            background: #f1f5f9;
            border-radius: 99px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #64748b;
            margin: 4px;
        }

        .stack-usage-section {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .stack-usage-card {
            height: 100%;
            padding: 22px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .stack-usage-card:hover {
            transform: translateY(-4px);
            border-color: #3b82f6;
            box-shadow: 0 18px 35px rgba(15, 23, 42, 0.07);
        }

        .stack-usage-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #eff6ff;
            color: #3b82f6;
            font-size: 1.15rem;
            margin-bottom: 14px;
        }

        .stack-usage-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 14px;
            border-radius: 999px;
            background: #e0f2fe;
            color: #0369a1;
            font-size: 0.82rem;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .hero-logo-card {
            min-height: 360px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-logo-card img {
            width: 100%;
            max-width: 360px;
            height: auto;
            object-fit: contain;
            display: block;
        }

        .home-section-title {
            font-size: 2rem;
            line-height: 1.2;
        }

        .stack-usage-card h4 {
            font-size: 1.25rem;
            line-height: 1.25;
        }

        .stack-usage-card p {
            font-size: 0.95rem;
            line-height: 1.65;
        }

        @media (max-width: 991.98px) {
            .hero-section {
                padding: 88px 0;
            }

            .home-hero-title {
                font-size: 3rem;
            }

            .home-hero-copy {
                max-width: 100%;
                font-size: 1.08rem;
            }

            .home-section-title {
                font-size: 1.75rem;
            }

            .hero-logo-card {
                min-height: 280px;
                margin-top: 2rem;
                padding: 2rem !important;
            }

            .hero-logo-card img {
                max-width: 280px;
            }
        }

        @media (max-width: 575.98px) {
            .hero-section {
                padding: 64px 0 54px;
            }

            .hero-section::before {
                width: 70%;
                opacity: 0.7;
            }

            .home-hero-title {
                font-size: 2.2rem;
                line-height: 1.12;
                margin-bottom: 1rem !important;
            }

            .home-hero-copy {
                font-size: 0.98rem;
                line-height: 1.62;
                margin-bottom: 1.5rem !important;
            }

            .home-hero-actions {
                width: 100%;
                gap: 0.55rem;
            }

            .home-hero-actions .btn-premium {
                flex: 1 1 0;
                min-width: 0;
                padding: 0.75rem 0.55rem;
                border-radius: 10px;
                font-size: 0.78rem;
                line-height: 1.2;
            }

            .home-hero-actions .btn-premium i {
                margin-left: 0.25rem !important;
                margin-right: 0.25rem !important;
            }

            .hero-logo-card {
                min-height: 220px;
                margin-top: 1.6rem;
                padding: 1.4rem !important;
                border-radius: 18px !important;
            }

            .hero-logo-card img {
                max-width: 220px;
            }

            .tech-pill {
                padding: 5px 12px;
                font-size: 0.78rem;
            }

            .stack-usage-section {
                padding-top: 2.4rem !important;
                padding-bottom: 2.4rem !important;
            }

            .stack-usage-section .container {
                padding-top: 0.5rem !important;
                padding-bottom: 0.5rem !important;
            }

            .home-section-title {
                font-size: 1.45rem;
            }

            .stack-usage-card {
                padding: 18px;
            }

            .stack-usage-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .stack-usage-card h4 {
                font-size: 1.08rem;
            }

            .stack-usage-card p {
                font-size: 0.88rem;
                line-height: 1.58;
            }

            .stack-usage-label {
                font-size: 0.74rem;
                padding: 6px 11px;
            }
        }
    </style>
@endpush

@section('content')
    <section class="hero-section">
        <div class="container text-center text-lg-start">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="home-hero-title fw-bold mb-4">complete your <span class="text-primary">Clearance</span></h1>
                    <p class="home-hero-copy text-muted mb-5">
                        A beginner-friendly starter kit designed for students and developers to jumpstart their real-world
                        web applications. Built with Laravel, Bootstrap, and Best Practices.
                    </p>
                    <div class="home-hero-actions justify-content-center justify-content-lg-start">
                        <a href="/login" class="btn btn-primary btn-premium shadow-lg">
                            Get Started <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="https://github.com/harryhagai" target="_blank" class="btn btn-outline-dark btn-premium">
                            <i class="bi bi-github me-2"></i> Star on GitHub
                        </a>
                    </div>

                    <div class="mt-5">
                        <div class="tech-pill">Laravel 12</div>
                        <div class="tech-pill">Bootstrap 5</div>
                        <div class="tech-pill">MySQL</div>
                        <div class="tech-pill">Blade</div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-logo-card p-5 bg-white rounded-4 shadow-sm border">
                        <img src="{{ route('system.logo') }}"
                            alt="Clearance Logo"
                            loading="eager">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stack-usage-section py-5">
        <div class="container py-4">
            <div class="row align-items-end mb-4">
                <div class="col-lg-7">
                    <span class="stack-usage-label">
                        <i class="bi bi-layers"></i>
                        Tech Stack Usage
                    </span>
                    <h2 class="home-section-title fw-bold mb-3">complete your clearance here</h2>
                    <p class="text-muted mb-lg-0">
                        These are the core technologies behind this starter kit and how each one supports the application
                        during development.
                    </p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <a href="{{ route('about') }}" class="btn btn-outline-primary px-4">
                        Learn More <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-braces"></i></div>
                        <h4 class="fw-bold mb-2">Laravel 12</h4>
                        <p class="text-muted mb-0">
                            Handles routing, authentication, middleware, models, migrations, controllers, and the main
                            backend application structure.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-filetype-php"></i></div>
                        <h4 class="fw-bold mb-2">PHP 8.2+</h4>
                        <p class="text-muted mb-0">
                            Runs the Laravel project and powers server-side logic, services, validation, and business
                            rules.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-bootstrap"></i></div>
                        <h4 class="fw-bold mb-2">Bootstrap 5</h4>
                        <p class="text-muted mb-0">
                            Builds responsive layouts, grid structures, buttons, spacing, and reusable interface
                            components.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-layout-text-window-reverse"></i></div>
                        <h4 class="fw-bold mb-2">Blade Templates</h4>
                        <p class="text-muted mb-0">
                            Organizes pages, layouts, components, and sections so the frontend stays easy to maintain and
                            extend.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-database"></i></div>
                        <h4 class="fw-bold mb-2">MySQL Database</h4>
                        <p class="text-muted mb-0">
                            Stores users, audit trails, notifications, and other data needed by the dashboard and auth
                            flow.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stack-usage-section py-5 bg-white">
        <div class="container py-4">
            <div class="row align-items-end mb-4">
                <div class="col-lg-7">
                    <span class="stack-usage-label">
                        <i class="bi bi-box-seam"></i>
                        Starter Features
                    </span>
                    <h2 class="home-section-title fw-bold mb-3">Everything You Need to Start</h2>
                    <p class="text-muted mb-lg-0">
                        A clean Laravel foundation with ready-to-use essentials for building real-world applications
                        faster.
                    </p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <a href="/login" class="btn btn-outline-primary px-4">
                        Get Started <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-shield-lock"></i></div>
                        <h4 class="fw-bold mb-2">Auth System</h4>
                        <p class="text-muted mb-0">
                            Ready-to-use login, registration, and password recovery powered by standard Laravel patterns.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-layout-sidebar-inset"></i></div>
                        <h4 class="fw-bold mb-2">Dashboard</h4>
                        <p class="text-muted mb-0">
                            A modern sidebar-based dashboard with basic stats and clean placeholders for your project
                            data.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-brush"></i></div>
                        <h4 class="fw-bold mb-2">Easy Theme</h4>
                        <p class="text-muted mb-0">
                            Clean Blade layouts and CSS structures that you can quickly customize to fit your own brand.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>




@endsection
