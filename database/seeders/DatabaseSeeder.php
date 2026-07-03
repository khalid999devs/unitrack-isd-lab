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
        $admin = User::updateOrCreate(['email' => 'admin@unitrack.test'], [
            'name' => 'Ayesha Rahman',
            'password' => 'password',
            'role' => 'admin',
        ]);

        $studentUser = User::updateOrCreate(['email' => 'student@unitrack.test'], [
            'name' => 'Khalid Ahmed',
            'password' => 'password',
            'role' => 'student',
        ]);

        $secondStudentUser = User::updateOrCreate(['email' => 'student2@unitrack.test'], [
            'name' => 'Nusrat Jahan',
            'password' => 'password',
            'role' => 'student',
        ]);

        $teacherUser = User::updateOrCreate(['email' => 'teacher@unitrack.test'], [
            'name' => 'Dr. Farhana Rahman',
            'password' => 'password',
            'role' => 'teacher',
        ]);

        $secondTeacherUser = User::updateOrCreate(['email' => 'teacher2@unitrack.test'], [
            'name' => 'Hasan Mahmud',
            'password' => 'password',
            'role' => 'teacher',
        ]);

        Student::updateOrCreate(['student_id' => 'STU-2207035'], [
            'user_id' => $studentUser->id,
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'batch' => '2022',
            'phone' => '01700000001',
            'address' => 'KUET Campus, Khulna',
        ]);

        Student::updateOrCreate(['student_id' => 'STU-2207036'], [
            'user_id' => $secondStudentUser->id,
            'department' => 'Computer Science and Engineering',
            'semester' => '5th',
            'batch' => '2023',
            'phone' => '01700000003',
            'address' => 'Fulbarigate, Khulna',
        ]);

        $teacher = Teacher::updateOrCreate(['teacher_id' => 'TCH-1001'], [
            'user_id' => $teacherUser->id,
            'department' => 'Computer Science and Engineering',
            'designation' => 'Associate Professor',
            'phone' => '01700000002',
        ]);

        $secondTeacher = Teacher::updateOrCreate(['teacher_id' => 'TCH-1002'], [
            'user_id' => $secondTeacherUser->id,
            'department' => 'Computer Science and Engineering',
            'designation' => 'Lecturer',
            'phone' => '01700000004',
        ]);

        $isdLab = Course::updateOrCreate(['course_code' => 'CSE-3200'], [
            'course_title' => 'Information System Design Lab',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'credit' => 1.5,
            'teacher_id' => $teacher->id,
        ]);

        $databaseSystems = Course::updateOrCreate(['course_code' => 'CSE-3101'], [
            'course_title' => 'Database Systems',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'credit' => 3.0,
            'teacher_id' => $secondTeacher->id,
        ]);

        $softwareEngineering = Course::updateOrCreate(['course_code' => 'CSE-3102'], [
            'course_title' => 'Software Engineering',
            'department' => 'Computer Science and Engineering',
            'semester' => '6th',
            'credit' => 3.0,
            'teacher_id' => $teacher->id,
        ]);

        $dataStructures = Course::updateOrCreate(['course_code' => 'CSE-2201'], [
            'course_title' => 'Data Structures',
            'department' => 'Computer Science and Engineering',
            'semester' => '5th',
            'credit' => 3.0,
            'teacher_id' => $secondTeacher->id,
        ]);

        $webProgramming = Course::updateOrCreate(['course_code' => 'CSE-2202'], [
            'course_title' => 'Web Programming',
            'department' => 'Computer Science and Engineering',
            'semester' => '5th',
            'credit' => 3.0,
            'teacher_id' => $teacher->id,
        ]);

        $today = now()->format('l');

        $routines = [
            [
                'course' => $isdLab,
                'teacher' => $teacher,
                'semester' => '6th',
                'batch' => '2022',
                'day' => $today,
                'start_time' => '09:00:00',
                'end_time' => '11:00:00',
                'room' => 'CSE Lab 1',
            ],
            [
                'course' => $databaseSystems,
                'teacher' => $secondTeacher,
                'semester' => '6th',
                'batch' => '2022',
                'day' => 'Monday',
                'start_time' => '10:00:00',
                'end_time' => '11:30:00',
                'room' => 'Academic 204',
            ],
            [
                'course' => $softwareEngineering,
                'teacher' => $teacher,
                'semester' => '6th',
                'batch' => '2022',
                'day' => 'Wednesday',
                'start_time' => '12:00:00',
                'end_time' => '13:30:00',
                'room' => 'Academic 302',
            ],
            [
                'course' => $dataStructures,
                'teacher' => $secondTeacher,
                'semester' => '5th',
                'batch' => '2023',
                'day' => 'Tuesday',
                'start_time' => '09:00:00',
                'end_time' => '10:30:00',
                'room' => 'Academic 105',
            ],
            [
                'course' => $webProgramming,
                'teacher' => $teacher,
                'semester' => '5th',
                'batch' => '2023',
                'day' => 'Thursday',
                'start_time' => '14:00:00',
                'end_time' => '15:30:00',
                'room' => 'CSE Lab 2',
            ],
        ];

        foreach ($routines as $routine) {
            Routine::updateOrCreate([
                'course_id' => $routine['course']->id,
                'teacher_id' => $routine['teacher']->id,
                'day' => $routine['day'],
                'start_time' => $routine['start_time'],
            ], [
                'semester' => $routine['semester'],
                'batch' => $routine['batch'],
                'end_time' => $routine['end_time'],
                'room' => $routine['room'],
            ]);
        }

        $notices = [
            [
                'title' => 'Welcome to UniTrack V1 Demo',
                'description' => 'Use the demo accounts to review Student, Teacher, and Admin role flows.',
                'target_role' => 'all',
            ],
            [
                'title' => 'Student Routine Published',
                'description' => 'Student class routines are available from the dashboard routine shortcut.',
                'target_role' => 'student',
            ],
            [
                'title' => 'Teacher Content Reminder',
                'description' => 'Teachers can review assigned courses, routines, materials, and assignments.',
                'target_role' => 'teacher',
            ],
            [
                'title' => 'Admin Data Review',
                'description' => 'Admins can review seeded students, teachers, courses, and routines.',
                'target_role' => 'admin',
            ],
        ];

        foreach ($notices as $notice) {
            Notice::updateOrCreate([
                'title' => $notice['title'],
                'posted_by' => $admin->id,
            ], [
                'description' => $notice['description'],
                'target_role' => $notice['target_role'],
            ]);
        }

        $materials = [
            [
                'course' => $isdLab,
                'teacher' => $teacher,
                'title' => 'ISD Lab Starter Material',
                'description' => 'Project setup, role flow, and V1 demo checklist.',
                'file_path' => 'materials/isd-lab-starter.pdf',
            ],
            [
                'course' => $databaseSystems,
                'teacher' => $secondTeacher,
                'title' => 'Database Normalization Notes',
                'description' => 'Introductory normalization and schema design notes.',
                'file_path' => 'materials/database-normalization.pdf',
            ],
            [
                'course' => $softwareEngineering,
                'teacher' => $teacher,
                'title' => 'Software Engineering Sprint Guide',
                'description' => 'Short guide for Agile sprint planning and review.',
                'file_path' => 'materials/software-engineering-sprint-guide.pdf',
            ],
            [
                'course' => $webProgramming,
                'teacher' => $teacher,
                'title' => 'Blade and Tailwind UI Notes',
                'description' => 'Starter notes for Blade templates and Tailwind components.',
                'file_path' => 'materials/blade-tailwind-ui-notes.pdf',
            ],
        ];

        foreach ($materials as $material) {
            StudyMaterial::updateOrCreate([
                'course_id' => $material['course']->id,
                'title' => $material['title'],
            ], [
                'teacher_id' => $material['teacher']->id,
                'description' => $material['description'],
                'file_path' => $material['file_path'],
            ]);
        }

        $assignments = [
            [
                'course' => $isdLab,
                'teacher' => $teacher,
                'title' => 'Review Role Dashboard Flow',
                'description' => 'Verify Student, Teacher, and Admin routes using the seeded demo accounts.',
                'deadline' => now()->addDays(5),
            ],
            [
                'course' => $databaseSystems,
                'teacher' => $secondTeacher,
                'title' => 'Prepare ER Diagram Notes',
                'description' => 'Create a short ER diagram summary for the UniTrack course module.',
                'deadline' => now()->addWeek(),
            ],
            [
                'course' => $softwareEngineering,
                'teacher' => $teacher,
                'title' => 'Write Sprint Review Summary',
                'description' => 'Summarize completed work and blockers for the current sprint review.',
                'deadline' => now()->addDays(10),
            ],
            [
                'course' => $dataStructures,
                'teacher' => $secondTeacher,
                'title' => 'Practice Stack and Queue Problems',
                'description' => 'Solve starter stack and queue exercises before the next class.',
                'deadline' => now()->addDays(8),
            ],
        ];

        foreach ($assignments as $assignment) {
            Assignment::updateOrCreate([
                'course_id' => $assignment['course']->id,
                'title' => $assignment['title'],
            ], [
                'teacher_id' => $assignment['teacher']->id,
                'description' => $assignment['description'],
                'deadline' => $assignment['deadline'],
            ]);
        }
    }
}
