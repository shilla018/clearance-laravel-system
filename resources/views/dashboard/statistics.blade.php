@extends('layouts.clearanceDashboardLayout')

@section('page_header_actions')
    <a href="{{ route('dashboard.reports.clearance') }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-download"></i> Export CSV
    </a>
@endsection

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    @include('dashboard.partials.analytics-cards', ['analytics' => $analytics])

    <section class="sims-panel">
        <div class="sims-panel__header">
            <h3>Recent Applications</h3>
        </div>
        <div class="sims-panel__body">
            @include('dashboard.partials.applications-table', ['applications' => $recentApplications])
        </div>
    </section>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
