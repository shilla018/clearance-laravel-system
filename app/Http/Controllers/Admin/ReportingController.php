<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClearanceApplication;
use App\Models\ClearanceReview;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class ReportingController extends Controller
{
    /**
     * Show reporting dashboard
     */
    public function dashboard(): View
    {
        return view('admin.reports.dashboard', [
            'stats' => $this->getStats(),
            'departmentStats' => $this->getDepartmentStats(),
            'timelineData' => $this->getTimelineData(),
            'topIssues' => $this->getTopIssues(),
        ]);
    }

    /**
     * Get overall statistics
     */
    private function getStats(): array
    {
        $totalApplications = ClearanceApplication::count();
        $approvedApplications = ClearanceApplication::where('status', 'approved')->count();
        $deniedApplications = ClearanceApplication::where('status', 'denied')->count();
        $pendingApplications = ClearanceApplication::where('status', 'pending')->count();

        $avgTimeToComplete = ClearanceApplication::whereNotNull('completed_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, applied_at, completed_at)) as avg_hours')
            ->value('avg_hours');

        return [
            'total_applications' => $totalApplications,
            'approved' => [
                'count' => $approvedApplications,
                'percentage' => $totalApplications > 0 ? round(($approvedApplications / $totalApplications) * 100, 2) : 0,
            ],
            'denied' => [
                'count' => $deniedApplications,
                'percentage' => $totalApplications > 0 ? round(($deniedApplications / $totalApplications) * 100, 2) : 0,
            ],
            'pending' => [
                'count' => $pendingApplications,
                'percentage' => $totalApplications > 0 ? round(($pendingApplications / $totalApplications) * 100, 2) : 0,
            ],
            'avg_completion_hours' => round($avgTimeToComplete ?? 0, 2),
            'total_students' => User::where('role', 'student')->count(),
        ];
    }

    /**
     * Get department-wise statistics
     */
    private function getDepartmentStats(): array
    {
        $departments = ClearanceApplication::DEPARTMENTS;
        $stats = [];

        foreach ($departments as $key => $name) {
            $reviews = ClearanceReview::where('department_key', $key);
            $approved = (clone $reviews)->where('status', 'approved')->count();
            $denied = (clone $reviews)->where('status', 'denied')->count();
            $pending = (clone $reviews)->where('status', 'pending')->count();
            $total = $approved + $denied + $pending;

            $stats[] = [
                'department' => $name,
                'approved' => $approved,
                'denied' => $denied,
                'pending' => $pending,
                'total' => $total,
                'approval_rate' => $total > 0 ? round(($approved / $total) * 100, 2) : 0,
            ];
        }

        return $stats;
    }

    /**
     * Get timeline data (applications per day for past 30 days)
     */
    private function getTimelineData(): array
    {
        $data = [];
        $today = Carbon::now();

        for ($i = 29; $i >= 0; $i--) {
            $date = $today->clone()->subDays($i);
            $count = ClearanceApplication::whereDate('applied_at', $date)->count();

            $data[] = [
                'date' => $date->format('M d'),
                'applications' => $count,
            ];
        }

        return $data;
    }

    /**
     * Get top issues (most common reasons for denial)
     */
    private function getTopIssues(): array
    {
        return ClearanceReview::where('status', 'denied')
            ->selectRaw('department_key, department_name, COUNT(*) as denial_count')
            ->groupBy('department_key', 'department_name')
            ->orderByDesc('denial_count')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'department' => $item->department_name,
                    'denials' => $item->denial_count,
                ];
            })
            ->toArray();
    }

    /**
     * Export detailed report
     */
    public function export()
    {
        $filename = 'clearance-detailed-report-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Registration No',
                'Student Name',
                'Status',
                'Applied At',
                'Completed At',
                'Days to Complete',
                'Finance Status',
                'Library Status',
                'Academic Status',
                'Accommodation Status',
            ]);

            ClearanceApplication::with(['student', 'reviews'])
                ->latest('applied_at')
                ->chunk(100, function ($applications) use ($handle) {
                    foreach ($applications as $app) {
                        $reviews = $app->reviews->keyBy('department_key');

                        $daysToComplete = null;
                        if ($app->applied_at && $app->completed_at) {
                            $daysToComplete = $app->completed_at->diffInDays($app->applied_at);
                        }

                        fputcsv($handle, [
                            $app->student?->registration_number,
                            $app->student?->full_name ?? $app->student?->name,
                            ucfirst($app->status),
                            $app->applied_at?->format('Y-m-d H:i'),
                            $app->completed_at?->format('Y-m-d H:i'),
                            $daysToComplete,
                            $reviews->get('finance')?->status ?? 'pending',
                            $reviews->get('library')?->status ?? 'pending',
                            $reviews->get('academic')?->status ?? 'pending',
                            $reviews->get('accommodation')?->status ?? 'pending',
                        ]);
                    }
                });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
