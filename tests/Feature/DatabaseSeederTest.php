<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Notice;
use App\Models\Routine;
use App\Models\Student;
use App\Models\StudyMaterial;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_v1_demo_seed_data_is_available(): void
    {
        $this->seed();
        $this->seed();

        $this->assertSame(1, User::where('role', 'admin')->count());
        $this->assertSame(2, Student::count());
        $this->assertSame(2, Teacher::count());
        $this->assertSame(5, Course::count());
        $this->assertSame(5, Routine::count());
        $this->assertSame(4, Notice::count());
        $this->assertSame(4, StudyMaterial::count());
        $this->assertSame(4, Assignment::count());

        $this->assertDatabaseHas('users', [
            'email' => 'admin@unitrack.test',
            'role' => 'admin',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'student@unitrack.test',
            'role' => 'student',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'student2@unitrack.test',
            'role' => 'student',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'teacher@unitrack.test',
            'role' => 'teacher',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'teacher2@unitrack.test',
            'role' => 'teacher',
        ]);
    }

    public function test_primary_demo_accounts_can_login_and_reach_role_dashboards(): void
    {
        $this->seed();

        $accounts = [
            ['email' => 'student@unitrack.test', 'dashboard' => 'student.dashboard'],
            ['email' => 'teacher@unitrack.test', 'dashboard' => 'teacher.dashboard'],
            ['email' => 'admin@unitrack.test', 'dashboard' => 'admin.dashboard'],
        ];

        foreach ($accounts as $account) {
            $this->post(route('login.store'), [
                'email' => $account['email'],
                'password' => 'password',
            ])->assertRedirect(route($account['dashboard']));

            $this->get(route($account['dashboard']))->assertOk();

            $this->post(route('logout'))->assertRedirect(route('login'));
        }
    }

    public function test_seeded_student_and_teacher_flows_show_demo_course_data(): void
    {
        $this->seed();

        $studentUser = User::where('email', 'student@unitrack.test')->firstOrFail();
        $teacherUser = User::where('email', 'teacher@unitrack.test')->firstOrFail();

        $this->actingAs($studentUser)
            ->get(route('student.courses'))
            ->assertOk()
            ->assertSee('CSE-3200')
            ->assertSee('Information System Design Lab')
            ->assertSee('CSE-3101')
            ->assertDontSee('CSE-2201');

        $this->actingAs($teacherUser)
            ->get(route('teacher.routine'))
            ->assertOk()
            ->assertSee('CSE-3200')
            ->assertSee('CSE-3102');
    }
}
