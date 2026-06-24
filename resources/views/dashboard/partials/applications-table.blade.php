<div class="table-responsive">
    <table class="table sims-table align-middle">
        <thead>
            <tr>
                <th>Reg No</th>
                <th>Student</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Applied</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($applications as $application)
                <tr>
                    <td>{{ $application->student?->registration_number }}</td>
                    <td>{{ $application->student?->full_name ?? $application->student?->name }}</td>
                    <td>{{ $application->reason }}</td>
                    <td>{{ $application->status === 'denied' ? 'Declined' : ucfirst($application->status) }}</td>
                    <td>{{ optional($application->applied_at)->format('d M Y') }}</td>
                    <td><a class="btn btn-sm btn-outline-primary" href="{{ route('dashboard.applications.show', $application) }}"><i class="bi bi-eye"></i> View</a></td>
                </tr>
            @empty
                <tr><td colspan="6">No clearance applications found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
