@extends('layouts.clearanceDashboardLayout')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <section class="sims-status-alert sims-status-alert--info mb-3">
        <strong>{{ $departmentName }}</strong>
        <span>Review submitted clearance applications and record approval decisions with comments.</span>
    </section>

    <section class="sims-panel">
        <div class="sims-panel__header">
            <h3>Assigned Department Reviews</h3>
            <a class="sims-link" href="{{ route('dashboard.applications.index') }}">View all</a>
        </div>
        <div class="sims-panel__body">
            <div class="table-responsive">
                <table class="table sims-table align-middle">
                    <thead>
                        <tr>
                            <th>Reg No</th>
                            <th>Student</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reviews as $review)
                            <tr>
                                <td>{{ $review->application?->student?->registration_number }}</td>
                                <td>{{ $review->application?->student?->full_name }}</td>
                                <td>{{ $review->application?->reason }}</td>
                                <td>{{ ucfirst($review->status) }}</td>
                                <td><a class="btn btn-sm btn-outline-primary" href="{{ route('dashboard.applications.show', $review->application) }}"><i class="bi bi-eye"></i> View</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="5">No applications have been submitted for this department.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
