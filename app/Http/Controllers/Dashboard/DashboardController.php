<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(): View
    {
        $student = $this->studentProfile();
        $payments = $this->paymentYears();
        $resultSemesters = $this->resultSemesters();
        $clearance = $this->clearanceProfile();

        $stats = [
            [
                'label' => 'Registration Status',
                'value' => 'Registered',
                'icon' => 'bi-person-check',
                'tone' => 'blue',
            ],
            [
                'label' => 'Paid Amount',
                'value' => 'TZS 2.71M',
                'icon' => 'bi-credit-card',
                'tone' => 'slate',
            ],
            [
                'label' => 'Pending Balance',
                'value' => 'TZS 300K',
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
                'value' => 'Eligible with Balance',
                'icon' => 'bi-clipboard-check',
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
            'student' => $this->studentProfile(),
            'paymentYears' => $this->paymentYears(),
        ]);
    }

    public function results(): View
    {
        return view('dashboard.results', [
            'student' => $this->studentProfile(),
            'resultSemesters' => $this->resultSemesters(),
            'summary' => [
                'Total Units' => 138,
                'Total Points' => 450,
                'Annual GPA' => '3.2',
                'Annual Remark' => 'PASS',
            ],
        ]);
    }

    public function clearance(): View
    {
        return view('dashboard.clearance', [
            'student' => $this->studentProfile(),
            'clearance' => $this->clearanceProfile(),
        ]);
    }

    public function submitClearance(Request $request): RedirectResponse
    {
        $request->validate([
            'reason' => ['required', 'string', 'max:120'],
            'mobile_number' => ['required', 'string', 'max:30'],
            'academic_year' => ['required', 'string', 'max:40'],
        ]);

        return back()->with('success', 'Clearance request submitted successfully.');
    }

    private function studentProfile(): array
    {
        $user = auth()->user();

        return [
            'name' => $user?->full_name ?? $user?->name ?? 'Godwin Ernest Shilla',
            'registration_no' => 'NIT/BIT/2023/2119',
            'email' => $user?->email ?? 'shillagodwin01@gmail.com',
            'phone' => '255693598348',
            'sex' => 'M',
            'programme' => 'Bachelor Degree in Information Technology',
            'department' => 'Department of Computing and Communication Technology',
            'level' => 'NTA LEVEL : 8',
            'campus' => 'Main Campus',
            'academic_year' => '2025/2026 - Semester II',
            'password_expiry' => '13-09-2026',
        ];
    }

    private function clearanceProfile(): array
    {
        return [
            'status' => 'Blocked',
            'message' => 'Access denied. You are not allowed to apply for Clearance until pending payment is settled.',
            'pending_payment' => 'TZS 300,000.00',
            'progress' => [
                ['office' => 'Finance Office', 'status' => 'Pending', 'note' => 'Outstanding tuition balance'],
                ['office' => 'Library', 'status' => 'Ready', 'note' => 'No borrowed books'],
                ['office' => 'Department', 'status' => 'Ready', 'note' => 'Project records verified'],
                ['office' => 'Accommodation', 'status' => 'Ready', 'note' => 'No hostel balance'],
            ],
        ];
    }

    private function paymentYears(): array
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

    private function resultSemesters(): array
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
}
