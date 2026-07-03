# SCRUM-9 Database Schema

## Jira Task ID

SCRUM-9

## Task Title

Design initial MySQL database schema and migrations

## Purpose

This setup creates the initial UniTrack database foundation for Sprint 2 and Sprint 3 module development. It defines the main tables, foreign keys, Eloquent model relationships, and local seed data needed to start building profiles, courses, routines, notices, study materials, assignments, and role-based dashboards.

## Tables Created

1. `users`
2. `students`
3. `teachers`
4. `courses`
5. `routines`
6. `notices`
7. `study_materials`
8. `assignments`

## Key Fields

### users

- `id`
- `name`
- `email`
- `password`
- `role`
- `created_at`
- `updated_at`

### students

- `id`
- `user_id`
- `student_id`
- `department`
- `semester`
- `batch`
- `phone`
- `address`
- `created_at`
- `updated_at`

### teachers

- `id`
- `user_id`
- `teacher_id`
- `department`
- `designation`
- `phone`
- `created_at`
- `updated_at`

### courses

- `id`
- `course_code`
- `course_title`
- `department`
- `semester`
- `credit`
- `teacher_id`
- `created_at`
- `updated_at`

### routines

- `id`
- `course_id`
- `teacher_id`
- `semester`
- `batch`
- `day`
- `start_time`
- `end_time`
- `room`
- `created_at`
- `updated_at`

### notices

- `id`
- `title`
- `description`
- `posted_by`
- `target_role`
- `created_at`
- `updated_at`

### study_materials

- `id`
- `course_id`
- `teacher_id`
- `title`
- `description`
- `file_path`
- `created_at`
- `updated_at`

### assignments

- `id`
- `course_id`
- `teacher_id`
- `title`
- `description`
- `deadline`
- `created_at`
- `updated_at`

## Main Relationships

- `User` has one `Student`.
- `User` has one `Teacher`.
- `User` has many `Notice` records through `posted_by`.
- `Student` belongs to `User`.
- `Teacher` belongs to `User`.
- `Teacher` has many `Course`, `Routine`, `StudyMaterial`, and `Assignment` records.
- `Course` belongs to `Teacher`.
- `Course` has many `Routine`, `StudyMaterial`, and `Assignment` records.
- `Routine` belongs to `Course` and `Teacher`.
- `Notice` belongs to `User` through `posted_by`.
- `StudyMaterial` belongs to `Course` and `Teacher`.
- `Assignment` belongs to `Course` and `Teacher`.

## Seeder Information

The database seeder adds local V1 demo data:

- One admin user
- Two student users with student profiles
- Two teacher users with teacher profiles
- Five sample courses
- Five sample routines
- Four sample notices
- Four sample study materials
- Four sample assignments

Demo accounts use the password:

```text
password
```

These credentials are only for local development and testing.

## Verification Commands

```bash
php artisan migrate:fresh
php artisan migrate:fresh --seed
php artisan test
```

## Local Database Verification

Make sure MySQL is running through MAMP, XAMPP, Laragon, or a direct MySQL installation, and confirm the local `.env` file points to the UniTrack database.

Default local database name:

```text
unitrack_db
```

Common XAMPP or direct MySQL values:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=unitrack_db
DB_USERNAME=root
DB_PASSWORD=
DB_SOCKET=
```

Common MAMP values:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=unitrack_db
DB_USERNAME=root
DB_PASSWORD=root
DB_SOCKET=/Applications/MAMP/tmp/mysql/mysql.sock
```

Then run:

```bash
php artisan migrate:fresh --seed
```

After seeding, verify the expected tables exist in MySQL:

```text
users
students
teachers
courses
routines
notices
study_materials
assignments
```

## Assumptions

1. The existing Laravel `users` migration is kept and already includes the required `role` column.
2. User role values are stored as simple strings: `student`, `teacher`, and `admin`.
3. `target_role` on notices is stored as a string and supports `student`, `teacher`, `admin`, and `all`.
4. Deleting a user deletes the related student or teacher profile.
5. Deleting a teacher sets `courses.teacher_id` to `null`, so courses can remain in the system.
6. Routines, study materials, and assignments are deleted when their related course or teacher is deleted.
7. `.env` remains local only and is not committed.
