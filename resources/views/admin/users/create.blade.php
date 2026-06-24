@extends('layouts.clearanceDashboardLayout')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <section class="sims-panel">
        <div class="sims-panel__header">
            <h3>Create User</h3>
        </div>
        <div class="sims-panel__body">
            <form method="POST" action="{{ route('admin.users.store') }}" class="row g-3">
                @csrf
                @include('admin.users.partials.form', ['user' => null, 'departments' => $departments, 'roles' => $roles])
                <div class="col-12">
                    <button class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Save User</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
