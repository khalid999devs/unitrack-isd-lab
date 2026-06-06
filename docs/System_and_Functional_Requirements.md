# System and Functional Requirements - UniTrack ISD Lab

## Purpose of This Document

This document defines the full system scope and functional requirements of UniTrack. It explains the user roles, modules, user flows, feature behavior, validation rules, and expected outputs of the system.

This document will be used by the team members, Jira tasks, GitHub workflow, Copilot/code generation tools, testing, system design diagrams, and final presentation preparation.

## Project Summary

UniTrack: Student Academic Resource Management System is a simple web-based academic management system where students, teachers, and admins can manage basic academic activities in one platform.

The system helps organize courses, class routines, notices, study materials, assignments, and role-based dashboards in a structured way.

## Technology Stack

| Area               | Technology                  |
| ------------------ | --------------------------- |
| Frontend           | Laravel Blade, Tailwind CSS |
| Backend            | Laravel                     |
| Database           | MySQL                       |
| Version Control    | Git and GitHub              |
| Project Management | Jira                        |
| Methodology        | Agile Scrum                 |

## Main User Roles

The system will have three main roles:

1. Student
2. Teacher
3. Admin

Each role will have separate access, dashboard, and permissions.

## Core Modules

The system will contain these modules:

1. Authentication and Role Management
2. Student Profile Management
3. Teacher Profile Management
4. Course Management
5. Class Routine Management
6. Notice Management
7. Study Material Management
8. Assignment or Task Management
9. Student Dashboard
10. Teacher Dashboard
11. Admin Dashboard
12. Search and Filter

## Role-Based Access Overview

| Feature                | Student           | Teacher               | Admin       |
| ---------------------- | ----------------- | --------------------- | ----------- |
| Login                  | Yes               | Yes                   | Yes         |
| View own dashboard     | Yes               | Yes                   | Yes         |
| Manage own profile     | Yes               | Yes                   | Yes         |
| Manage students        | No                | No                    | Yes         |
| Manage teachers        | No                | No                    | Yes         |
| Manage courses         | View only         | View assigned         | Full manage |
| Manage routines        | View only         | View assigned         | Full manage |
| Manage notices         | View only         | Create and view own   | Full manage |
| Manage study materials | View and download | Upload and manage own | Full manage |
| Manage assignments     | View only         | Create and manage own | Full manage |
| Search and filter      | Yes               | Yes                   | Yes         |

# Functional Requirements

## 1. Authentication and Role Management

### Description

The system must allow Student, Teacher, and Admin users to log in securely. After login, each user should be redirected to the correct dashboard based on their role.

### Requirements

1. The system should provide a login page.
2. Users should log in using email and password.
3. The system should check the user role after successful login.
4. Students should be redirected to the Student Dashboard.
5. Teachers should be redirected to the Teacher Dashboard.
6. Admins should be redirected to the Admin Dashboard.
7. Unauthorized users should not access restricted pages.
8. Logged-in users should be able to log out.
9. Passwords must be stored securely using hashing.

### Acceptance Criteria

1. A valid user can log in successfully.
2. Invalid credentials show an error message.
3. Each role is redirected to the correct dashboard.
4. Users cannot access another role's restricted pages.
5. Logout ends the user session properly.

## 2. Student Profile Management

### Description

Students should be able to view and update their academic profile information. Admin should be able to manage student records.

### Data Fields

1. Student ID
2. Name
3. Email
4. Department
5. Semester
6. Batch
7. Phone
8. Address

### Requirements

1. Student can view profile.
2. Student can update editable profile fields.
3. Admin can view student list.
4. Admin can create student records.
5. Admin can update student records.
6. Admin can delete student records.
7. Student records should be searchable.

### Acceptance Criteria

1. Student profile data is displayed correctly.
2. Updated profile data is saved in the database.
3. Admin can manage student records.
4. Required fields are validated.

## 3. Teacher Profile Management

### Description

Teachers should be able to view and update their basic profile information. Admin should be able to manage teacher records.

### Data Fields

1. Teacher ID
2. Name
3. Email
4. Department
5. Designation
6. Phone

### Requirements

1. Teacher can view profile.
2. Teacher can update editable profile fields.
3. Admin can view teacher list.
4. Admin can create teacher records.
5. Admin can update teacher records.
6. Admin can delete teacher records.
7. Teacher records should be searchable.

### Acceptance Criteria

1. Teacher profile data is displayed correctly.
2. Updated teacher data is saved in the database.
3. Admin can manage teacher records.
4. Required fields are validated.

## 4. Course Management

### Description

Courses are the main academic units of the system. Admin can manage courses. Students and teachers can view related courses.

### Data Fields

1. Course ID
2. Course Code
3. Course Title
4. Department
5. Semester
6. Credit
7. Assigned Teacher

### Requirements

1. Admin can create courses.
2. Admin can update course information.
3. Admin can delete courses.
4. Students can view courses based on semester or assigned academic data.
5. Teachers can view assigned courses.
6. Courses can be searched by course code or title.
7. Courses can be filtered by department or semester.

### Acceptance Criteria

1. Course data is saved correctly.
2. Course list is visible to allowed users.
3. Course search and filtering work properly.
4. Duplicate course codes should be avoided.

## 5. Class Routine Management

### Description

Class routines help students and teachers view scheduled classes.

### Data Fields

1. Routine ID
2. Course
3. Teacher
4. Day
5. Start Time
6. End Time
7. Room
8. Semester
9. Batch

### Requirements

1. Admin can create class routines.
2. Admin can update routines.
3. Admin can delete routines.
4. Students can view routine by semester and batch.
5. Teachers can view assigned class schedule.
6. Routine can be filtered by semester, batch, day, or teacher.

### Acceptance Criteria

