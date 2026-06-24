@extends('layouts.clearanceDashboardLayout')

@section('page_header_actions')
    <a href="{{ route('dashboard.reports.clearance') }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-download"></i> Export CSV
    </a>
@endsection

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    @include('dashboard.partials.analytics-cards', ['analytics' => $analytics])

    <div class="row g-3 g-xl-4">
        <div class="col-xl-7">
            <section class="sims-panel">
                <div class="sims-panel__header">
                    <h3>Student Clearance Applications</h3>
                    <a href="{{ route('dashboard.applications.index') }}" class="sims-link">View all</a>
                </div>
                <div class="sims-panel__body">
                    @include('dashboard.partials.applications-table', ['applications' => $applications])
                </div>
            </section>
        </div>
        <div class="col-xl-5">
            <section class="sims-panel">
                <div class="sims-panel__header">
                    <h3>Support Management</h3>
                    <a href="{{ route('dashboard.support.index') }}" class="sims-link">Open support</a>
                </div>
                <div class="sims-panel__body">
                    <div class="table-responsive">
                        <table class="table sims-table align-middle">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Issue</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->student?->registration_number }}</td>
                                        <td><a class="sims-link" href="{{ route('dashboard.support.show', $ticket) }}">{{ $ticket->subject }}</a></td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3">No support requests yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
