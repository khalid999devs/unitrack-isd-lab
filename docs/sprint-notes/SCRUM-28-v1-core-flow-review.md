# SCRUM-28 - Minimum V1 Core Flow Review

## Task

Test and review the Minimum V1 flow across Student, Teacher, and Admin roles.

## Review Scope

- Login and logout flow
- Role-based dashboard redirection
- Protected Student, Teacher, and Admin route groups
- Student and Teacher profile pages
- Student management
- Teacher management
- Course management
- Routine management
- Seeded demo account flow

## Integration Fixes

- Added Student own profile route, page, and update action.
- Added Teacher own profile route, page, and update action.
- Added Profile links to Student and Teacher sidebars.
- Removed temporary Student, Teacher, and Admin login shortcut buttons.
- Hardened login so role redirection is based only on the authenticated user's `users.role` value.
- Added unsupported-role login handling so invalid role data cannot enter a dashboard.
- Removed unused Admin resource `show` routes that pointed to missing controller methods.
- Added profile flow tests for viewing, updating, validation, and role protection.
- Extended auth and role integration tests to include role-owned profile routes and login error cases.

## V1 Flow Status

The Minimum V1 core flow is ready for review:

1. Demo users can log in and redirect to their correct dashboards.
2. Student users can view dashboard, profile, courses, routine, notices, materials, and assignments.
3. Teacher users can view dashboard, profile, assigned courses, routine, materials, assignments, and notices.
4. Admin users can manage students, teachers, courses, and routines.
5. Cross-role access is blocked by role middleware.
6. Seeded demo data supports Student, Teacher, and Admin review flows.
7. Login uses email/password only; role is recognized automatically after authentication.

## Verification Commands

```bash
php artisan route:list --except-vendor
APP_ENV=testing DB_CONNECTION=sqlite DB_DATABASE=:memory: php artisan migrate:fresh --seed --force
php artisan test
npm run build
./vendor/bin/pint --test
git diff --check
```
