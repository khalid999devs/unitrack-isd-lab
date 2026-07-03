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

    public function test_login_page_does_not_render_role_shortcut_forms(): void
    {
        $this->withoutVite();

        $this->get('/login')
            ->assertOk()
            ->assertDontSee('value="student@unitrack.test"', false)
            ->assertDontSee('value="teacher@unitrack.test"', false)
            ->assertDontSee('value="admin@unitrack.test"', false);
    }

    public function test_demo_role_credentials_redirect_to_their_dashboards(): void
    {
        $accounts = [
            ['email' => 'student@unitrack.test', 'role' => 'student', 'dashboard' => 'student.dashboard'],
            ['email' => 'teacher@unitrack.test', 'role' => 'teacher', 'dashboard' => 'teacher.dashboard'],
            ['email' => 'admin@unitrack.test', 'role' => 'admin', 'dashboard' => 'admin.dashboard'],
        ];

        foreach ($accounts as $account) {
            User::factory()->create([
                'email' => $account['email'],
                'role' => $account['role'],
                'password' => 'password',
            ]);

            $this->post('/login', [
                'email' => $account['email'],
                'password' => 'password',
            ])->assertRedirect(route($account['dashboard']));

            $this->post('/logout')->assertRedirect(route('login'));
        }
    }

    // Invalid login returns error

    public function test_login_requires_valid_email_format(): void
    {
        $this->post('/login', [
            'email' => 'khalid01',
            'password' => 'password',
        ])->assertSessionHasErrors('email');
    }

    public function test_invalid_login_returns_auth_error(): void
    {
        User::factory()->create(['email' => 'student@unitrack.test']);

        $this->post('/login', [
            'email' => 'student@unitrack.test',
            'password' => 'wrongpassword',
        ])->assertSessionHasErrors('email');
    }

    public function test_login_with_unsupported_role_is_rejected(): void
    {
        User::factory()->create([
            'email' => 'unknown@unitrack.test',
            'password' => 'password',
            'role' => 'unknown',
        ]);

        $this->post('/login', [
            'email' => 'unknown@unitrack.test',
            'password' => 'password',
        ])->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
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

    public function test_dashboard_layouts_render_post_logout_forms(): void
    {
        $this->withoutVite();

        $routes = [
            'student' => '/student/dashboard',
            'teacher' => '/teacher/dashboard',
            'admin' => '/admin/dashboard',
        ];

        foreach ($routes as $role => $route) {
            $user = User::factory()->create(['role' => $role]);

            $this->actingAs($user)
                ->get($route)
                ->assertOk()
                ->assertSee('method="POST"', false)
                ->assertSee(route('logout'), false);

            $this->post('/logout')->assertRedirect(route('login'));
        }
    }
}
