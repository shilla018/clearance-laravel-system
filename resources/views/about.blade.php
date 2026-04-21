@extends('layouts.app')

@section('title', 'About HighGuy Starter Kit')

@push('critical-head')
    <style>
        .about-page {
            padding-top: 120px;
            padding-bottom: 72px;
            background: linear-gradient(180deg, #f8fbff 0%, #ffffff 42%, #f8fbff 100%);
        }

        .about-hero-card,
        .about-stat-card,
        .about-value-card {
            background: #ffffff;
            border: 1px solid rgba(59, 130, 246, 0.16);
            border-radius: 20px;
            box-shadow: 0 14px 34px rgba(37, 99, 235, 0.08);
        }

        .about-hero-card {
            padding: 2rem;
        }

        .about-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.4rem 0.8rem;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.1);
            color: #1d4ed8;
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .about-title {
            font-size: clamp(2rem, 3vw, 2.8rem);
            line-height: 1.1;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .about-copy {
            color: #64748b;
            line-height: 1.75;
            margin-bottom: 1.5rem;
        }

        .about-list {
            margin: 0;
            padding: 0;
            list-style: none;
            display: grid;
            gap: 0.8rem;
        }

        .about-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            color: #334155;
        }

        .about-list i {
            color: #2563eb;
        }

        .about-stat-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.9rem;
        }

        .about-stat-card {
            padding: 1.15rem;
        }

        .about-stat-card i {
            display: inline-flex;
            width: 34px;
            height: 34px;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            margin-bottom: 0.55rem;
            background: rgba(59, 130, 246, 0.12);
            color: #2563eb;
            font-size: 1rem;
        }

        .about-stat-card strong {
            display: block;
            font-size: 1.45rem;
            color: #1d4ed8;
            line-height: 1.1;
        }

        .about-stat-card span {
            color: #64748b;
            font-size: 0.9rem;
        }

        .about-section-title {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 0.9rem;
        }

        .about-value-card {
            padding: 1.2rem;
            height: 100%;
        }

        .about-value-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(59, 130, 246, 0.12);
            color: #2563eb;
            margin-bottom: 0.7rem;
        }

        .about-value-card h3 {
            font-size: 1.02rem;
            margin-bottom: 0.45rem;
        }

        .about-value-card p {
            margin: 0;
            color: #64748b;
            font-size: 0.94rem;
            line-height: 1.7;
        }

        .about-stack-card,
        .about-developer-card {
            background: #ffffff;
            border: 1px solid rgba(59, 130, 246, 0.16);
            border-radius: 20px;
            box-shadow: 0 14px 34px rgba(37, 99, 235, 0.08);
            padding: 1.4rem;
            height: 100%;
        }

        .about-stack-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 0.85rem;
        }

        .about-stack-item {
            border: 1px solid rgba(59, 130, 246, 0.16);
            border-radius: 14px;
            padding: 0.8rem 0.7rem;
            text-align: center;
            background: #f8fbff;
        }

        .about-stack-item i {
            font-size: 1.25rem;
            color: #2563eb;
            display: inline-block;
            margin-bottom: 0.3rem;
        }

        .about-stack-item span {
            display: block;
            font-size: 0.86rem;
            color: #475569;
            font-weight: 600;
        }

        .about-developer-card p {
            margin: 0 0 0.8rem;
            color: #64748b;
            line-height: 1.7;
        }

        .about-developer-meta {
            display: inline-flex;
            flex-wrap: wrap;
            gap: 0.45rem;
        }

        .about-developer-meta span {
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.1);
            color: #1d4ed8;
            padding: 0.3rem 0.65rem;
            font-size: 0.8rem;
            font-weight: 700;
        }
    </style>
@endpush

@section('content')
    <section class="about-page">
        <div class="container">
            <div class="row g-4 align-items-stretch mb-4">
                <div class="col-lg-7">
                    <div class="about-hero-card h-100">
                        <span class="about-kicker"><i class="bi bi-stars"></i> About HighGuy</span>
                        <h1 class="about-title">A practical Laravel starter kit for modern student and team projects.</h1>
                        <p class="about-copy">
                            HighGuy Starter Kit is designed to help developers launch faster with a clean foundation, ready authentication, and a
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
                            <strong>Laravel 13</strong>
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
                <a href="{{ route('home') }}" class="btn btn-outline-primary px-4">Back to Home</a>
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

            <div class="row g-3 mt-1">
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
