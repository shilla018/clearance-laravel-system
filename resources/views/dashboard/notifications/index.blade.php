@extends('layouts.clearanceDashboardLayout')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
        <section class="sims-panel">
            <div class="sims-panel__header">
                <h3>Notifications</h3>
                <form method="POST" action="{{ route('dashboard.notifications.mark-all-read') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-primary"><i class="bi bi-check2-all"></i> Mark all read</button>
                </form>
            </div>
            <div class="sims-panel__body">
                <div class="table-responsive">
                    <table class="table sims-table align-middle">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($notifications as $notification)
                                <tr>
                                    <td><a class="sims-link" href="{{ route('dashboard.notifications.show', $notification->id) }}">{{ $notification->title }}</a></td>
                                    <td>{{ $notification->message }}</td>
                                    <td>{{ ucfirst($notification->status) }}</td>
                                    <td>{{ optional($notification->created_at)->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4">No notifications yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if (method_exists($notifications, 'links'))
                    <div class="mt-3">{{ $notifications->links() }}</div>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
