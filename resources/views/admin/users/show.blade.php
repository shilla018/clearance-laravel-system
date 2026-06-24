@extends('layouts.clearanceDashboardLayout')

@section('page_header_actions')
    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">
        <i class="bi bi-pencil-square"></i> Edit
    </a>
@endsection

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <section class="sims-panel">
        <div class="sims-panel__header">
            <h3>{{ $user->full_name ?? $user->name }}</h3>
            <span>{{ ucfirst($user->role) }}</span>
        </div>
        <div class="sims-panel__body">
            <table class="table sims-table sims-profile-table">
                <tbody>
                    <tr>
                        <td><strong>Email:</strong> {{ $user->email }}</td>
                        <td><strong>Reg No:</strong> {{ $user->registration_number ?? '-' }}</td>
                        <td><strong>Phone:</strong> {{ $user->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Programme:</strong> {{ $user->programme ?? '-' }}</td>
                        <td><strong>Department:</strong> {{ $user->department ?? '-' }}</td>
                        <td><strong>Level:</strong> {{ $user->level ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Campus:</strong> {{ $user->campus ?? '-' }}</td>
                        <td><strong>Academic Year:</strong> {{ $user->academic_year ?? '-' }}</td>
                        <td><strong>Last Login:</strong> {{ optional($user->last_login_at)->format('d M Y H:i') ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
