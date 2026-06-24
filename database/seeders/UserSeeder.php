<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@clearance.test'],
            [
                'name' => 'Clearance Admin',
                'full_name' => 'Clearance Administrator',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'dev@clearance.test'],
            [
                'name' => 'Hagai Dev',
                'full_name' => 'Lead Developer',
                'role' => 'clearance_admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $officers = [
            ['email' => 'finance@clearance.test', 'name' => 'Finance Officer', 'department_key' => 'finance', 'department' => 'Finance Office'],
            ['email' => 'library@clearance.test', 'name' => 'Library Officer', 'department_key' => 'library', 'department' => 'Library'],
            ['email' => 'academic@clearance.test', 'name' => 'Academic Officer', 'department_key' => 'academic', 'department' => 'Academic Department'],
            ['email' => 'accommodation@clearance.test', 'name' => 'Accommodation Officer', 'department_key' => 'accommodation', 'department' => 'Accommodation'],
        ];

        foreach ($officers as $officer) {
            User::updateOrCreate(
                ['email' => $officer['email']],
                [
                    'name' => $officer['name'],
                    'full_name' => $officer['name'],
                    'role' => 'officer',
                    'department_key' => $officer['department_key'],
                    'department' => $officer['department'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
        }

        User::updateOrCreate(
            ['registration_number' => 'NIT/BIT/2023/2119'],
            [
                'name' => 'Godwin Ernest Shilla',
                'full_name' => 'Godwin Ernest Shilla',
                'email' => 'shillagodwin01@gmail.com',
                'role' => 'student',
                'phone' => '255693598348',
                'sex' => 'M',
                'programme' => 'Bachelor Degree in Information Technology',
                'department' => 'Department of Computing and Communication Technology',
                'level' => 'NTA LEVEL : 8',
                'campus' => 'Main Campus',
                'academic_year' => '2025/2026 - Semester II',
                'password_expires_at' => null,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $students = [
            [
                'registration_number' => 'NIT/BIT/2023/2101',
                'name' => 'Asha Hamisi Mrope',
                'email' => 'asha.mrope@example.test',
                'phone' => '255742100101',
                'sex' => 'F',
                'programme' => 'Bachelor Degree in Information Technology',
                'department' => 'Department of Computing and Communication Technology',
                'level' => 'NTA LEVEL : 8',
                'campus' => 'Main Campus',
                'academic_year' => '2025/2026 - Semester II',
            ],
            [
                'registration_number' => 'NIT/BIT/2023/2102',
                'name' => 'Baraka Joseph Mrema',
                'email' => 'baraka.mrema@example.test',
                'phone' => '255742100102',
                'sex' => 'M',
                'programme' => 'Bachelor Degree in Information Technology',
                'department' => 'Department of Computing and Communication Technology',
                'level' => 'NTA LEVEL : 8',
                'campus' => 'Main Campus',
                'academic_year' => '2025/2026 - Semester II',
            ],
            [
                'registration_number' => 'NIT/BIT/2023/2103',
                'name' => 'Neema Ally Sanga',
                'email' => 'neema.sanga@example.test',
                'phone' => '255742100103',
                'sex' => 'F',
                'programme' => 'Bachelor Degree in Information Technology',
                'department' => 'Department of Computing and Communication Technology',
                'level' => 'NTA LEVEL : 8',
                'campus' => 'Main Campus',
                'academic_year' => '2025/2026 - Semester II',
            ],
            [
                'registration_number' => 'NIT/BIT/2023/2104',
                'name' => 'Kelvin Peter Masalu',
                'email' => 'kelvin.masalu@example.test',
                'phone' => '255742100104',
                'sex' => 'M',
                'programme' => 'Bachelor Degree in Information Technology',
                'department' => 'Department of Computing and Communication Technology',
                'level' => 'NTA LEVEL : 8',
                'campus' => 'Main Campus',
                'academic_year' => '2025/2026 - Semester II',
            ],
            [
                'registration_number' => 'NIT/BIT/2023/2105',
                'name' => 'Rehema Rashid Komba',
                'email' => 'rehema.komba@example.test',
                'phone' => '255742100105',
                'sex' => 'F',
                'programme' => 'Bachelor Degree in Information Technology',
                'department' => 'Department of Computing and Communication Technology',
                'level' => 'NTA LEVEL : 8',
                'campus' => 'Main Campus',
                'academic_year' => '2025/2026 - Semester II',
            ],
        ];

        foreach ($students as $student) {
            User::updateOrCreate(
                ['registration_number' => $student['registration_number']],
                [
                    'name' => $student['name'],
                    'full_name' => $student['name'],
                    'email' => $student['email'],
                    'role' => 'student',
                    'phone' => $student['phone'],
                    'sex' => $student['sex'],
                        'programme' => $student['programme'],
                        'department' => $student['department'],
                        'level' => $student['level'],
                        'campus' => $student['campus'],
                        'academic_year' => $student['academic_year'],
                    'password_expires_at' => null,
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
        }

        User::whereNull('password')
            ->orWhere('password', '')
            ->get()
            ->each(function (User $user): void {
                $user->forceFill([
                    'password' => Hash::make('password'),
                    'password_expires_at' => null,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ])->save();
            });
    }
}
