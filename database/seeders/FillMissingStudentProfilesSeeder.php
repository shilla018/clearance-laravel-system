<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FillMissingStudentProfilesSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'programme' => 'Bachelor Degree in Information Technology',
            'department' => 'Department of Computing and Communication Technology',
            'level' => 'NTA LEVEL : 8',
            'campus' => 'Main Campus',
            'academic_year' => '2025/2026 - Semester II',
            'password_expires_at' => null,
        ];

        User::where('role', 'student')->get()->each(function (User $student) use ($defaults): void {
            $updates = [];

            foreach ($defaults as $field => $value) {
                if (blank($student->{$field})) {
                    $updates[$field] = $value;
                }
            }

            if (blank($student->full_name)) {
                $updates['full_name'] = $student->name;
            }

            if (blank($student->phone)) {
                $updates['phone'] = '255000000000';
            }

            if (blank($student->sex)) {
                $updates['sex'] = 'M';
            }

            if ($updates !== []) {
                $student->forceFill($updates)->save();
            }
        });
    }
}
