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

## Technology Stack

- Frontend: Laravel Blade, Tailwind CSS
- Backend: Laravel
- Database: MySQL
- Version Control: Git and GitHub
- Project Management: Jira Scrum Board
- Methodology: Agile Scrum

## Local Development Requirements

Install these tools before running the project:

1. PHP 8.3 or newer
2. Composer
3. Node.js
4. npm
5. MySQL

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

This project is configured for MAMP MySQL by default.

Create a MySQL database named:

```text
unitrack_db
```

Then update `.env` with your local MySQL credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=unitrack_db
DB_USERNAME=root
DB_PASSWORD=root
DB_SOCKET=/Applications/MAMP/tmp/mysql/mysql.sock
```

Run migrations after database configuration:

```bash
php artisan migrate
```

If the database does not exist yet, create it manually in phpMyAdmin/Adminer or run:

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
2. `/student/dashboard`
3. `/teacher/dashboard`
4. `/admin/dashboard`

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
