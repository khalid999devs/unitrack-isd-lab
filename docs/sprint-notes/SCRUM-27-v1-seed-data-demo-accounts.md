# SCRUM-27 - V1 Seed Data and Demo Accounts

## Task

Prepare seed data for the Minimum V1 demo.

## What Was Added

- One admin demo account
- Two student demo accounts with student profiles
- Two teacher demo accounts with teacher profiles
- Five sample courses across two semesters
- Five sample class routine entries
- Four sample notices for all, student, teacher, and admin audiences
- Four sample study material records
- Four sample assignment records with future deadlines
- Feature tests for seeded demo data and role login flow

## Demo Accounts

All demo accounts use this local password:

```text
password
```

| Role | Email |
|---|---|
| Admin | `admin@unitrack.test` |
| Student | `student@unitrack.test` |
| Student | `student2@unitrack.test` |
| Teacher | `teacher@unitrack.test` |
| Teacher | `teacher2@unitrack.test` |

## Demo Flow

1. Run `php artisan migrate:fresh --seed`.
2. Log in as `student@unitrack.test` and review dashboard totals, courses, and class routine.
3. Log in as `teacher@unitrack.test` and review assigned courses, class routine, materials, and assignments.
4. Log in as `admin@unitrack.test` and review dashboard totals plus seeded management data.

## Verification Commands

```bash
php artisan migrate:fresh --seed
php artisan test
npm run build
./vendor/bin/pint --test
```
