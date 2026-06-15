<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    // Authenticated users visiting /login redirect to correct dashboard

    public function test_authenticated_student_visiting_login_redirects_to_student_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'student']);

        $this->actingAs($user)
            ->get('/login')
            ->assertRedirect(route('student.dashboard'));
    }

    public function test_authenticated_teacher_visiting_login_redirects_to_teacher_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'teacher']);

        $this->actingAs($user)
            ->get('/login')
            ->assertRedirect(route('teacher.dashboard'));
    }

    public function test_authenticated_admin_visiting_login_redirects_to_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)
            ->get('/login')
            ->assertRedirect(route('admin.dashboard'));
    }

    // Successful login redirects by role

    public function test_student_login_redirects_to_student_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'student',
            'password' => 'password',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('student.dashboard'));
    }

    public function test_teacher_login_redirects_to_teacher_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'teacher',
            'password' => 'password',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('teacher.dashboard'));
    }

    public function test_admin_login_redirects_to_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
            'password' => 'password',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));
    }

    // Invalid login returns error

    public function test_invalid_login_returns_auth_error(): void
    {
        User::factory()->create(['email' => 'student@unitrack.test']);

        $this->post('/login', [
            'email' => 'student@unitrack.test',
            'password' => 'wrongpassword',
        ])->assertSessionHasErrors('email');
    }

    // Logout invalidates session and redirects to login

    public function test_logout_invalidates_session_and_redirects_to_login(): void
    {
        $user = User::factory()->create(['role' => 'student']);

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
