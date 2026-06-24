@extends('layouts.clearanceDashboardLayout')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <div class="row g-3 g-xl-4">
        @if (auth()->user()->isStudent())
            <div class="col-xl-5">
                <section class="sims-panel">
                    <div class="sims-panel__header">
                        <h3>Submit Support Issue</h3>
                    </div>
                    <div class="sims-panel__body">
                        <form method="POST" action="{{ route('dashboard.support.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Subject</label>
                                <input name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required>
                                @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Priority</label>
                                <select name="priority" class="form-select" required>
                                    <option value="normal">Normal</option>
                                    <option value="high">High</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Issue or question</label>
                                <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <button class="btn btn-primary btn-sm"><i class="bi bi-send"></i> Submit</button>
                        </form>
                    </div>
                </section>
            </div>
        @endif

        <div class="{{ auth()->user()->isStudent() ? 'col-xl-7' : 'col-12' }}">
            <section class="sims-panel">
                <div class="sims-panel__header">
                    <h3>{{ auth()->user()->isStudent() ? 'My Support Requests' : 'Student Support Requests' }}</h3>
                </div>
                <div class="sims-panel__body">
                    <div class="table-responsive">
                        <table class="table sims-table align-middle">
                            <thead>
                                <tr>
                                    @if (! auth()->user()->isStudent())<th>Student</th>@endif
                                    <th>Subject</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tickets as $ticket)
                                    <tr>
                                        @if (! auth()->user()->isStudent())<td>{{ $ticket->student?->registration_number }}</td>@endif
                                        <td><a class="sims-link" href="{{ route('dashboard.support.show', $ticket) }}">{{ $ticket->subject }}</a></td>
                                        <td>{{ ucfirst($ticket->priority) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</td>
                                        <td>{{ optional($ticket->updated_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5">No support tickets found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $tickets->links() }}</div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
