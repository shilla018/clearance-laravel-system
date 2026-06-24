@extends('layouts.clearanceDashboardLayout')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <section class="sims-panel">
        <div class="sims-panel__header">
            <h3>Accommodation Clearance</h3>
            <span>{{ $accommodation['status'] }}</span>
        </div>
        <div class="sims-panel__body">
            <div class="sims-student-result-heading mb-3">
                <strong>{{ $student['registration_no'] }} - {{ $student['name'] }}</strong>
                <div>{{ $accommodation['hostel'] }}</div>
            </div>

            <p class="{{ $accommodation['status'] === 'No Pending' ? 'text-success' : 'sims-warning-text' }}">
                {{ $accommodation['summary'] }}
            </p>

            <div class="table-responsive">
                <table class="table sims-table align-middle">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Details</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($accommodation['items'] as $item)
                            <tr>
                                <td>{{ $item['item'] }}</td>
                                <td>{{ $item['detail'] }}</td>
                                <td>{{ $item['amount'] }}</td>
                                <td><span class="sims-badge">{{ $item['status'] }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-success fw-semibold">No Pending</td>
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
