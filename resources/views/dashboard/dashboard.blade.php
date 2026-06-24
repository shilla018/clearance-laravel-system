@extends('layouts.clearanceDashboardLayout')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <section class="sims-status-alert sims-status-alert--danger mb-3">
        <strong>REGISTRATION STATUS ACADEMIC YEAR : 2025/2026 - Semester II</strong>
        <span>You have been Registered in BACHELOR DEGREE IN INFORMATION TECHNOLOGY - THIRD YEAR</span>
    </section>

    <div class="row g-3 g-xl-4 mb-4">
        @foreach ($stats as $stat)
            <div class="col-6 col-xxl-3">
                <article class="dashboard-stat-card dashboard-stat-card--{{ $stat['tone'] }}">
                    <div class="dashboard-stat-card__icon">
                        <i class="bi {{ $stat['icon'] }}"></i>
                    </div>
                    <div>
                        <span class="dashboard-stat-card__label">{{ $stat['label'] }}</span>
                        <h2 class="dashboard-stat-card__value">{{ $stat['value'] }}</h2>
                    </div>
                </article>
            </div>
        @endforeach
    </div>

    <div class="row g-3 g-xl-4 mb-4">
        @foreach ($summaryTiles as $tile)
            <div class="col-6 col-xl-3">
                <article class="dashboard-summary-tile">
                    <div class="dashboard-summary-tile__icon">
                        <i class="bi {{ $tile['icon'] }}"></i>
                    </div>
                    <div>
                        <span class="dashboard-summary-tile__label">{{ $tile['label'] }}</span>
                        <div class="dashboard-summary-tile__value">{{ $tile['value'] }}</div>
                    </div>
                </article>
            </div>
        @endforeach
    </div>

    <div class="row g-3 g-xl-4">
        <div class="col-12">
            <section class="sims-panel mb-3">
                <div class="sims-panel__header">
                    <h3>Dashboard</h3>
                    <i class="bi bi-gear"></i>
                </div>
                <div class="sims-panel__body">
                    <h4 class="sims-section-title sims-section-title--danger">Examination Numbers</h4>
                    <div class="table-responsive">
                        <table class="table sims-table align-middle">
                            <thead>
                                <tr>
                                    <th>ExamType</th>
                                    <th>AYear</th>
                                    <th>ExamNo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CA Exams</td>
                                    <td>{{ $student['academic_year'] }}</td>
                                    <td><a href="#" class="sims-link"><i class="bi bi-download"></i> CA/BIT/252/6407</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="sims-warning-text mb-0">System will accept results for only students with Examination Number generated from the System for specific Semester</p>
                </div>
            </section>

            <section class="sims-panel">
                <div class="sims-panel__header">
                    <h3>Notifications</h3>
                </div>
                <div class="sims-panel__body">
                    <h4 class="sims-mini-heading"><i class="bi bi-check-lg text-danger"></i> Result Uploads Deadline</h4>
                    <div class="table-responsive">
                        <table class="table sims-table align-middle">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Deadline</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ([
                                    ['Diploma [ NTA Level 4 - 6 ]', 'CA Exams', '12-06-2026'],
                                    ['Diploma [ NTA Level 4 - 6 ]', 'SE Exams', '12-06-2026'],
                                    ['Bachelor [ UQF 6 - 8 ]', 'CA Exams', '16-06-2026'],
                                    ['Bachelor [ UQF 6 - 8 ]', 'SE Exams', '16-06-2026'],
                                    ['Bachelor [ UQF 6 - 8 ]', 'SUPP/SPECIAL Exams', '17-06-2026'],
                                    ['Postgraduate Diploma', 'CA Exams', '16-12-2025'],
                                ] as $deadline)
                                    <tr>
                                        <td>{{ $deadline[0] }}</td>
                                        <td>{{ $deadline[1] }}</td>
                                        <td>{{ $deadline[2] }}</td>
                                    </tr>
                                @endforeach
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
