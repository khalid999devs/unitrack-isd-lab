# UniTrack ISD Lab

UniTrack: Student Academic Resource Management System is a simple web-based academic management system where students, teachers, and admins can manage basic academic activities in one platform.

It helps organize courses, class routines, notices, study materials, and assignments in a structured way.

## Project Features

1. Student, Teacher, and Admin Login
2. Student Profile Management
3. Teacher Profile Management
4. Course Management
5. Class Routine Management
6. Notice Management
7. Study Material Upload and View
8. Assignment or Task Management
9. Student Dashboard
10. Teacher Dashboard
11. Admin Dashboard
12. Search and Filter
13. Student and Teacher Registration Requests with Admin Approval

## Technology Stack

- Frontend: Laravel Blade, Tailwind CSS
- Backend: Laravel
- Database: MySQL
- Version Control: Git and GitHub
- Project Management: Jira Scrum Board
- Methodology: Agile Scrum

## Local Development Requirements

Install these tools before running the project:

1. PHP 8.4.1 or newer
2. Composer
3. Node.js
4. npm
5. MySQL

## Code Quality and Pull Request Checks

Run these commands before opening a pull request:

```bash
composer install
npm install
npm run build
./vendor/bin/pint --test
php artisan test
```

Use Pint to fix PHP formatting when needed:

```bash
./vendor/bin/pint
```

Command purpose:

1. `./vendor/bin/pint --test` checks PHP formatting without changing files.
2. `./vendor/bin/pint` fixes PHP formatting.
3. `npm run build` verifies the frontend asset build.
4. `php artisan test` runs Laravel tests.
5. GitHub Actions automatically runs checks on pull requests.

## Local Setup

Clone the project and install backend dependencies:

```bash
git clone -b dev --single-branch https://github.com/khalid999devs/unitrack-isd-lab.git
cd unitrack-isd-lab
composer install
```

Create the local environment file and application key:

```bash
cp .env.example .env
php artisan key:generate
```

Install frontend dependencies:

```bash
npm install
```

## MySQL Database Setup

This project works with any local MySQL server, including MAMP on macOS, XAMPP on Windows, Laragon, or a direct MySQL installation.

Create a MySQL database named:

```text
unitrack_db
```

The `.env.example` file uses common XAMPP/MySQL defaults:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=unitrack_db
DB_USERNAME=root
DB_PASSWORD=
DB_SOCKET=
```

For MAMP on macOS, update only these values in your local `.env`:

```env
DB_PORT=8889
DB_PASSWORD=root
DB_SOCKET=/Applications/MAMP/tmp/mysql/mysql.sock
```

For XAMPP on Windows, the usual local values are:

```env
DB_PORT=3306
DB_USERNAME=root
DB_PASSWORD=
DB_SOCKET=
```

Run migrations after database configuration:

```bash
php artisan migrate
```

For a fresh local database with demo seed data:

```bash
php artisan migrate:fresh --seed
```

## Demo Accounts and V1 Demo Flow

After running `php artisan migrate:fresh --seed`, use these local demo accounts:

| Role | Email | Password |
|---|---|---|
| Admin | `admin@unitrack.test` | `password` |
| Student | `student@unitrack.test` | `password` |
| Student | `student2@unitrack.test` | `password` |
| Teacher | `teacher@unitrack.test` | `password` |
| Teacher | `teacher2@unitrack.test` | `password` |

Quick demo flow:

1. Log in as `student@unitrack.test` and review dashboard counts, courses, and class routine.
2. Log in as `teacher@unitrack.test` and review assigned courses, class routine, material count, and assignment count.
3. Use `/register` to submit a student or teacher access request.
4. Log in as `admin@unitrack.test`, open Registrations, and approve or reject pending access requests.
5. Review seeded students, teachers, courses, routines, and dashboard totals.

If the database does not exist yet, create it manually in phpMyAdmin/Adminer. MAMP users can also run:

```bash
php -r '$pdo = new PDO("mysql:unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock;charset=utf8mb4", "root", "root"); $pdo->exec("CREATE DATABASE IF NOT EXISTS `unitrack_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");'
```

## Run The Project

Start the Vite development server:

```bash
npm run dev
```

In another terminal, start the Laravel development server:

```bash
php artisan serve
```

Open the application:

```text
http://127.0.0.1:8000/login
```

Starter routes:

1. `/login`
2. `/register`
3. `/student/dashboard`
4. `/teacher/dashboard`
5. `/admin/dashboard`

## Team Members

| Roll    | Name   | Role                                |
| ------- | ------ | ----------------------------------- |
| 2207035 | Khalid | Scrum Master + Full Stack Developer |
| 2207036 | Sadik  | Frontend Developer                  |
| 2207031 | Siyam  | Backend Developer                   |

## Documentation

Project documentation is available inside the `docs` folder.

1. `docs/PROJECT_OVERVIEW.md`
2. `docs/GIT_WORKFLOW.md`
3. `docs/JIRA_WORKFLOW.md`
4. `docs/TEAM_ROLES.md`
5. `docs/System_and_Functional_Requirements.md`
6. `docs/Design_and_Technical_Requirements.md`
7. `docs/UI_and_UX_Design_Specification.md`
8. `docs/CODING_RULES.md`
9. `docs/sprint-notes/SCRUM-8-laravel-setup.md`
10. `docs/sprint-notes/SCRUM-9-database-schema.md`
11. `docs/sprint-notes/SCRUM-14-code-quality-and-coding-rules.md`
12. `docs/sprint-notes/SCRUM-27-v1-seed-data-demo-accounts.md`
13. `docs/sprint-notes/SCRUM-28-v1-core-flow-review.md`

## Branch Management Quick Notice

Repository URL:

```bash
https://github.com/khalid999devs/unitrack-isd-lab.git
```

Clone the `dev` branch directly:

```bash
git clone -b dev --single-branch https://github.com/khalid999devs/unitrack-isd-lab.git
cd unitrack-isd-lab
```

Before starting a new task, always create a feature branch from the latest `dev` branch:

```bash
git checkout dev
git pull origin dev
git checkout -b feature/SCRUM-ID-short-task-name
```

Example:

```bash
git checkout -b feature/SCRUM-8-login-ui
```

Short rules:

1. Do not push directly to `main` or `dev`.
2. Create one feature branch for each Jira task.
3. Include the Jira task ID in branch names and commit messages.
4. Push the feature branch and create a pull request into `dev`.

For SCRUM-8, use this branch name:

```bash
feature/SCRUM-8-laravel-blade-tailwind-setup
```

Suggested commit message:

```bash
SCRUM-8 Initialize Laravel codebase with Blade and Tailwind
```

## Pull Request Management Quick Notice

Create a pull request only after the feature branch is pushed.

Pull request direction:

```text
feature/SCRUM-ID-short-task-name -> dev
```

Pull request title format:

```text
SCRUM-ID: Short task title
```

Example:

```text
SCRUM-9: Design initial MySQL database schema and migrations
```

Pull request description should include:

```md
## What was done

- Short list of completed work

## Testing / Verification

- Commands or checks that were run

## Related Jira task

SCRUM-ID
```

PR rules:

1. Do not create pull requests into `main` for feature work.
2. Always target `dev`.
3. Keep the PR focused on one Jira task.
4. Mention the Jira task ID in the PR title and description.
5. Include testing or verification notes.
6. Wait for review before merging.
