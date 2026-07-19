<?php

namespace Tests\Feature;

use App\Models\RegistrationRequest;
use App\Models\Student;
use App\Models\Teacher;
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
            ->assertSee('id="toggle-password"', false)
            ->assertDontSee('Demo Accounts')
            ->assertDontSee('value="student@unitrack.test"', false)
            ->assertDontSee('value="teacher@unitrack.test"', false)
            ->assertDontSee('value="admin@unitrack.test"', false);
    }

    public function test_registration_page_renders_student_and_teacher_request_form(): void
    {
        $this->withoutVite();

        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Create your account request')
            ->assertSee('Student ID')
            ->assertSee('Teacher ID')
            ->assertSee('data-password-toggle="password"', false);
    }

    public function test_student_registration_requires_admin_approval_before_login(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->post(route('register.store'), [
            'role' => 'student',
            'name' => 'Nadia Rahman',
            'email' => 'nadia@unitrack.test',
            'password' => 'password',
            'password_confirmation' => 'password',
            'student_id' => 'STU-777',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'batch' => '2022',
            'phone' => '01710000000',
            'address' => 'KUET Hall',
        ])->assertRedirect(route('login'));

        $this->assertDatabaseHas('registration_requests', [
            'email' => 'nadia@unitrack.test',
            'role' => 'student',
            'status' => 'pending',
        ]);
        $this->assertDatabaseMissing('users', ['email' => 'nadia@unitrack.test']);

        $this->post(route('login.store'), [
            'email' => 'nadia@unitrack.test',
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $registrationRequest = RegistrationRequest::where('email', 'nadia@unitrack.test')->firstOrFail();

        $this->actingAs($admin)
            ->post(route('admin.registration-requests.approve', $registrationRequest))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', ['email' => 'nadia@unitrack.test', 'role' => 'student']);
        $this->assertDatabaseHas('students', ['student_id' => 'STU-777']);
        $this->assertSame('approved', $registrationRequest->refresh()->status);
        $this->assertNull($registrationRequest->password);

        $this->post(route('logout'));

        $this->post(route('login.store'), [
            'email' => 'nadia@unitrack.test',
            'password' => 'password',
        ])->assertRedirect(route('student.dashboard'));
    }

    public function test_teacher_registration_approval_creates_teacher_profile(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->post(route('register.store'), [
            'role' => 'teacher',
            'name' => 'Dr. Samiul Karim',
            'email' => 'samiul@unitrack.test',
            'password' => 'password',
            'password_confirmation' => 'password',
            'teacher_id' => 'TCH-777',
            'department' => 'Computer Science and Engineering',
            'designation' => 'Lecturer',
            'phone' => '01720000000',
        ])->assertRedirect(route('login'));

        $registrationRequest = RegistrationRequest::where('email', 'samiul@unitrack.test')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.registration-requests'))
            ->assertOk()
            ->assertSee('Dr. Samiul Karim')
            ->assertSee('Approve');

        $this->actingAs($admin)
            ->post(route('admin.registration-requests.approve', $registrationRequest))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', ['email' => 'samiul@unitrack.test', 'role' => 'teacher']);
        $this->assertDatabaseHas('teachers', ['teacher_id' => 'TCH-777', 'designation' => 'Lecturer']);
        $this->assertSame(1, Teacher::where('teacher_id', 'TCH-777')->count());
    }

    public function test_admin_can_reject_registration_without_creating_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        RegistrationRequest::create([
            'role' => 'student',
            'name' => 'Rejected Student',
            'email' => 'rejected@unitrack.test',
            'password' => 'password',
            'student_id' => 'STU-778',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'batch' => '2022',
            'status' => 'pending',
        ]);

        $registrationRequest = RegistrationRequest::where('email', 'rejected@unitrack.test')->firstOrFail();

        $this->actingAs($admin)
            ->post(route('admin.registration-requests.reject', $registrationRequest), [
                'rejection_reason' => 'Missing academic verification.',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('registration_requests', [
            'email' => 'rejected@unitrack.test',
            'status' => 'rejected',
            'rejection_reason' => 'Missing academic verification.',
        ]);
        $this->assertDatabaseMissing('users', ['email' => 'rejected@unitrack.test']);
        $this->assertSame(0, Student::where('student_id', 'STU-778')->count());
        $this->assertNull($registrationRequest->refresh()->password);
    }

    public function test_email_addresses_are_normalized_for_registration_and_login(): void
    {
        $this->post(route('register.store'), [
            'role' => 'student',
            'name' => 'Normalized Student',
            'email' => '  NORMALIZED@UNITRACK.TEST ',
            'password' => 'password',
            'password_confirmation' => 'password',
            'student_id' => 'STU-NORMALIZED',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'batch' => '2022',
        ])->assertRedirect(route('login'));

        $this->assertDatabaseHas('registration_requests', [
            'email' => 'normalized@unitrack.test',
        ]);

        User::factory()->create([
            'email' => 'case@unitrack.test',
            'password' => 'password',
            'role' => 'student',
        ]);

        $this->post(route('login.store'), [
            'email' => ' CASE@UNITRACK.TEST ',
            'password' => 'password',
        ])->assertRedirect(route('student.dashboard'));
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

    public function test_repeated_login_failures_are_rate_limited(): void
    {
        User::factory()->create(['email' => 'limited@unitrack.test']);

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('login.store'), [
                'email' => 'limited@unitrack.test',
                'password' => 'wrongpassword',
            ])->assertSessionHasErrors('email');
        }

        $this->withoutVite();
        $this->post(route('login.store'), [
            'email' => 'limited@unitrack.test',
            'password' => 'wrongpassword',
        ])->assertTooManyRequests()
            ->assertSee('Too many requests');
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
