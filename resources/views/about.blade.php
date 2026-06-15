@extends('layouts.app')

@section('title', 'About Clearance Starter Kit')

@push('critical-head')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endpush

@section('content')
    <section class="about-page">
        <div class="container">
            <div class="row g-4 align-items-stretch mb-4">
                <div class="col-lg-7">
                    <div class="about-hero-card h-100">
                        <span class="about-kicker"><i class="bi bi-stars"></i> About Clearance</span>
                        <h1 class="about-title">A practical Laravel starter kit for modern student and team projects.</h1>
                        <p class="about-copy">
                            Clearance Starter Kit is designed to help developers launch faster with a clean foundation, ready authentication, and a
                            dashboard structure that follows real-world project patterns.
                        </p>
                        <ul class="about-list">
                            <li><i class="bi bi-check-circle-fill"></i><span>Production-friendly structure with readable Blade views and reusable layouts.</span></li>
                            <li><i class="bi bi-check-circle-fill"></i><span>Authentication flows prepared for quick onboarding and secure access.</span></li>
                            <li><i class="bi bi-check-circle-fill"></i><span>A maintainable base for adding features, APIs, and domain-specific modules.</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="about-stat-grid">
                        <div class="about-stat-card">
                            <i class="bi bi-layers"></i>
                            <strong>Laravel 12</strong>
                            <span>Modern framework baseline</span>
                        </div>
                        <div class="about-stat-card">
                            <i class="bi bi-bootstrap-fill"></i>
                            <strong>Bootstrap 5</strong>
                            <span>Responsive UI foundation</span>
                        </div>
                        <div class="about-stat-card">
                            <i class="bi bi-shield-check"></i>
                            <strong>Auth Ready</strong>
                            <span>Login and recovery flow included</span>
                        </div>
                        <div class="about-stat-card">
                            <i class="bi bi-lightning-charge"></i>
                            <strong>Clean DX</strong>
                            <span>Simple structure for easy extension</span>
                        </div>
                        <div class="about-stat-card">
                            <i class="bi bi-grid-1x2"></i>
                            <strong>Starter Dashboard</strong>
                            <span>Ready admin layout with sidebar and core pages</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h2 class="about-section-title mb-0">What makes it professional</h2>
                <a href="{{ route('home') }}" class="btn btn-outline-primary px-4">
                    <i class="bi bi-arrow-left me-1"></i>Back to Home
                </a>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <article class="about-value-card">
                        <span class="about-value-icon"><i class="bi bi-diagram-3"></i></span>
                        <h3>Structured Architecture</h3>
                        <p>Routes, layouts, controllers, and dashboard modules are organized for clarity and scale.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="about-value-card">
                        <span class="about-value-icon"><i class="bi bi-shield-lock"></i></span>
                        <h3>Security First</h3>
                        <p>Authentication scaffolding and secure defaults help you build safer applications from day one.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="about-value-card">
                        <span class="about-value-icon"><i class="bi bi-lightning-charge"></i></span>
                        <h3>Fast Delivery</h3>
                        <p>Spend less time setting up boilerplate and more time building features that matter.</p>
                    </article>
                </div>
            </div>

            <div class="row g-3 mt-1 align-items-stretch">
                <div class="col-lg-7">
                    <article class="about-stack-card">
                        <h2 class="about-section-title">Languages & Technologies</h2>
                        <div class="about-stack-grid">
                            <div class="about-stack-item"><i class="bi bi-filetype-php"></i><span>PHP</span></div>
                            <div class="about-stack-item"><i class="bi bi-bootstrap-fill"></i><span>Bootstrap</span></div>
                            <div class="about-stack-item"><i class="bi bi-filetype-js"></i><span>JavaScript</span></div>
                            <div class="about-stack-item"><i class="bi bi-database-fill"></i><span>MySQL</span></div>
                            <div class="about-stack-item"><i class="bi bi-layers-fill"></i><span>Blade</span></div>
                        </div>
                    </article>
                </div>
                <div class="col-lg-5">
                    <article class="about-developer-card">
                        <h2 class="about-section-title">About the Developer</h2>
                        <p>
                            Built by Hagai Ngobey, a developer focused on practical problem-solving and clean, scalable architecture. This starter
                            kit is designed to simplify Laravel development by providing a structured, readable, and production-ready foundation
                            that helps students and teams ship applications faster.
                        </p>
                        <p>
                            Maintained with a strong emphasis on clarity, consistent UI, and developer experience, it promotes best practices while
                            remaining easy to understand, extend, and adapt to real-world use cases.
                        </p>
                        <p>
                            Explore more projects and contributions:
                            <a href="https://github.com/harryhagai" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-github"></i> GitHub
                            </a>
                        </p>
                        <div class="about-developer-meta">
                            <span>Laravel</span>
                            <span>UI/UX</span>
                            <span>Clean Code</span>
                            <span>Mentorship</span>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection
