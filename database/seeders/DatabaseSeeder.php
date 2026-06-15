<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Notice;
use App\Models\Routine;
use App\Models\Student;
use App\Models\StudyMaterial;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@unitrack.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $studentUser = User::create([
            'name' => 'Student User',
            'email' => 'student@unitrack.test',
            'password' => 'password',
            'role' => 'student',
        ]);

        $teacherUser = User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@unitrack.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);

        Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STU-2207035',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'batch' => '2022',
            'phone' => '01700000001',
            'address' => 'KUET Campus, Khulna',
        ]);

        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH-1001',
            'department' => 'Computer Science and Engineering',
            'designation' => 'Lecturer',
            'phone' => '01700000002',
        ]);

        $course = Course::create([
            'course_code' => 'CSE-3200',
            'course_title' => 'Information System Design Lab',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'credit' => 1.5,
            'teacher_id' => $teacher->id,
        ]);

        Routine::create([
            'course_id' => $course->id,
            'teacher_id' => $teacher->id,
            'semester' => '6th',
            'batch' => '2022',
            'day' => 'Sunday',
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'room' => 'CSE Lab 1',
        ]);

        Notice::create([
            'title' => 'Sprint 1 Database Setup',
            'description' => 'Initial UniTrack database schema has been prepared for local testing.',
            'posted_by' => $admin->id,
            'target_role' => 'all',
        ]);

        StudyMaterial::create([
            'course_id' => $course->id,
            'teacher_id' => $teacher->id,
            'title' => 'ISD Lab Starter Material',
            'description' => 'Sample study material entry for verifying the study material schema.',
            'file_path' => 'materials/isd-lab-starter.pdf',
        ]);

        Assignment::create([
            'course_id' => $course->id,
            'teacher_id' => $teacher->id,
            'title' => 'Prepare Database Schema Review',
            'description' => 'Review the initial tables, keys, and relationships for UniTrack.',
            'deadline' => now()->addWeek(),
        ]);
    }
}
