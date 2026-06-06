# Design and Technical Requirements - UniTrack ISD Lab

## Purpose of This Document

This document defines the design and technical requirements for the UniTrack system. It explains the technical architecture, Laravel project structure, database planning, route design, role-based access design, validation rules, testing requirements, and deployment requirements.

This document will help the development team build the system consistently and will provide enough technical context for team members, Copilot/code generation tools, Jira tasks, testing, and final presentation.

## Technical Stack

| Area                     | Technology                               |
| ------------------------ | ---------------------------------------- |
| Backend Framework        | Laravel                                  |
| Frontend Template Engine | Laravel Blade                            |
| Styling                  | Tailwind CSS                             |
| Database                 | MySQL                                    |
| Version Control          | Git and GitHub                           |
| Project Management       | Jira                                     |
| Development Methodology  | Agile Scrum                              |
| Local Server             | Laravel Artisan Server / XAMPP / Laragon |
| Package Manager          | Composer and npm                         |

## Technical Goal

The system should be simple, maintainable, secure, and easy to deploy. The development should follow Laravel conventions so that all team members can understand and extend the project easily.

## System Architecture

UniTrack will follow a standard Laravel MVC architecture.

### MVC Structure

1. Model - Handles database tables and relationships.
2. View - Handles Blade UI pages.
3. Controller - Handles request processing, validation, and business logic.

### Basic Request Flow

1. User opens a page.
2. Laravel route receives the request.
3. Controller handles the request.
4. Controller communicates with Model if database data is needed.
5. Controller returns a Blade view.
6. Blade view displays the final page to the user.

## Main Laravel Components

### Controllers

Suggested controllers:

1. AuthController
2. DashboardController
3. StudentController
4. TeacherController
5. CourseController
6. RoutineController
7. NoticeController
8. StudyMaterialController
9. AssignmentController

### Models

Suggested models:

1. User
2. Student
3. Teacher
4. Course
5. Routine
6. Notice
7. StudyMaterial
8. Assignment

### Middleware

Required middleware:

1. auth
2. role-based middleware

Role middleware should restrict pages based on user role.

Examples:

1. Student routes can be accessed only by students.
2. Teacher routes can be accessed only by teachers.
3. Admin routes can be accessed only by admins.

## Folder Structure Guideline

Suggested Laravel structure:

```text
app/
  Http/
    Controllers/
      AuthController.php
      DashboardController.php
      StudentController.php
      TeacherController.php
      CourseController.php
      RoutineController.php
      NoticeController.php
      StudyMaterialController.php
      AssignmentController.php
    Middleware/
      RoleMiddleware.php
  Models/
    User.php
    Student.php
    Teacher.php
    Course.php
    Routine.php
    Notice.php
    StudyMaterial.php
    Assignment.php

resources/
  views/
    layouts/
      app.blade.php
      auth.blade.php
    auth/
      login.blade.php
    student/
      dashboard.blade.php
      profile.blade.php
      courses.blade.php
      routine.blade.php
      notices.blade.php
      materials.blade.php
      assignments.blade.php
    teacher/
      dashboard.blade.php
      profile.blade.php
      courses.blade.php
      routine.blade.php
      materials.blade.php
      assignments.blade.php
      notices.blade.php
    admin/
      dashboard.blade.php
      students/
      teachers/
      courses/
      routines/
      notices/
      materials/
      assignments/
    components/
      sidebar.blade.php
      navbar.blade.php
      alert.blade.php
      table.blade.php
      form-input.blade.php
      button.blade.php
```

## Database Design Requirements

## Main Tables

### users

Purpose:

Store login and role information.

Suggested fields:

1. id
2. name
3. email
4. password
5. role
6. created_at
7. updated_at

Role values:

1. student
2. teacher
3. admin

### students

Purpose:

Store student profile information.

Suggested fields:

1. id
2. user_id
3. student_id
4. department
5. semester
6. batch
7. phone
8. address
9. created_at
10. updated_at

Relationship:

1. One user has one student profile.
2. Student belongs to user.

### teachers

Purpose:

Store teacher profile information.

Suggested fields:

1. id
2. user_id
3. teacher_id
4. department
5. designation
6. phone
7. created_at
8. updated_at

Relationship:

1. One user has one teacher profile.
2. Teacher belongs to user.

### courses

Purpose:

Store course information.

Suggested fields:

1. id
2. course_code
3. course_title
4. department
5. semester
6. credit
7. teacher_id
8. created_at
9. updated_at

Relationship:

1. Course belongs to teacher.
2. Teacher can have many courses.

### routines

Purpose:

Store class routine information.

Suggested fields:

1. id
2. course_id
3. teacher_id
4. semester
5. batch
6. day
7. start_time
8. end_time
9. room
10. created_at
11. updated_at

Relationship:

1. Routine belongs to course.
2. Routine belongs to teacher.

### notices

Purpose:

Store notice information.

Suggested fields:

1. id
2. title
3. description
4. posted_by
5. target_role
6. created_at
7. updated_at

Relationship:

1. Notice belongs to user through posted_by.
2. Notice can target student, teacher, admin, or all.

### study_materials

Purpose:

Store uploaded study materials.

Suggested fields:

1. id
2. course_id
3. teacher_id
4. title
5. description
6. file_path
7. created_at
8. updated_at

Relationship:

