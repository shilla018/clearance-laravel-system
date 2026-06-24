@extends('layouts.clearanceDashboardLayout')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <div class="row g-3 g-xl-4">
        <div class="col-xl-7">
            <section class="sims-panel">
                <div class="sims-panel__header">
                    <h3>{{ $ticket->subject }}</h3>
                    <span>{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</span>
                </div>
                <div class="sims-panel__body">
                    <p class="mb-2"><strong>Student:</strong> {{ $ticket->student?->full_name }} ({{ $ticket->student?->registration_number }})</p>
                    <p class="mb-2"><strong>Priority:</strong> {{ ucfirst($ticket->priority) }}</p>
                    <hr>
                    <h4 class="sims-mini-heading">Student Message</h4>
                    <p>{{ $ticket->message }}</p>

                    <h4 class="sims-mini-heading">Admin Feedback</h4>
                    @if ($ticket->admin_feedback)
                        <p>{{ $ticket->admin_feedback }}</p>
                        <p class="text-muted small mb-0">Responded by {{ $ticket->admin?->full_name ?? 'Admin' }} on {{ optional($ticket->responded_at)->format('d M Y, H:i') }}</p>
                    @else
                        <p class="text-muted mb-0">No feedback has been sent yet.</p>
                    @endif
                </div>
            </section>
        </div>

        @if (auth()->user()->isAdmin())
            <div class="col-xl-5">
                <section class="sims-panel">
                    <div class="sims-panel__header">
                        <h3>Respond</h3>
                    </div>
                    <div class="sims-panel__body">
                        <form method="POST" action="{{ route('dashboard.support.respond', $ticket) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    @foreach (['open', 'in_progress', 'resolved'] as $status)
                                        <option value="{{ $status }}" @selected($ticket->status === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Feedback to student</label>
                                <textarea class="form-control @error('admin_feedback') is-invalid @enderror" name="admin_feedback" rows="6" required>{{ old('admin_feedback', $ticket->admin_feedback) }}</textarea>
                                @error('admin_feedback')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <button class="btn btn-primary btn-sm"><i class="bi bi-send-check"></i> Send Feedback</button>
                        </form>
                    </div>
                </section>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
