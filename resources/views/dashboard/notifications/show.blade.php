@extends('layouts.clearanceDashboardLayout')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
        <section class="sims-panel">
            <div class="sims-panel__header">
                <h3>{{ $notification->title ?? 'Notification' }}</h3>
                <span>{{ ucfirst($notification->status ?? 'read') }}</span>
            </div>
            <div class="sims-panel__body">
                <p>{{ $notification->message ?? 'No message available.' }}</p>
                @if ($notification->action_url)
                    <a href="{{ $notification->action_url }}" class="btn btn-primary btn-sm"><i class="bi bi-box-arrow-up-right"></i> Open Related Page</a>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
