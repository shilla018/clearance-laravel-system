<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditTrailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Show all users
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Search by name, email, or registration number
        if ($search = $request->string('search')->trim()->toString()) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('full_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('registration_number', 'like', "%{$search}%");
        }

        // Filter by role
        if ($role = $request->string('role')->trim()->toString()) {
            $query->where('role', $role);
        }

        return view('admin.users.index', [
            'users' => $query->latest()->paginate(15)->withQueryString(),
            'roles' => ['student', 'officer', 'admin', 'clearance_admin'],
        ]);
    }

    /**
     * Show create user form
     */
    public function create(): View
    {
        return view('admin.users.create', [
            'roles' => ['student', 'officer', 'admin', 'clearance_admin'],
            'departments' => User::DEPARTMENTS ?? [],
        ]);
    }

    /**
     * Store new user
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'registration_number' => ['nullable', 'string', 'unique:users,registration_number'],
            'role' => ['required', 'in:student,officer,admin,clearance_admin,hgadmin'],
            'phone' => ['nullable', 'string', 'max:20'],
            'sex' => ['nullable', 'in:M,F'],
            'programme' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:50'],
            'campus' => ['nullable', 'string', 'max:100'],
            'academic_year' => ['nullable', 'string', 'max:50'],
            'department_key' => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now();
        $validated['password_expires_at'] = null;

        $user = User::create($validated);

        app(AuditTrailService::class)->log(
            action: 'user.created',
            subject: $user,
            description: "Admin created new user: {$user->email}",
            actor: $request->user(),
            request: $request,
        );

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    /**
     * Show edit user form
     */
    public function show(User $user): View
    {
        return view('admin.users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show edit user form
     */
    public function edit(Request $request, User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => ['student', 'officer', 'admin', 'clearance_admin'],
            'departments' => User::DEPARTMENTS ?? [],
        ]);
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', "unique:users,email,{$user->id}"],
            'registration_number' => ['nullable', 'string', "unique:users,registration_number,{$user->id}"],
            'role' => ['required', 'in:student,officer,admin,clearance_admin,hgadmin'],
            'phone' => ['nullable', 'string', 'max:20'],
            'sex' => ['nullable', 'in:M,F'],
            'programme' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:50'],
            'campus' => ['nullable', 'string', 'max:100'],
            'academic_year' => ['nullable', 'string', 'max:50'],
            'department_key' => ['nullable', 'string', 'max:50'],
        ]);

        $oldValues = $user->only(array_keys($validated));
        $user->update($validated);

        app(AuditTrailService::class)->log(
            action: 'user.updated',
            subject: $user,
            oldValues: $oldValues,
            newValues: $validated,
            description: "Admin updated user: {$user->email}",
            actor: $request->user(),
            request: $request,
        );

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    /**
     * Delete user
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Cannot delete your own account');
        }

        $email = $user->email;
        $user->delete();

        app(AuditTrailService::class)->log(
            action: 'user.deleted',
            subject: $user,
            description: "Admin deleted user: {$email}",
            actor: $request->user(),
            request: $request,
        );

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    /**
     * Bulk import students from CSV
     */
    public function importForm(): View
    {
        return view('admin.users.import');
    }

    /**
     * Handle CSV import
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $file = $request->file('csv_file');
        $path = $file->store('imports');
        $content = file_get_contents(storage_path('app/' . $path));
        $rows = array_map('str_getcsv', explode("\n", trim($content)));
        $headers = array_shift($rows);

        $imported = 0;
        $failed = 0;

        foreach ($rows as $row) {
            if (empty($row[0])) continue;

            try {
                $data = array_combine($headers, $row);

                User::updateOrCreate(
                    ['registration_number' => $data['registration_number'] ?? null],
                    [
                        'name' => $data['name'] ?? 'Student',
                        'full_name' => $data['full_name'] ?? $data['name'] ?? 'Student',
                        'email' => $data['email'] ?? '',
                        'role' => 'student',
                        'phone' => $data['phone'] ?? '255000000000',
                        'sex' => $data['sex'] ?? 'M',
                        'programme' => $data['programme'] ?? 'Bachelor Degree in Information Technology',
                        'department' => $data['department'] ?? 'Department of Computing and Communication Technology',
                        'level' => $data['level'] ?? 'NTA LEVEL : 8',
                        'campus' => $data['campus'] ?? 'Main Campus',
                        'academic_year' => $data['academic_year'] ?? '2025/2026 - Semester II',
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                        'password_expires_at' => null,
                    ]
                );

                $imported++;
            } catch (\Exception $e) {
                $failed++;
            }
        }

        @unlink(storage_path('app/' . $path));

        return back()->with('success', "Imported {$imported} users, {$failed} failed");
    }
}
