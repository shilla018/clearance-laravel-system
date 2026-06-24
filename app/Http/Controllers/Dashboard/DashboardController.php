<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AuditTrail;
use App\Models\ClearanceApplication;
use App\Models\ClearanceReview;
use App\Models\SystemNotification;
use App\Models\User;
use App\Services\AuditTrailService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        if ($user->isOfficer()) {
            return $this->officerDashboard($user);
        }

        $student = $this->studentProfile($user);
        $payments = $this->paymentYears($user);
        $resultSemesters = $this->resultSemesters($user);
        $clearance = $this->clearanceProfile($user);
        $paymentSummary = $this->paymentSummary($user);

        $stats = [
            [
                'label' => 'Registration Status',
                'value' => $student['registration_status'],
                'icon' => 'bi-person-check',
                'tone' => 'blue',
            ],
            [
                'label' => 'Paid Amount',
                'value' => $paymentSummary['paid'],
                'icon' => 'bi-credit-card',
                'tone' => 'slate',
            ],
            [
                'label' => 'Pending Balance',
                'value' => $paymentSummary['pending'],
                'icon' => 'bi-hourglass-split',
                'tone' => 'teal',
            ],
            [
                'label' => 'Annual GPA',
                'value' => '3.2',
                'icon' => 'bi-award',
                'tone' => 'amber',
            ],
        ];

        $summaryTiles = [
            [
                'label' => 'Programme',
                'value' => 'BIT - Year 3',
                'icon' => 'bi-mortarboard',
            ],
            [
                'label' => 'Academic Year',
                'value' => '2025/2026',
                'icon' => 'bi-calendar3',
            ],
            [
                'label' => 'Current Semester',
                'value' => 'Semester II',
                'icon' => 'bi-journal-text',
            ],
            [
                'label' => 'Clearance',
                'value' => $clearance['status_label'],
                'icon' => 'bi-clipboard-check',
            ],
            [
                'label' => 'Accommodation',
                'value' => $this->accommodationSummary($user)['status'],
                'icon' => 'bi-house-check',
            ],
            [
                'label' => 'Library',
                'value' => $this->librarySummary($user)['status'],
                'icon' => 'bi-book',
            ],
        ];

        return view('dashboard.dashboard', compact(
            'student',
            'payments',
            'resultSemesters',
            'clearance',
            'stats',
            'summaryTiles'
        ));
    }

    public function payments(): View
    {
        return view('dashboard.payments', [
            'student' => $this->studentProfile(auth()->user()),
            'paymentYears' => $this->paymentYears(auth()->user()),
        ]);
    }

    public function results(): View
    {
        return view('dashboard.results', [
            'student' => $this->studentProfile(auth()->user()),
            'resultSemesters' => $this->resultSemesters(auth()->user()),
            'summary' => $this->resultSummary(auth()->user()),
        ]);
    }

    public function accommodation(): View
    {
        $user = auth()->user();

        return view('dashboard.accommodation', [
            'student' => $this->studentProfile($user),
            'accommodation' => $this->accommodationSummary($user),
        ]);
    }

    public function library(): View
    {
        $user = auth()->user();

        return view('dashboard.library', [
            'student' => $this->studentProfile($user),
            'library' => $this->librarySummary($user),
        ]);
    }

    public function clearance(): View
    {
        $user = auth()->user();

        return view('dashboard.clearance', [
            'student' => $this->studentProfile($user),
            'clearance' => $this->clearanceProfile($user),
        ]);
    }

    public function submitClearance(Request $request): RedirectResponse
    {
        $request->validate([
            'reason' => ['required', 'string', 'max:120'],
            'mobile_number' => ['required', 'string', 'max:30'],
            'academic_year' => ['required', 'string', 'max:40'],
        ]);

        $application = ClearanceApplication::create([
            'user_id' => $request->user()->id,
            'reason' => $request->input('reason'),
            'mobile_number' => $request->input('mobile_number'),
            'academic_year' => $request->input('academic_year'),
            'status' => 'pending',
            'applied_at' => now(),
            'due_at' => now()->addDays(14),
        ]);

        SystemNotification::create([
            'user_id' => $request->user()->id,
            'title' => 'Clearance application submitted',
            'message' => 'Your clearance sections are pending departmental review.',
            'type' => 'clearance',
            'action_url' => route('dashboard.clearance.index'),
        ]);

        app(AuditTrailService::class)->log(
            action: 'clearance.applied',
            subject: $application,
            description: 'Student submitted a clearance application.',
            actor: $request->user(),
            request: $request,
        );

        return back()->with('success', 'Clearance application submitted successfully.');
    }

    public function applications(Request $request): View
    {
        $query = ClearanceApplication::with(['student', 'reviews.reviewer'])->latest('applied_at');

        if ($request->user()->isOfficer()) {
            $query->whereHas('reviews', fn ($reviews) => $reviews->where('department_key', $request->user()->department_key));
        }

        if ($search = $request->string('search')->trim()->toString()) {
            $query->whereHas('student', function ($students) use ($search) {
                $students->where('full_name', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        if ($status = $request->string('status')->trim()->toString()) {
            $query->where('status', $status);
        }

        return view('dashboard.applications.index', [
            'applications' => $query->paginate(12)->withQueryString(),
        ]);
    }

    public function showApplication(Request $request, ClearanceApplication $application): View
    {
        $application->load(['student', 'reviews.reviewer']);

        if ($request->user()->isOfficer() && ! $application->reviews->contains('department_key', $request->user()->department_key)) {
            abort(403);
        }

        return view('dashboard.applications.show', [
            'application' => $application,
            'student' => $this->studentProfile($application->student),
            'departmentScope' => $this->departmentScopeFor($request->user()),
            'departmentData' => $this->departmentDataFor($request->user(), $application->student),
            'auditLogs' => AuditTrail::where('subject_type', $application->getMorphClass())
                ->where('subject_id', $application->id)
                ->latest()
                ->limit(8)
                ->get(),
        ]);
    }

    public function reviewApplication(Request $request, ClearanceApplication $application, ClearanceReview $review): RedirectResponse
    {
        if ($review->clearance_application_id !== $application->id || $review->department_key !== $request->user()->department_key) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => ['required', 'in:approved,denied'],
            'comments' => ['nullable', 'string', 'max:2000'],
        ]);

        $oldValues = $review->only(['status', 'comments', 'reviewed_by', 'reviewed_at']);

        if (in_array($review->status, ['approved', 'denied'], true)) {
            return back()->with('info', 'This department has already made a decision for this clearance request.');
        }

        $review->update([
            'status' => $validated['status'],
            'comments' => $validated['comments'] ?: ($validated['status'] === 'approved' ? 'Approved.' : 'Please contact this department for corrections.'),
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        $application->refreshStatusFromReviews();

        SystemNotification::create([
            'user_id' => $application->user_id,
            'title' => $review->department_name.' clearance '.$this->clearanceStatusLabel($validated['status']),
            'message' => $review->comments,
            'type' => 'clearance',
            'action_url' => route('dashboard.clearance.index'),
        ]);

        app(AuditTrailService::class)->log(
            action: 'clearance.'.$validated['status'],
            subject: $application,
            oldValues: $oldValues,
            newValues: $review->fresh()->only(['status', 'comments', 'reviewed_by', 'reviewed_at']),
            description: $review->department_name.' marked clearance as '.$validated['status'].'.',
            actor: $request->user(),
            request: $request,
        );

        return back()->with('success', 'Clearance review saved.');
    }

    public function resubmitClearance(Request $request, ClearanceApplication $application): RedirectResponse
    {
        // Check if application belongs to user and can be resubmitted
        if ($application->user_id !== $request->user()->id) {
            abort(403);
        }

        if (!$application->canResubmit()) {
            return back()->with('error', 'Ombi hili haliwezi kusubmitwa tena.');
        }

        // Validate resubmission
        $request->validate([
            'reason' => ['required', 'string', 'max:120'],
            'mobile_number' => ['required', 'string', 'max:30'],
            'academic_year' => ['required', 'string', 'max:40'],
        ]);

        // Create new application as resubmission
        $newApplication = ClearanceApplication::create([
            'user_id' => $request->user()->id,
            'reason' => $request->input('reason'),
            'mobile_number' => $request->input('mobile_number'),
            'academic_year' => $request->input('academic_year'),
            'status' => 'pending',
            'applied_at' => now(),
            'due_at' => now()->addDays(14),
            'parent_application_id' => $application->id,
            'resubmission_count' => $application->resubmission_count + 1,
        ]);

        // Mark old application
        $application->update([
            'resubmission_allowed' => false,
        ]);

        // New reviews are auto-created via Observer
        SystemNotification::create([
            'user_id' => $request->user()->id,
            'title' => 'Clearance Resubmitted',
            'message' => 'Your resubmitted clearance application is pending departmental review.',
            'type' => 'clearance',
            'action_url' => route('dashboard.clearance.index'),
        ]);

        app(AuditTrailService::class)->log(
            action: 'clearance.resubmitted',
            subject: $newApplication,
            description: 'Student resubmitted clearance application after initial denial.',
            actor: $request->user(),
            request: $request,
        );

        return back()->with('success', 'Clearance application resubmitted successfully.');
    }

    public function statistics(): View
    {
        return view('dashboard.statistics', [
            'analytics' => $this->analytics(),
            'recentApplications' => ClearanceApplication::with('student')->latest('applied_at')->limit(8)->get(),
        ]);
    }

    public function exportClearanceReport(): StreamedResponse
    {
        $filename = 'clearance-report-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Reg No', 'Student', 'Programme', 'Status', 'Applied At', 'Completed At']);

            ClearanceApplication::with('student')->latest('applied_at')->chunk(100, function ($applications) use ($handle) {
                foreach ($applications as $application) {
                    fputcsv($handle, [
                        $application->student?->registration_number,
                        $application->student?->full_name ?? $application->student?->name,
                        $application->student?->programme,
                        ucfirst($application->status),
                        optional($application->applied_at)->format('Y-m-d H:i'),
                        optional($application->completed_at)->format('Y-m-d H:i'),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    private function studentProfile(?User $user = null): array
    {
        return [
            'name' => $user?->full_name ?? $user?->name ?? 'Godwin Ernest Shilla',
            'registration_no' => $user?->registration_number ?? 'NIT/BIT/2023/2119',
            'email' => $user?->email ?? 'shillagodwin01@gmail.com',
            'phone' => $user?->phone ?? '255693598348',
            'sex' => $user?->sex ?? 'M',
            'programme' => $user?->programme ?? 'Bachelor Degree in Information Technology',
            'department' => $user?->department ?? 'Department of Computing and Communication Technology',
            'level' => $user?->level ?? 'NTA LEVEL : 8',
            'campus' => $user?->campus ?? 'Main Campus',
            'academic_year' => $user?->academic_year ?? '2025/2026 - Semester II',
            'password_expiry' => optional($user?->password_expires_at)->format('d-m-Y') ?? '13-09-2026',
            'registration_status' => 'Registered',
        ];
    }

    private function clearanceProfile(User $user): array
    {
        $application = $user->latestClearanceApplication()->with('reviews')->first();

        if (! $application) {
            return [
                'status' => 'not_applied',
                'status_label' => 'Not Applied',
                'message' => 'Submit your clearance application before any department can process your clearance.',
                'pending_payment' => 'TZS 300,000.00',
                'application' => null,
                'progress' => collect(ClearanceApplication::DEPARTMENTS)->map(fn ($name, $key) => [
                    'key' => $key,
                    'office' => $name,
                    'status' => 'Pending',
                    'status_value' => 'pending',
                    'note' => 'Waiting for application submission',
                ])->values()->all(),
                'percentage' => 0,
                'final_status' => 'Not Completed',
            ];
        }

        $totalReviews = max(1, count(ClearanceApplication::DEPARTMENTS));
        $reviewsByDepartment = $application->reviews->keyBy('department_key');
        $approvedReviews = $application->reviews->where('status', 'approved')->count();
        $declinedReview = $application->reviews->firstWhere('status', 'denied');

        return [
            'status' => $application->status,
            'status_label' => $this->clearanceStatusLabel($application->status),
            'message' => $this->clearanceStatusMessage($application, $declinedReview),
            'pending_payment' => 'TZS 300,000.00',
            'application' => $application,
            'progress' => collect(ClearanceApplication::DEPARTMENTS)->map(function ($departmentName, $departmentKey) use ($reviewsByDepartment) {
                $review = $reviewsByDepartment->get($departmentKey);
                $status = $review?->status ?? 'pending';

                return [
                    'key' => $departmentKey,
                    'office' => $review?->department_name ?? $departmentName,
                    'status' => $this->clearanceStatusLabel($status),
                    'status_value' => $status,
                    'note' => $review?->comments ?: 'Awaiting departmental review.',
                    'reviewed_at' => $review?->reviewed_at,
                    'reviewer' => $review?->reviewer?->name,
                ];
            })->values()->all(),
            'percentage' => (int) round(($approvedReviews / $totalReviews) * 100),
            'final_status' => $application->status === 'approved' ? 'Completed' : 'Not Completed',
        ];
    }

    private function clearanceStatusLabel(string $status): string
    {
        return match ($status) {
            'approved' => 'Approved',
            'denied' => 'Declined',
            default => 'Pending',
        };
    }

    private function clearanceStatusMessage(ClearanceApplication $application, ?ClearanceReview $declinedReview): string
    {
        if ($application->status === 'approved') {
            return 'Your final clearance is complete.';
        }

        if ($application->status === 'denied') {
            $department = $declinedReview?->department_name ?? 'A department';

            return "{$department} declined your clearance. Review the comments below for the next steps.";
        }

        return 'Your clearance application remains pending until every department approves it.';
    }

    private function adminDashboard(): View
    {
        return view('dashboard.admin', [
            'analytics' => $this->analytics(),
            'applications' => ClearanceApplication::with('student')->latest('applied_at')->limit(6)->get(),
            'tickets' => \App\Models\SupportTicket::with('student')->latest()->limit(6)->get(),
        ]);
    }

    private function officerDashboard(User $user): View
    {
        return view('dashboard.officer', [
            'departmentName' => ClearanceApplication::DEPARTMENTS[$user->department_key] ?? $user->department,
            'reviews' => ClearanceReview::with(['application.student'])
                ->where('department_key', $user->department_key)
                ->latest()
                ->limit(12)
                ->get(),
        ]);
    }

    private function analytics(): array
    {
        $students = max(1, User::where('role', 'student')->count());
        $applications = ClearanceApplication::count();
        $approved = ClearanceApplication::where('status', 'approved')->count();
        $onTime = ClearanceApplication::where('status', 'approved')
            ->whereColumn('completed_at', '<=', 'due_at')
            ->count();
        $pending = ClearanceApplication::where('status', 'pending')->count();
        $denied = ClearanceApplication::where('status', 'denied')->count();

        return [
            'students' => $students,
            'applications' => $applications,
            'applied_percentage' => round(($applications / $students) * 100, 1),
            'completed_percentage' => $applications > 0 ? round(($approved / $applications) * 100, 1) : 0,
            'on_time_percentage' => $approved > 0 ? round(($onTime / $approved) * 100, 1) : 0,
            'pending' => $pending,
            'approved' => $approved,
            'denied' => $denied,
            'open_tickets' => \App\Models\SupportTicket::whereIn('status', ['open', 'in_progress'])->count(),
        ];
    }

    private function departmentScopeFor(User $viewer): string
    {
        if ($viewer->isAdmin()) {
            return 'all';
        }

        return $viewer->department_key ?: 'none';
    }

    private function departmentDataFor(User $viewer, User $student): array
    {
        $scope = $this->departmentScopeFor($viewer);

        if ($scope === 'all') {
            return [
                'payments' => $this->paymentYears($student),
                'results' => $this->resultSemesters($student),
                'resultSummary' => $this->resultSummary($student),
                'accommodation' => $this->accommodationSummary($student),
                'library' => $this->librarySummary($student),
            ];
        }

        return match ($scope) {
            'finance' => ['payments' => $this->paymentYears($student)],
            'academic' => [
                'results' => $this->resultSemesters($student),
                'resultSummary' => $this->resultSummary($student),
            ],
            'accommodation' => ['accommodation' => $this->accommodationSummary($student)],
            'library' => ['library' => $this->librarySummary($student)],
            default => [],
        };
    }

    private function paymentYears(?User $user = null): array
    {
        return [
            [
                'year' => '2023/2024',
                'invoices' => [
                    ['invoice_no' => 'NT1010237250', 'control_number' => '995470269923', 'description' => 'Tuition fee', 'mode' => 'PARTIAL', 'currency' => 'TZS', 'amount' => '1,500,000.00', 'paid' => '1,500,000.00', 'balance' => '0.00'],
                    ['invoice_no' => 'NT1040241526', 'control_number' => '995470300242', 'description' => 'Other Fee', 'mode' => 'EXACT', 'currency' => 'TZS', 'amount' => '5,000.00', 'paid' => '5,000.00', 'balance' => '0.00'],
                ],
            ],
            [
                'year' => '2024/2025',
                'invoices' => [
                    ['invoice_no' => 'NT10102412694', 'control_number' => '995470348868', 'description' => 'Tuition fee', 'mode' => 'PARTIAL', 'currency' => 'TZS', 'amount' => '1,500,000.00', 'paid' => '1,500,000.00', 'balance' => '0.00'],
                    ['invoice_no' => 'NT104025615', 'control_number' => '995470364807', 'description' => 'Other Fee', 'mode' => 'EXACT', 'currency' => 'TZS', 'amount' => '5,000.00', 'paid' => '5,000.00', 'balance' => '0.00'],
                ],
            ],
            [
                'year' => '2025/2026',
                'invoices' => [
                    ['invoice_no' => 'NT10102511540', 'control_number' => '995470431649', 'description' => 'Tuition fee', 'mode' => 'PARTIAL', 'currency' => 'TZS', 'amount' => '1,500,000.00', 'paid' => '1,200,000.00', 'balance' => '300,000.00'],
                ],
            ],
        ];
    }

    private function paymentSummary(User $user): array
    {
        $totalPaid = 0;
        $totalPending = 0;

        foreach ($this->paymentYears($user) as $year) {
            foreach ($year['invoices'] as $invoice) {
                $paid = (float) str_replace([',', ' '], ['', ''], $invoice['paid']);
                $balance = (float) str_replace([',', ' '], ['', ''], $invoice['balance']);

                $totalPaid += $paid;
                $totalPending += $balance;
            }
        }

        return [
            'paid' => 'TZS ' . number_format($totalPaid, 2),
            'pending' => 'TZS ' . number_format($totalPending, 2),
        ];
    }

    private function resultSemesters(?User $user = null): array
    {
        return [
            [
                'title' => 'SECOND YEAR - 2024/2025 - SEMESTER II',
                'gpa' => '3.7',
                'courses' => [
                    ['code' => 'GSU 07409', 'name' => 'Research Methodology', 'unit' => 12, 'ca' => '25.0 / 40', 'se' => '24.0 / 60', 'total' => 50, 'grade' => 'B', 'point' => 36, 'remark' => 'PASS'],
                    ['code' => 'ITU 07406', 'name' => 'Algorithm Analysis and Design', 'unit' => 9, 'ca' => '28.5 / 40', 'se' => '33.0 / 60', 'total' => 62, 'grade' => 'B+', 'point' => 36, 'remark' => 'PASS'],
                    ['code' => 'ITU 07407', 'name' => 'IT and Cyber Law', 'unit' => 9, 'ca' => '34.0 / 40', 'se' => '42.0 / 60', 'total' => 76, 'grade' => 'A', 'point' => 45, 'remark' => 'PASS'],
                    ['code' => 'ITU 07410', 'name' => 'Object-Oriented Programming', 'unit' => 12, 'ca' => '19.0 / 40', 'se' => '32.4 / 60', 'total' => 51, 'grade' => 'B', 'point' => 36, 'remark' => 'PASS'],
                    ['code' => 'ITU 07411', 'name' => 'Web Application Development', 'unit' => 9, 'ca' => '28.0 / 40', 'se' => '40.2 / 60', 'total' => 68, 'grade' => 'B+', 'point' => 36, 'remark' => 'PASS'],
                ],
            ],
            [
                'title' => 'FIRST YEAR - 2023/2024 - SEMESTER II',
                'gpa' => '3.1',
                'courses' => [
                    ['code' => 'GSU 07005', 'name' => 'Business Communication Skills', 'unit' => 9, 'ca' => '20.0 / 40', 'se' => '23.2 / 60', 'total' => 43, 'grade' => 'C', 'point' => 18, 'remark' => 'PASS'],
                    ['code' => 'ITU 07113', 'name' => 'Programming Principles', 'unit' => 15, 'ca' => '21.0 / 40', 'se' => '27.0 / 60', 'total' => 48, 'grade' => 'C', 'point' => 30, 'remark' => 'PASS'],
                    ['code' => 'ITU 07114', 'name' => 'Business Information Systems', 'unit' => 12, 'ca' => '24.0 / 40', 'se' => '32.0 / 60', 'total' => 56, 'grade' => 'B-', 'point' => 48, 'remark' => 'PASS'],
                    ['code' => 'ITU 07115', 'name' => 'Computer Design and Architecture', 'unit' => 12, 'ca' => '24.0 / 40', 'se' => '42.8 / 60', 'total' => 68, 'grade' => 'B+', 'point' => 48, 'remark' => 'PASS'],
                    ['code' => 'MTU 07102', 'name' => 'Introduction to Linear Algebra', 'unit' => 9, 'ca' => '23.8 / 40', 'se' => '41.4 / 60', 'total' => 65, 'grade' => 'B+', 'point' => 36, 'remark' => 'PASS'],
                ],
            ],
            [
                'title' => 'FIRST YEAR - 2023/2024 - SEMESTER I',
                'gpa' => '3.3',
                'courses' => [
                    ['code' => 'ITU 07207', 'name' => 'Fundamentals of Web Programming', 'unit' => 9, 'ca' => '26.2 / 40', 'se' => '25.8 / 60', 'total' => 52, 'grade' => 'B', 'point' => 27, 'remark' => 'PASS'],
                    ['code' => 'ITU 07209', 'name' => 'Database Concepts', 'unit' => 9, 'ca' => '26.1 / 40', 'se' => '36.0 / 60', 'total' => 62, 'grade' => 'B+', 'point' => 36, 'remark' => 'PASS'],
                    ['code' => 'ITU 07210', 'name' => 'Operating System Concepts', 'unit' => 9, 'ca' => '24.5 / 40', 'se' => '30.0 / 60', 'total' => 55, 'grade' => 'B', 'point' => 27, 'remark' => 'PASS'],
                    ['code' => 'ITU 07211', 'name' => 'Event-Driven Programming', 'unit' => 9, 'ca' => '27.8 / 40', 'se' => '31.8 / 60', 'total' => 60, 'grade' => 'B+', 'point' => 36, 'remark' => 'PASS'],
                    ['code' => 'MTU 07204', 'name' => 'Functions of a Single Variable', 'unit' => 12, 'ca' => '19.5 / 40', 'se' => '39.3 / 60', 'total' => 58, 'grade' => 'B', 'point' => 36, 'remark' => 'PASS'],
                ],
            ],
        ];
    }

    private function resultSummary(User $user): array
    {
        return [
            'Total GPA' => '3.37',
            'Overall Status' => 'PASS',
            'Total Units' => '84',
            'Points Earned' => '309',
            'Remarks' => 'Eligible for progression',
        ];
    }

    private function accommodationSummary(?User $user = null): array
    {
        $items = [
            [
                'item' => 'Hostel fee balance',
                'detail' => 'Outstanding hostel charge for 2025/2026.',
                'amount' => 'TZS 50,000.00',
                'status' => 'Pending',
            ],
            [
                'item' => 'Room key',
                'detail' => 'Return required to hostel office.',
                'amount' => '-',
                'status' => 'Pending',
            ],
        ];

        return [
            'hostel' => 'Block B - Room 214',
            'status' => count($items) > 0 ? 'Pending' : 'No Pending',
            'summary' => count($items) > 0
                ? 'Clear the listed hostel debts/items before final clearance can be completed.'
                : 'No accommodation debt or return item is pending.',
            'items' => $items,
        ];
    }

    private function librarySummary(?User $user = null): array
    {
        $books = [];

        return [
            'status' => count($books) > 0 ? 'Pending' : 'No Pending',
            'summary' => count($books) > 0
                ? 'Return the listed borrowed books before library clearance can be completed.'
                : 'No Pending',
            'books' => $books,
        ];
    }
}
