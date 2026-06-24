<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('registration_number')->nullable()->unique()->after('email');
            $table->string('role', 30)->default('student')->index()->after('registration_number');
            $table->string('phone', 40)->nullable()->after('role');
            $table->string('sex', 10)->nullable()->after('phone');
            $table->string('programme')->nullable()->after('sex');
            $table->string('department')->nullable()->after('programme');
            $table->string('level')->nullable()->after('department');
            $table->string('campus')->nullable()->after('level');
            $table->string('academic_year', 60)->nullable()->after('campus');
            $table->string('department_key', 60)->nullable()->index()->after('academic_year');
            $table->timestamp('password_expires_at')->nullable()->after('last_login_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['registration_number']);
            $table->dropIndex(['role']);
            $table->dropIndex(['department_key']);
            $table->dropColumn([
                'registration_number',
                'role',
                'phone',
                'sex',
                'programme',
                'department',
                'level',
                'campus',
                'academic_year',
                'department_key',
                'password_expires_at',
            ]);
        });
    }
};
