<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clearance_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('reason', 120);
            $table->string('mobile_number', 40);
            $table->string('academic_year', 60);
            $table->string('status', 30)->default('pending')->index();
            $table->timestamp('applied_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('due_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('clearance_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clearance_application_id')->constrained()->cascadeOnDelete();
            $table->string('department_key', 60)->index();
            $table->string('department_name');
            $table->string('status', 30)->default('pending')->index();
            $table->text('comments')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->unique(['clearance_application_id', 'department_key'], 'clearance_review_department_unique');
        });

        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('subject');
            $table->text('message');
            $table->string('status', 30)->default('open')->index();
            $table->string('priority', 30)->default('normal');
            $table->text('admin_feedback')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('system_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('message');
            $table->string('type', 40)->default('info');
            $table->string('status', 20)->default('unread')->index();
            $table->string('action_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_notifications');
        Schema::dropIfExists('support_tickets');
        Schema::dropIfExists('clearance_reviews');
        Schema::dropIfExists('clearance_applications');
    }
};
