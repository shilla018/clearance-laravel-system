@extends('layouts.clearanceDashboardLayout')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <div class="row g-3 g-xl-4">
        <div class="col-xl-8">
            <section class="sims-panel mb-3">
                <div class="sims-panel__header">
                    <h3>{{ $student['registration_no'] }} - {{ $student['name'] }}</h3>
                    <span>{{ $application->status === 'denied' ? 'Declined' : ucfirst($application->status) }}</span>
                </div>
                <div class="sims-panel__body">
                    <div class="table-responsive mb-3">
                        <table class="table sims-table sims-profile-table">
                            <tbody>
                                <tr>
                                    <td><strong>Programme:</strong> {{ $student['programme'] }}</td>
                                    <td><strong>Department:</strong> {{ $student['department'] }}</td>
                                    <td><strong>Level:</strong> {{ $student['level'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong> {{ $student['phone'] }}</td>
                                    <td><strong>Email:</strong> {{ $student['email'] }}</td>
                                    <td><strong>Reason:</strong> {{ $application->reason }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="sims-clearance-grid">
                        @foreach ($application->reviews as $review)
                            <article class="sims-clearance-step">
                                <div class="sims-clearance-step__icon {{ $review->status === 'approved' ? 'is-ready' : ($review->status === 'denied' ? 'is-denied' : 'is-pending') }}">
                                    <i class="bi {{ $review->status === 'approved' ? 'bi-check2' : ($review->status === 'denied' ? 'bi-x-lg' : 'bi-hourglass-split') }}"></i>
                                </div>
                                <div>
                                    <strong>{{ $review->department_name }}</strong>
                                    <span>{{ $review->status === 'denied' ? 'Declined' : ucfirst($review->status) }}</span>
                                    <small>{{ $review->comments }}</small>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        @if ($departmentScope === 'finance' || $departmentScope === 'all')
                            <h4 class="sims-section-title sims-section-title--danger">Payment Records</h4>
                            @foreach (($departmentData['payments'] ?? []) as $paymentYear)
                                <section class="sims-invoice-block">
                                    <h4>Invoice for Academic Year : {{ $paymentYear['year'] }}</h4>
                                    <div class="table-responsive">
                                        <table class="table sims-table align-middle">
                                            <thead>
                                                <tr>
                                                    <th>InvoiceNo</th>
                                                    <th>Control Number</th>
                                                    <th>Description</th>
                                                    <th class="text-end">Invoice Amount</th>
                                                    <th class="text-end">Paid Amount</th>
                                                    <th class="text-end">Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($paymentYear['invoices'] as $invoice)
                                                    <tr>
                                                        <td>{{ $invoice['invoice_no'] }}</td>
                                                        <td>{{ $invoice['control_number'] }}</td>
                                                        <td>{{ $invoice['description'] }}</td>
                                                        <td class="text-end">{{ $invoice['amount'] }}</td>
                                                        <td class="text-end">{{ $invoice['paid'] }}</td>
                                                        <td class="text-end {{ $invoice['balance'] !== '0.00' ? 'sims-balance-due' : '' }}">{{ $invoice['balance'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            @endforeach
                        @endif

                        @if ($departmentScope === 'academic' || $departmentScope === 'all')
                            <h4 class="sims-section-title sims-section-title--danger">Academic Results</h4>
                            @foreach (($departmentData['results'] ?? []) as $semester)
                                <section class="sims-result-block">
                                    <h4>{{ $semester['title'] }}</h4>
                                    <div class="table-responsive">
                                        <table class="table sims-table sims-results-table align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Name</th>
                                                    <th>Total</th>
                                                    <th>Grade</th>
                                                    <th>Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($semester['courses'] as $course)
                                                    <tr>
                                                        <td>{{ $course['code'] }}</td>
                                                        <td>{{ $course['name'] }}</td>
                                                        <td>{{ $course['total'] }}</td>
                                                        <td>{{ $course['grade'] }}</td>
                                                        <td>{{ $course['remark'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            @endforeach
                        @endif

                        @if ($departmentScope === 'accommodation' || $departmentScope === 'all')
                            @php($accommodation = $departmentData['accommodation'] ?? null)
                            <h4 class="sims-section-title sims-section-title--danger">Accommodation Information</h4>
                            @if ($accommodation)
                                <p><strong>Hostel:</strong> {{ $accommodation['hostel'] }} | <strong>Status:</strong> {{ $accommodation['status'] }}</p>
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
                                                    <td>{{ $item['status'] }}</td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="4" class="text-success fw-semibold">No Pending</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @endif

                        @if ($departmentScope === 'library' || $departmentScope === 'all')
                            @php($library = $departmentData['library'] ?? null)
                            <h4 class="sims-section-title sims-section-title--danger">Library Information</h4>
                            @if ($library)
                                <p class="{{ $library['status'] === 'No Pending' ? 'text-success fw-semibold' : '' }}">{{ $library['summary'] }}</p>
                                <div class="table-responsive">
                                    <table class="table sims-table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Book Title</th>
                                                <th>Accession No</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($library['books'] as $book)
                                                <tr>
                                                    <td>{{ $book['title'] }}</td>
                                                    <td>{{ $book['accession_no'] }}</td>
                                                    <td>{{ $book['due_at'] }}</td>
                                                    <td>{{ $book['status'] }}</td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="4" class="text-success fw-semibold">No Pending</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </section>

            @if (auth()->user()->isOfficer())
                @php($review = $application->reviews->firstWhere('department_key', auth()->user()->department_key))
                @if ($review)
                    <section class="sims-panel">
                        <div class="sims-panel__header">
                            <h3>Department Decision</h3>
                        </div>
                        <div class="sims-panel__body">
                            <form method="POST" action="{{ route('dashboard.applications.review', [$application, $review]) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Comments or instructions</label>
                                    <textarea name="comments" class="form-control" rows="4">{{ old('comments', $review->comments) }}</textarea>
                                </div>
                                <button type="submit" name="status" value="approved" class="btn btn-success btn-sm" data-no-spinner @disabled($review->status !== 'pending')><i class="bi bi-check2"></i> Approve</button>
                                <button type="submit" name="status" value="denied" class="btn btn-danger btn-sm" data-no-spinner @disabled($review->status !== 'pending')><i class="bi bi-x-lg"></i> Decline</button>
                                @if ($review->status !== 'pending')
                                    <span class="text-muted small ms-2">Decision already saved by this department.</span>
                                @endif
                            </form>
                        </div>
                    </section>
                @endif
            @endif
        </div>

        <div class="col-xl-4">
            <section class="sims-panel">
                <div class="sims-panel__header">
                    <h3>Audit Logs</h3>
                </div>
                <div class="sims-panel__body">
                    @forelse ($auditLogs as $log)
                        <article class="mb-3">
                            <strong>{{ $log->description }}</strong>
                            <div class="text-muted small">{{ $log->actor_name }} - {{ optional($log->created_at)->format('d M Y, H:i') }}</div>
                        </article>
                    @empty
                        <p class="text-muted mb-0">No approval activity recorded yet.</p>
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