1. Routine data is shown clearly.
2. Students see relevant routines.
3. Teachers see assigned class routines.
4. Time, room, and course information are displayed properly.

## 6. Notice Management

### Description

Notices are used to share academic announcements with users.

### Data Fields

1. Notice ID
2. Title
3. Description
4. Posted By
5. Target Role
6. Created Date

### Requirements

1. Admin can create notices.
2. Teacher can create course-related notices.
3. Students can view notices.
4. Teachers can view their own notices.
5. Admin can update and delete notices.
6. Users can search notices by title or keyword.

### Acceptance Criteria

1. Notices are displayed to the correct users.
2. Notice details are readable.
3. Search works by title or keyword.
4. Notice creation form validates required fields.

## 7. Study Material Management

### Description

Teachers can upload study materials, and students can view or download them.

### Data Fields

1. Material ID
2. Title
3. Course
4. Uploaded By
5. File Path or Link
6. Description
7. Upload Date

### Requirements

1. Teacher can upload study materials.
2. Teacher can update or delete own uploaded materials.
3. Admin can manage all materials.
4. Students can view and download materials.
5. Materials can be filtered by course.
6. File upload should support common academic file types.

### Acceptance Criteria

1. Uploaded material is saved.
2. Students can access the material.
3. Materials are displayed under the correct course.
4. Invalid file types are rejected.
5. Empty title or course fields are not accepted.

## 8. Assignment or Task Management

### Description

Teachers can create academic assignments or tasks, and students can view them with deadlines.

### Data Fields

1. Assignment ID
2. Title
3. Course
4. Description
5. Assigned By
6. Deadline
7. Created Date

### Requirements

1. Teacher can create assignments.
2. Teacher can update or delete own assignments.
3. Admin can manage all assignments.
4. Students can view assignments.
5. Students can filter assignments by course or deadline.
6. Deadline should be clearly displayed.

### Acceptance Criteria

1. Assignment is visible to students.
2. Deadline is displayed clearly.
3. Teacher can manage assignment details.
4. Required fields are validated.

## 9. Student Dashboard

### Description

The Student Dashboard should provide a quick summary of student academic information.

### Dashboard Items

1. Profile summary
2. Assigned courses
3. Class routine preview
4. Latest notices
5. Recent study materials
6. Upcoming assignments

### Acceptance Criteria

1. Student sees only student-related information.
2. Dashboard is simple and readable.
3. Important academic items are visible quickly.
4. Dashboard links navigate to related pages.

## 10. Teacher Dashboard

### Description

The Teacher Dashboard should help teachers manage academic activities.

### Dashboard Items

1. Profile summary
2. Assigned courses
3. Class schedule
4. Uploaded materials count
5. Posted assignments count
6. Posted notices count

### Acceptance Criteria

1. Teacher sees assigned academic data.
2. Teacher can access material, notice, and assignment management quickly.
3. Dashboard summary data is accurate.

## 11. Admin Dashboard

### Description

The Admin Dashboard should help admins manage the full system.

### Dashboard Items

1. Total students
2. Total teachers
3. Total courses
4. Total routines
5. Total notices
6. Total study materials
7. Total assignments
8. Quick links to management modules

### Acceptance Criteria

1. Admin can access all management modules.
2. Admin sees a summary of system data.
3. Dashboard cards show correct counts.

## 12. Search and Filter

### Description

Search and filter will help users find academic information quickly.

### Requirements

1. Search courses by code or title.
2. Search students by name, ID, or department.
3. Search teachers by name, ID, or department.
4. Search notices by title.
5. Filter study materials by course.
6. Filter assignments by course or deadline.
7. Filter routines by semester, batch, day, or teacher.

### Acceptance Criteria

1. Search returns relevant results.
2. Filters work correctly.
3. Empty results show a clear message.
4. Search inputs should not break the page.

# Main User Flows

## Student Flow

1. Student logs in.
2. Student enters Student Dashboard.
3. Student views profile, courses, routine, notices, materials, and assignments.
4. Student searches or filters academic data.
5. Student downloads study materials if needed.
6. Student logs out.

## Teacher Flow

1. Teacher logs in.
2. Teacher enters Teacher Dashboard.
3. Teacher views assigned courses and routines.
4. Teacher uploads study materials.
5. Teacher creates notices and assignments.
6. Teacher manages own academic content.
7. Teacher logs out.

## Admin Flow

1. Admin logs in.
2. Admin enters Admin Dashboard.
3. Admin manages students and teachers.
4. Admin manages courses and routines.
5. Admin manages notices, materials, and assignments.
6. Admin monitors system data.
7. Admin logs out.

# General Validation Rules

1. Required fields should not be empty.
2. Email should be valid.
3. Password should be protected.
4. Uploaded files should use allowed file types.
5. Assignment deadline should be a valid date.
6. Duplicate course code should be avoided.
7. Unauthorized access should be restricted.
8. Delete actions should ask for confirmation.
9. Long text fields should have reasonable limits.
10. Empty search results should show a user-friendly message.

# Expected Deliverables

1. Working Laravel web application
2. MySQL database integration
3. Role-based login system
4. Student, Teacher, and Admin dashboards
5. CRUD modules for academic management
6. Search and filter functionality
7. GitHub repository with branch workflow
8. Jira Scrum board with sprint progress
9. Project documentation in Docs/Confluence
10. Final presentation with diagrams and workflow evidence

# Definition of Success

The project will be considered successful when:

1. Core features are implemented properly.
2. Student, Teacher, and Admin role-based workflows are functional.
3. Team tasks are managed through Jira.
4. Code is managed through GitHub branches and pull requests.
5. The system is tested before final presentation.
6. Documentation and presentation materials are properly prepared.
7. The team can explain the development process honestly.
