<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StarterPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_starter_pages_load_successfully(): void
    {
        $this->withoutVite();

        $this->get('/login')->assertOk();
        $this->actingAs($this->userWithRole('student'))->get('/student/dashboard')->assertOk();
        $this->actingAs($this->userWithRole('teacher'))->get('/teacher/dashboard')->assertOk();
        $this->actingAs($this->userWithRole('admin'))->get('/admin/dashboard')->assertOk();
    }

    public function test_dashboard_routes_require_authentication(): void
    {
        $this->get('/student/dashboard')->assertRedirect('/login');
        $this->get('/teacher/dashboard')->assertRedirect('/login');
        $this->get('/admin/dashboard')->assertRedirect('/login');
    }

    public function test_dashboard_routes_reject_users_with_the_wrong_role(): void
    {
        $this->actingAs($this->userWithRole('student'))->get('/teacher/dashboard')->assertForbidden();
        $this->actingAs($this->userWithRole('teacher'))->get('/admin/dashboard')->assertForbidden();
        $this->actingAs($this->userWithRole('admin'))->get('/student/dashboard')->assertForbidden();
    }

    private function userWithRole(string $role): User
    {
        return new User([
            'name' => ucfirst($role).' User',
            'email' => $role.'@unitrack.test',
            'role' => $role,
        ]);
    }
}
