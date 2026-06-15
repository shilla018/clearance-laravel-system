@extends('layouts.clearanceDashboardLayout')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <section class="sims-panel">
        <div class="sims-panel__header">
            <h3>Published Results</h3>
        </div>
        <div class="sims-panel__body">
            <div class="sims-student-result-heading">
                <strong>Higher Diploma in Information Technology - [ HDIT ]</strong>
            </div>

            @foreach ($resultSemesters as $semester)
                <section class="sims-result-block">
                    <h4>{{ $semester['title'] }}</h4>
                    <div class="table-responsive">
                        <table class="table sims-table sims-results-table align-middle">
                            <thead>
                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Name</th>
                                    <th>Unit</th>
                                    <th>CA</th>
                                    <th>SE</th>
                                    <th>Total</th>
                                    <th>Grade</th>
                                    <th>Point</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($semester['courses'] as $course)
                                    <tr>
                                        <td><a href="#" class="sims-link">{{ $course['code'] }}</a></td>
                                        <td>{{ $course['name'] }}</td>
                                        <td>{{ $course['unit'] }}</td>
                                        <td>{{ $course['ca'] }}</td>
                                        <td>{{ $course['se'] }}</td>
                                        <td>{{ $course['total'] }}</td>
                                        <td>{{ $course['grade'] }}</td>
                                        <td>{{ $course['point'] }}</td>
                                        <td>{{ $course['remark'] }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6"></td>
                                    <td><strong>Semester GPA :</strong></td>
                                    <td><strong>{{ $semester['gpa'] }}</strong></td>
                                    <td><strong>PASS</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            @endforeach

            <section class="sims-result-summary">
                <h4>YEAR SUMMARY STATUS - 2023/2024</h4>
                <div class="table-responsive">
                    <table class="table sims-table">
                        <tbody>
                            @foreach ($summary as $label => $value)
                                <tr>
                                    <th>{{ $label }} :</th>
                                    <td>{{ $value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
