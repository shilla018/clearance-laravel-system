@extends('layouts.clearanceDashboardLayout')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <section class="sims-panel">
        <div class="sims-panel__header">
            <h3>Applications</h3>
        </div>
        <div class="sims-panel__body">
            <form class="row g-2 mb-3" method="GET">
                <div class="col-md-6">
                    <input class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Search by name or registration number">
                </div>
                <div class="col-md-3">
                    <select class="form-select form-select-sm" name="status">
                        <option value="">All statuses</option>
                        @foreach (['pending', 'approved', 'denied'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status === 'denied' ? 'Declined' : ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary btn-sm"><i class="bi bi-search"></i> Search</button>
                </div>
            </form>

            @include('dashboard.partials.applications-table', ['applications' => $applications])
            <div class="mt-3">{{ $applications->links() }}</div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
