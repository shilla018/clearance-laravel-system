@extends('layouts.clearanceDashboardLayout')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <section class="sims-panel">
        <div class="sims-panel__header">
            <h3>Import Students</h3>
        </div>
        <div class="sims-panel__body">
            <form method="POST" action="{{ route('admin.users.import') }}" enctype="multipart/form-data" class="row g-3">
                @csrf
                <div class="col-lg-8">
                    <label class="form-label">CSV file</label>
                    <input type="file" name="csv_file" class="form-control @error('csv_file') is-invalid @enderror" accept=".csv,.txt" required>
                    @error('csv_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <button class="btn btn-primary btn-sm"><i class="bi bi-upload"></i> Import</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
