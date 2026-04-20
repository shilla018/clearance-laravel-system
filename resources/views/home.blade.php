@extends('layouts.app')

@section('title', 'HighGuy - Simple Laravel Starter Kit')

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
            width: 60px;
            height: 60px;
            background: #eff6ff;
            color: #3b82f6;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 24px;
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
    </style>
@endpush

@section('content')
    <section class="hero-section">
        <div class="container text-center text-lg-start">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-4"><i class="bi bi-rocket-takeoff me-1"></i> Simple. Clean. Fast.</span>
                    <h1 class="display-3 fw-bold mb-4">Master Laravel with <span class="text-primary">HighGuy</span></h1>
                    <p class="lead text-muted mb-5" style="max-width: 600px;">
                        A beginner-friendly starter kit designed for students and developers to jumpstart their real-world web applications. Built with Laravel, Bootstrap, and Best Practices.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                        <a href="/login" class="btn btn-primary btn-premium shadow-lg">
                             Get Started Now <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="https://github.com/hagaiharold" target="_blank" class="btn btn-outline-dark btn-premium">
                            <i class="bi bi-github me-2"></i> Star on GitHub
                        </a>
                    </div>
                    
                    <div class="mt-5">
                        <div class="tech-pill">Laravel 13</div>
                        <div class="tech-pill">Bootstrap 5</div>
                        <div class="tech-pill">MySQL</div>
                        <div class="tech-pill">Blade</div>
                        <div class="tech-pill">Vite</div>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="p-5 bg-white rounded-4 shadow-sm border">
                         <div class="d-flex align-items-center gap-3 mb-4">
                             <div class="bg-success bg-opacity-10 text-success p-2 rounded-circle">
                                 <i class="bi bi-check2"></i>
                             </div>
                             <span class="fw-semibold">Auth System Included</span>
                         </div>
                         <div class="d-flex align-items-center gap-3 mb-4">
                             <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle">
                                 <i class="bi bi-layout-sidebar-inset"></i>
                             </div>
                             <span class="fw-semibold">Modern Dashboard UI</span>
                         </div>
                         <div class="d-flex align-items-center gap-3 mb-4">
                             <div class="bg-info bg-opacity-10 text-info p-2 rounded-circle">
                                 <i class="bi bi-phone"></i>
                             </div>
                             <span class="fw-semibold">Fully Responsive</span>
                         </div>
                         <div class="d-flex align-items-center gap-3">
                             <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-circle">
                                 <i class="bi bi-code-slash"></i>
                             </div>
                             <span class="fw-semibold">Clean Code Structure</span>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container py-5 text-center">
            <h2 class="fw-bold mb-5">Everything You Need to Start</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-circle"><i class="bi bi-shield-lock"></i></div>
                        <h4 class="fw-bold"><i class="bi bi-shield-lock me-2"></i>Auth System</h4>
                        <p class="text-muted">Ready-to-use login, registration, and password recovery powered by standard Laravel patterns.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-circle"><i class="bi bi-compass"></i></div>
                        <h4 class="fw-bold"><i class="bi bi-grid-1x2 me-2"></i>Dashboard</h4>
                        <p class="text-muted">A modern sidebar-based dashboard with basic stats and placeholders for your data.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-circle"><i class="bi bi-pencil-square"></i></div>
                        <h4 class="fw-bold"><i class="bi bi-brush me-2"></i>Easy Theme</h4>
                        <p class="text-muted">Clean Blade layouts and CSS structures that you can easily customize to fit your own project.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="bg-dark rounded-4 p-5 text-white text-center">
                 <h2 class="fw-bold mb-4">Join the HighGuy Community</h2>
                 <p class="opacity-75 mb-5 mx-auto" style="max-width: 600px;">
                     Helping students build faster and learn more every day. This kit is free to use for all educational purposes.
                 </p>
                 <a href="/login" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">Start Your Project</a>
            </div>
        </div>
    </section>
@endsection
