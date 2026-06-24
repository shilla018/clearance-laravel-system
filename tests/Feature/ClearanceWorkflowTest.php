<?php

namespace Tests\Feature;

use App\Models\ClearanceApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ClearanceWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_officer_decision_updates_department_review_and_keeps_application_pending_until_all_approve(): void
    {
        Mail::fake();

        $student = User::factory()->create(['role' => 'student']);
        $officer = User::factory()->create([
            'role' => 'officer',
            'department_key' => 'finance',
            'department' => 'Finance Office',
        ]);

        $application = ClearanceApplication::create([
            'user_id' => $student->id,
            'reason' => 'Graduation',
            'mobile_number' => '255700000000',
            'academic_year' => '2025/2026',
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        $review = $application->reviews()->where('department_key', 'finance')->firstOrFail();

        $this->actingAs($officer)
            ->get(route('dashboard.applications.show', $application))
            ->assertOk()
            ->assertSee('type="submit" name="status" value="approved"', false)
            ->assertSee('type="submit" name="status" value="denied"', false)
            ->assertSee('data-no-spinner', false);

        $this->actingAs($officer)
            ->post(route('dashboard.applications.review', [$application, $review]), [
                'status' => 'approved',
                'comments' => 'Finance cleared.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('clearance_reviews', [
            'id' => $review->id,
            'status' => 'approved',
            'comments' => 'Finance cleared.',
            'reviewed_by' => $officer->id,
        ]);

        $this->assertDatabaseHas('clearance_applications', [
            'id' => $application->id,
            'status' => 'pending',
        ]);

        $this->actingAs($student)
            ->get(route('dashboard.clearance.index'))
            ->assertOk()
            ->assertSee('Finance Office')
            ->assertSee('Approved')
            ->assertSee('Finance cleared.')
            ->assertSee('25% Complete');
    }

    public function test_declined_department_review_is_visible_on_student_clearance_progress(): void
    {
        Mail::fake();

        $student = User::factory()->create(['role' => 'student']);
        $officer = User::factory()->create([
            'role' => 'officer',
            'department_key' => 'library',
            'department' => 'Library',
        ]);

        $application = ClearanceApplication::create([
            'user_id' => $student->id,
            'reason' => 'Graduation',
            'mobile_number' => '255700000000',
            'academic_year' => '2025/2026',
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        $review = $application->reviews()->where('department_key', 'library')->firstOrFail();

        $this->actingAs($officer)
            ->post(route('dashboard.applications.review', [$application, $review]), [
                'status' => 'denied',
                'comments' => 'Return borrowed books first.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('clearance_reviews', [
            'id' => $review->id,
            'status' => 'denied',
            'comments' => 'Return borrowed books first.',
            'reviewed_by' => $officer->id,
        ]);

        $this->assertDatabaseHas('clearance_applications', [
            'id' => $application->id,
            'status' => 'denied',
            'denial_reason' => 'Return borrowed books first.',
        ]);

        $this->actingAs($student)
            ->get(route('dashboard.clearance.index'))
            ->assertOk()
            ->assertSee('Clearance Status: Declined')
            ->assertSee('Library declined your clearance.')
            ->assertSee('Library')
            ->assertSee('Declined')
            ->assertSee('Return borrowed books first.')
            ->assertSee('0% Complete');
    }

    public function test_application_is_approved_after_every_department_approves(): void
    {
        Mail::fake();

        $student = User::factory()->create(['role' => 'student']);
        $application = ClearanceApplication::create([
            'user_id' => $student->id,
            'reason' => 'Graduation',
            'mobile_number' => '255700000000',
            'academic_year' => '2025/2026',
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        $application->reviews()->update(['status' => 'approved']);
        $application->refreshStatusFromReviews();

        $this->assertSame('approved', $application->fresh()->status);
    }

    public function test_officer_cannot_view_application_without_matching_department_review(): void
    {
        Mail::fake();

        $student = User::factory()->create(['role' => 'student']);
        $officer = User::factory()->create([
            'role' => 'officer',
            'department_key' => 'sports',
        ]);

        $application = ClearanceApplication::create([
            'user_id' => $student->id,
            'reason' => 'Graduation',
            'mobile_number' => '255700000000',
            'academic_year' => '2025/2026',
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        $this->actingAs($officer)
            ->get(route('dashboard.applications.show', $application))
            ->assertForbidden();
    }
}
