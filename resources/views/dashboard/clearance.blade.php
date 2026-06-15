@extends('layouts.clearanceDashboardLayout')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    @if ($clearance['status'] === 'Blocked')
        <section class="sims-status-alert sims-status-alert--danger mb-3">
            {{ $clearance['message'] }}
        </section>
    @endif

    <section class="sims-panel">
        <div class="sims-panel__header">
            <h3>Clearance Application</h3>
        </div>
        <div class="sims-panel__body">
            <div class="table-responsive mb-3">
                <table class="table sims-table sims-profile-table">
                    <tbody>
                        <tr>
                            <td><strong>Student RegNo :</strong> {{ $student['registration_no'] }}</td>
                            <td><strong>Student Name :</strong> {{ $student['name'] }}</td>
                            <td><strong>Sex :</strong> {{ $student['sex'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Mobile Number :</strong> {{ $student['phone'] }}</td>
                            <td colspan="2"><strong>Email :</strong> {{ $student['email'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <strong>Programme :</strong> {{ $student['programme'] }}<br>
                                <strong>Department :</strong> {{ $student['department'] }}
                            </td>
                            <td><strong>Level :</strong> {{ $student['level'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="sims-clearance-grid mb-4">
                @foreach ($clearance['progress'] as $item)
                    <article class="sims-clearance-step">
                        <div class="sims-clearance-step__icon {{ $item['status'] === 'Pending' ? 'is-pending' : 'is-ready' }}">
                            <i class="bi {{ $item['status'] === 'Pending' ? 'bi-exclamation-triangle' : 'bi-check2' }}"></i>
                        </div>
                        <div>
                            <strong>{{ $item['office'] }}</strong>
                            <span>{{ $item['status'] }}</span>
                            <small>{{ $item['note'] }}</small>
                        </div>
                    </article>
                @endforeach
            </div>

            <form method="POST" action="{{ route('dashboard.clearance.submit') }}" class="sims-clearance-form">
                @csrf
                <div class="row g-3 align-items-center">
                    <label for="reason" class="col-lg-3 col-form-label">Reason for Clearance : <span>*</span></label>
                    <div class="col-lg-9">
                        <select id="reason" name="reason" class="form-select @error('reason') is-invalid @enderror" required>
                            <option value="">Select Reason</option>
                            <option value="Graduation">Graduation</option>
                            <option value="Transfer">Transfer</option>
                            <option value="Completion of Studies">Completion of Studies</option>
                        </select>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <label for="mobile_number" class="col-lg-3 col-form-label">Your Current Mobile Number : <span>*</span></label>
                    <div class="col-lg-9">
                        <input id="mobile_number" name="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" value="{{ old('mobile_number', $student['phone']) }}" required>
                        @error('mobile_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <label for="academic_year" class="col-lg-3 col-form-label">AYear/Semester : <span>*</span></label>
                    <div class="col-lg-9">
                        <select id="academic_year" name="academic_year" class="form-select @error('academic_year') is-invalid @enderror" required>
                            <option value="{{ $student['academic_year'] }}">{{ $student['academic_year'] }}</option>
                            <option value="2024/2025 - Semester II">2024/2025 - Semester II</option>
                        </select>
                        @error('academic_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="sims-form-actions">
                    <button class="btn btn-primary btn-sm" type="submit">
                        <i class="bi bi-upload"></i> Submit Request
                    </button>
                    <span>Pending payment: <strong>{{ $clearance['pending_payment'] }}</strong></span>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
