@extends('layouts.clearanceDashboardLayout')

@section('page_header_actions')
    <a href="{{ route('admin.users.import-form') }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-upload"></i> Import CSV
    </a>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus"></i> New User
    </a>
@endsection

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <section class="sims-panel mb-3">
        <div class="sims-panel__body">
            <form method="GET" class="row g-2">
                <div class="col-md-7">
                    <input name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name, email, or registration number">
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">All roles</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" @selected(request('role') === $role)>{{ ucfirst($role) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary"><i class="bi bi-search"></i> Search</button>
                </div>
            </form>
        </div>
    </section>

    <section class="sims-panel">
        <div class="sims-panel__header">
            <h3>System Users</h3>
        </div>
        <div class="sims-panel__body">
            <div class="table-responsive">
                <table class="table sims-table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Reg No</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->full_name ?? $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->registration_number ?? '-' }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>{{ $user->department ?? '-' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6">No users found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $users->links() }}
        </div>
    </section>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
