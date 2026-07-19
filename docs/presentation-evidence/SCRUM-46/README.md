# SCRUM-46 - Final V1 Presentation Evidence

## Purpose

This package records the final Minimum V1 verification and provides presentation-ready evidence for the Student, Teacher, and Admin workflows.

## Verified Baseline

| Item | Value |
|---|---|
| Source branch | `dev` |
| Source commit | `334712199157b83cd5574b38d3df9ff577310dcc` |
| Verification date | July 19, 2026 |
| Laravel | 13.14.0 |
| PHP used for verification | 8.5.8 |
| Node.js | 24.18.0 |
| npm | 11.16.0 |
| Database | MySQL 8.0.40 through MAMP |
| Database name | `unitrack_db` |
| Captured presentation evidence | 41 screenshots |

## Final Verification

| Check | Result |
|---|---|
| `php artisan migrate --force` | Passed; all 11 migrations are applied |
| `php artisan test` | Passed; 78 tests and 556 assertions |
| `npm run build` | Passed |
| `./vendor/bin/pint --test` | Passed |
| `php artisan view:cache` | Passed |
| `composer validate --strict` | Passed |
| `composer audit --locked --no-interaction` | Passed; no advisories |
| `npm audit` | Passed; zero vulnerabilities |
| Student login and logout | Passed |
| Teacher login and logout | Passed |
| Admin login and logout | Passed |
| Role-based dashboard redirection | Passed |
| Cross-role access protection | Passed with branded 403 response |
| Desktop horizontal-overflow checks | Passed on captured pages |
| Mobile login horizontal-overflow check | Passed at 390 px |

## Application Evidence

### Authentication

1. [Desktop login and automatic role entry](app/01-login.png)
2. [Responsive mobile login](app/12-login-mobile.png)

### Student Flow

1. [Student dashboard overview](app/02-student-dashboard.png)
2. [Student identity and editable profile](app/03-student-profile.png)
3. [Semester-matched courses and search](app/13-student-courses.png)
4. [Batch and semester class routine](app/14-student-routine.png)
5. [Role-targeted notices](app/15-student-notices.png)
6. [Course materials and downloads](app/16-student-materials.png)
7. [Assignments, filters, deadlines, and submissions](app/17-student-assignments.png)

### Teacher Flow

1. [Teacher dashboard overview](app/04-teacher-dashboard.png)
2. [Teacher identity and editable profile](app/18-teacher-profile.png)
3. [Assigned courses and course search](app/19-teacher-courses.png)
4. [Assigned teaching routine](app/20-teacher-routine.png)
5. [Teacher notice management](app/21-teacher-notices.png)
6. [Study material management](app/22-teacher-materials.png)
7. [Material upload form](app/23-teacher-create-material.png)
8. [Assignment management](app/05-teacher-assignments.png)
9. [Assignment creation form](app/24-teacher-create-assignment.png)
10. [Notice creation form](app/25-teacher-create-notice.png)
11. [Assignment submission roster](app/26-teacher-assignment-submissions.png)

### Admin Flow

1. [Admin dashboard and live record summary](app/06-admin-dashboard.png)
2. [Student management](app/07-admin-students.png)
3. [Teacher management](app/08-admin-teachers.png)
4. [Course management](app/09-admin-courses.png)
5. [Routine management](app/10-admin-routines.png)
6. [Registration approval queue](app/11-admin-registration-requests.png)

## Database Evidence

1. [MAMP MySQL `unitrack_db` table structure and row counts](database/01-mysql-unitrack-tables.png)

The database evidence shows all 11 application tables and the seeded Minimum V1 records without exposing password hashes or environment secrets.

## GitHub Evidence

1. [Merged SCRUM-45 audit pull request](github/01-merged-scrum-45-pr.png)
2. [Pull request history](github/02-pull-request-history.png)
3. [`dev` commit history](github/03-dev-commit-history.png)

## Documentation Evidence

1. [Project README and feature summary](documentation/01-readme.png)
2. [Design and technical requirements](documentation/02-technical-requirements.png)
3. [UI and UX design specification](documentation/03-ui-ux-specification.png)

## Jira Evidence

Eight historical Jira screenshots cover the initial board, backlog, project summary, Jira documentation list, GitHub integration, and team review activity. They are indexed in [jira/README.md](jira/README.md).

The current Jira board, timeline, and SCRUM-46 details still require the project owner's authenticated browser session. Follow the same checklist and add those current screenshots before marking SCRUM-46 as Done.

## Suggested Presentation Order

1. Introduce the Minimum V1 scope with the README and technical requirements.
2. Demonstrate automatic role recognition and responsive access from the login page.
3. Follow the Student sidebar from dashboard through profile, courses, routine, notices, materials, and assignments.
4. Follow the Teacher sidebar from dashboard through assigned courses, routine, materials, assignments, submissions, and notices.
5. Present the Admin dashboard and core management pages.
6. Show the MySQL schema and seeded record counts.
7. Show Jira sprint organization, pull request history, and `dev` commit history.
8. Close with the automated verification results above.

## Completion Status

The Minimum V1 application, database, GitHub workflow, and documentation evidence are complete. The only outstanding SCRUM-46 presentation items are the manual Jira board and Jira timeline screenshots.
