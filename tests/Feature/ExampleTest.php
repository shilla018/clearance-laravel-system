<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_starts_on_login_page(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_login_page_is_available_to_guests(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
    }

    public function test_authenticated_user_is_redirected_from_login_to_dashboard(): void
    {
        $user = new User([
            'full_name' => 'Test User',
            'email' => 'user@example.com',
        ]);

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect(route('dashboard.index'));
    }

    public function test_student_can_login_with_email_or_registration_number(): void
    {
        $user = User::factory()->create([
            'full_name' => 'Student User',
            'email' => 'student@example.com',
            'registration_number' => 'NIT/BIT/2023/9999',
            'role' => 'student',
            'password' => Hash::make('password'),
        ]);

        $this->post(route('login.submit'), [
            'login' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard.index'));

        auth()->logout();

        $this->post(route('login.submit'), [
            'login' => $user->registration_number,
            'password' => 'password',
        ])->assertRedirect(route('dashboard.index'));
    }
}