1. Study material belongs to course.
2. Study material belongs to teacher.

### assignments

Purpose:

Store assignment or academic task information.

Suggested fields:

1. id
2. course_id
3. teacher_id
4. title
5. description
6. deadline
7. created_at
8. updated_at

Relationship:

1. Assignment belongs to course.
2. Assignment belongs to teacher.

## Route Design Requirements

## Public Routes

```text
GET /login
POST /login
POST /logout
```

## Student Routes

```text
GET /student/dashboard
GET /student/profile
POST /student/profile/update
GET /student/courses
GET /student/routine
GET /student/notices
GET /student/materials
GET /student/assignments
```

## Teacher Routes

```text
GET /teacher/dashboard
GET /teacher/profile
POST /teacher/profile/update
GET /teacher/courses
GET /teacher/routine
GET /teacher/materials
POST /teacher/materials/store
GET /teacher/materials/{id}/edit
POST /teacher/materials/{id}/update
POST /teacher/materials/{id}/delete
GET /teacher/assignments
POST /teacher/assignments/store
GET /teacher/assignments/{id}/edit
POST /teacher/assignments/{id}/update
POST /teacher/assignments/{id}/delete
GET /teacher/notices
POST /teacher/notices/store
```

## Admin Routes

```text
GET /admin/dashboard
RESOURCE /admin/students
RESOURCE /admin/teachers
RESOURCE /admin/courses
RESOURCE /admin/routines
RESOURCE /admin/notices
RESOURCE /admin/materials
RESOURCE /admin/assignments
```

## Authentication Requirements

1. Login should use email and password.
2. Passwords must be hashed.
3. User role must be checked after login.
4. Users should be redirected based on role.
5. Logged-in users should not access login page again unless logged out.
6. Logged-out users should not access protected pages.
7. Logout should destroy the session.

## Role-Based Access Requirements

### Student Access

Students can access:

1. Student dashboard
2. Own profile
3. Courses
4. Class routine
5. Notices
6. Study materials
7. Assignments

### Teacher Access

Teachers can access:

1. Teacher dashboard
2. Own profile
3. Assigned courses
4. Class routine
5. Study material management
6. Assignment management
7. Notice management

### Admin Access

Admins can access:

1. Admin dashboard
2. Student management
3. Teacher management
4. Course management
5. Routine management
6. Notice management
7. Study material management
8. Assignment management

## Validation Requirements

1. Name fields are required.
2. Email must be valid and unique where needed.
3. Password is required for user creation.
4. Course code should be unique.
5. Required form fields must be validated.
6. File upload should allow common document formats such as PDF, DOCX, PPTX, JPG, and PNG.
7. Assignment deadline should be a valid date.
8. Delete actions should ask for confirmation.
9. Phone number should use a valid format if provided.
10. Empty form submissions should show validation messages.

## Security Requirements

1. Passwords must be hashed.
2. Role-based access must be enforced.
3. Users should not access other roles' dashboards.
4. File uploads should be validated.
5. Direct access to restricted pages should be blocked.
6. Session logout should work properly.
7. Sensitive data should not be exposed in public pages.
8. `.env` file must not be pushed to GitHub.
9. Uploaded file paths should be handled safely.
10. Delete operations should be protected by authentication.

## UI Design Requirement Summary

The UI should look clean, premium, modern, and professional. The system should feel like an academic SaaS dashboard, not a basic plain project.

Design style:

1. Professional academic dashboard
2. Clean white and soft gray background
3. Deep navy and blue primary colors
4. Clear card-based layout
5. Rounded corners
6. Subtle shadows
7. Consistent spacing
8. Responsive design
9. Easy navigation
10. Clear data tables and forms

## Deployment Requirements

The project should be deployable as a Laravel web application.

Deployment checklist:

1. Environment file configured
2. MySQL database connected
3. Migrations executed
4. Storage link created if file upload is used
5. Composer dependencies installed
6. npm dependencies installed
7. Tailwind build generated
8. App key generated
9. Basic seed data added
10. Application tested after deployment

## Seed Data Requirements

The system should include basic seed data for testing:

1. One admin account
2. Two student accounts
3. Two teacher accounts
4. Sample courses
5. Sample routines
6. Sample notices
7. Sample assignments
8. Sample study materials if possible

## Testing Requirements

The team should test:

1. Login for all roles
2. Dashboard access for all roles
3. Student CRUD
4. Teacher CRUD
5. Course CRUD
6. Routine CRUD
7. Notice CRUD
8. Study material upload and view
9. Assignment CRUD
10. Search and filter
11. Role-based page protection
12. Form validation
13. Logout

## GitHub and Development Rules

1. `main` branch contains stable final code.
2. `dev` branch contains active development code.
3. Each task should use a feature branch from `dev`.
4. Branch name should include Jira task ID.
5. Commit message should include Jira task ID.
6. Pull request should be created before merging to `dev`.
7. Tested `dev` branch should be merged to `main` before final submission.

## Final Presentation Evidence

The team should keep screenshots of:

1. Login page
2. Student dashboard
3. Teacher dashboard
4. Admin dashboard
5. CRUD module pages
6. Search/filter result
7. Jira board
8. Sprint progress
9. GitHub branches
10. Pull requests
11. Commit history
12. Documentation pages
13. Database tables
14. Final running project
