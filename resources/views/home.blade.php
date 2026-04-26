@extends('layouts.app')

@section('title', 'HighGuy_37 - Simple Laravel Starter Kit')

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

        .feature-card {
            background: white;
            padding: 40px;
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
            width: 64px;
            height: 64px;
            background: #eff6ff;
            color: #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 24px;
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

        .btn-premium {
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
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

        .home-features-section {
            min-height: calc(100vh - 56px);
            display: flex;
            align-items: flex-start;
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
    </style>
@endpush

@section('content')
    <section class="hero-section">
        <div class="container text-center text-lg-start">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="display-3 fw-bold mb-4">Master Laravel with <span class="text-primary">HighGuy_37</span></h1>
                    <p class="lead text-muted mb-5" style="max-width: 600px;">
                        A beginner-friendly starter kit designed for students and developers to jumpstart their real-world
                        web applications. Built with Laravel, Bootstrap, and Best Practices.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                        <a href="/login" class="btn btn-primary btn-premium shadow-lg">
                            Get Started Now <i class="bi bi-arrow-right ms-2"></i>
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
                        <div class="tech-pill">Vite</div>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="p-5 bg-white rounded-4 shadow-sm border">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="feature-item-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-check2"></i>
                            </div>
                            <span class="fw-semibold">Auth System Included</span>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="feature-item-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-layout-sidebar-inset"></i>
                            </div>
                            <span class="fw-semibold">Modern Dashboard UI</span>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="feature-item-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-phone"></i>
                            </div>
                            <span class="fw-semibold">Fully Responsive</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="feature-item-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-code-slash"></i>
                            </div>
                            <span class="fw-semibold">Clean Code Structure</span>
                        </div>
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
                    <h2 class="fw-bold mb-3">Stacks Used in This Starter Kit</h2>
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
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-lightning-charge"></i></div>
                        <h4 class="fw-bold mb-2">Vite</h4>
                        <p class="text-muted mb-0">
                            Supports the frontend build workflow, asset bundling, and development server for project CSS
                            and JavaScript.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-features-section pt-5 pb-0 bg-white">
        <div class="container pt-5 pb-0 text-center">
            <h2 class="fw-bold mb-5">Everything You Need to Start</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-circle"><i class="bi bi-shield-lock"></i></div>
                        <h4 class="fw-bold"><i class="bi bi-shield-lock me-2"></i>Auth System</h4>
                        <p class="text-muted">Ready-to-use login, registration, and password recovery powered by standard
                            Laravel patterns.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-circle"><i class="bi bi-compass"></i></div>
                        <h4 class="fw-bold"><i class="bi bi-grid-1x2 me-2"></i>Dashboard</h4>
                        <p class="text-muted">A modern sidebar-based dashboard with basic stats and placeholders for your
                            data.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-circle"><i class="bi bi-pencil-square"></i></div>
                        <h4 class="fw-bold"><i class="bi bi-brush me-2"></i>Easy Theme</h4>
                        <p class="text-muted">Clean Blade layouts and CSS structures that you can easily customize to fit
                            your own project.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
