@extends('layouts.clearanceDashboardLayout')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <section class="sims-panel">
        <div class="sims-panel__header">
            <h3>Library Clearance</h3>
            <span>{{ $library['status'] }}</span>
        </div>
        <div class="sims-panel__body">
            <div class="sims-student-result-heading mb-3">
                <strong>{{ $student['registration_no'] }} - {{ $student['name'] }}</strong>
            </div>

            <p class="{{ $library['status'] === 'No Pending' ? 'text-success fw-semibold' : 'sims-warning-text' }}">
                {{ $library['summary'] }}
            </p>

            <div class="table-responsive">
                <table class="table sims-table align-middle">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Accession No</th>
                            <th>Borrowed Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($library['books'] as $book)
                            <tr>
                                <td>{{ $book['title'] }}</td>
                                <td>{{ $book['accession_no'] }}</td>
                                <td>{{ $book['borrowed_at'] }}</td>
                                <td>{{ $book['due_at'] }}</td>
                                <td><span class="sims-badge">{{ $book['status'] }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-success fw-semibold">No Pending</td>
                            </tr>
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
