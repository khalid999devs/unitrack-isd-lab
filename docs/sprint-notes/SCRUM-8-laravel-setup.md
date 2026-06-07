# SCRUM-8 Laravel Setup

## Jira Task ID

SCRUM-8

## Task Title

Initialize Laravel codebase with Blade and Tailwind

## What Was Completed

1. Initialized the Laravel application structure in the repository root.
2. Preserved the existing `docs` folder and project documentation.
3. Added Blade layouts for authenticated and auth pages.
4. Added starter login, student dashboard, teacher dashboard, and admin dashboard pages.
5. Added reusable starter components for sidebar, navbar, alert, button, and card.
6. Configured Tailwind CSS through Vite using UniTrack design colors.
7. Added starter web routes for `/login`, `/student/dashboard`, `/teacher/dashboard`, and `/admin/dashboard`.
8. Configured `.env.example` with local MySQL settings for `unitrack_db`.
9. Updated README with local setup and run instructions.

## How To Run Locally

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run dev
php artisan serve
```

Create a MySQL database named:

```text
unitrack_db
```

Then update `.env` if your local MySQL username or password is different.

Default local database settings for XAMPP, Laragon, or a direct MySQL installation:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=unitrack_db
DB_USERNAME=root
DB_PASSWORD=
DB_SOCKET=
```

For MAMP on macOS, use:

```env
DB_PORT=8889
DB_PASSWORD=root
DB_SOCKET=/Applications/MAMP/tmp/mysql/mysql.sock
```

## Verification Checklist

1. `php artisan --version` works.
2. `composer install` completes successfully.
3. `npm install` completes successfully.
4. `npm run dev` starts Vite successfully.
5. `php artisan serve` starts the Laravel server.
6. `/login` loads the starter login page.
7. `/student/dashboard` loads the student starter dashboard.
8. `/teacher/dashboard` loads the teacher starter dashboard.
9. `/admin/dashboard` loads the admin starter dashboard.
10. Tailwind styling is visible on starter pages.
