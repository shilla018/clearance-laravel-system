<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clearance_applications', function (Blueprint $table) {
            // Add resubmission tracking
            $table->boolean('resubmission_allowed')->default(false)->after('metadata');
            $table->integer('resubmission_count')->default(0)->after('resubmission_allowed');
            $table->dateTime('resubmitted_at')->nullable()->after('resubmission_count');
            $table->text('denial_reason')->nullable()->after('resubmitted_at');
            $table->unsignedBigInteger('parent_application_id')->nullable()->after('denial_reason')->comment('For tracking resubmitted applications');

            // Add foreign key for parent application
            $table->foreign('parent_application_id')
                ->references('id')
                ->on('clearance_applications')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clearance_applications', function (Blueprint $table) {
            $table->dropForeignKey(['parent_application_id']);
            $table->dropColumn([
                'resubmission_allowed',
                'resubmission_count',
                'resubmitted_at',
                'denial_reason',
                'parent_application_id',
            ]);
        });
    }
};
