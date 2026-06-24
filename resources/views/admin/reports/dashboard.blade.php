@extends('layouts.clearanceDashboardLayout')

@section('page_header_actions')
    <a href="{{ route('admin.reports.export') }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-download"></i> Export Detailed CSV
    </a>
@endsection

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <div class="row g-3 mb-3">
        <div class="col-md-3"><section class="sims-panel"><div class="sims-panel__body"><strong>Total</strong><h3>{{ $stats['total_applications'] }}</h3></div></section></div>
        <div class="col-md-3"><section class="sims-panel"><div class="sims-panel__body"><strong>Approved</strong><h3>{{ $stats['approved']['count'] }}</h3><span>{{ $stats['approved']['percentage'] }}%</span></div></section></div>
        <div class="col-md-3"><section class="sims-panel"><div class="sims-panel__body"><strong>Denied</strong><h3>{{ $stats['denied']['count'] }}</h3><span>{{ $stats['denied']['percentage'] }}%</span></div></section></div>
        <div class="col-md-3"><section class="sims-panel"><div class="sims-panel__body"><strong>Pending</strong><h3>{{ $stats['pending']['count'] }}</h3><span>{{ $stats['pending']['percentage'] }}%</span></div></section></div>
    </div>

    <section class="sims-panel mb-3">
        <div class="sims-panel__header">
            <h3>Department Performance</h3>
        </div>
        <div class="sims-panel__body">
            <div class="table-responsive">
                <table class="table sims-table align-middle">
                    <thead><tr><th>Department</th><th>Approved</th><th>Denied</th><th>Pending</th><th>Approval Rate</th></tr></thead>
                    <tbody>
                        @foreach ($departmentStats as $department)
                            <tr>
                                <td>{{ $department['department'] }}</td>
                                <td>{{ $department['approved'] }}</td>
                                <td>{{ $department['denied'] }}</td>
                                <td>{{ $department['pending'] }}</td>
                                <td>{{ $department['approval_rate'] }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="row g-3">
        <div class="col-lg-7">
            <section class="sims-panel">
                <div class="sims-panel__header"><h3>Last 30 Days</h3></div>
                <div class="sims-panel__body">
                    <div class="table-responsive">
                        <table class="table sims-table">
                            <thead><tr><th>Date</th><th>Applications</th></tr></thead>
                            <tbody>
                                @foreach ($timelineData as $day)
                                    <tr><td>{{ $day['date'] }}</td><td>{{ $day['applications'] }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-5">
            <section class="sims-panel">
                <div class="sims-panel__header"><h3>Top Denial Areas</h3></div>
                <div class="sims-panel__body">
                    @forelse ($topIssues as $issue)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span>{{ $issue['department'] }}</span>
                            <strong>{{ $issue['denials'] }}</strong>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No denied applications yet.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
