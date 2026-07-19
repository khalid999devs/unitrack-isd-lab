# SCRUM-45 - Project Workflow and Application Audit

## Task

Audit the Jira and GitHub project workflow, verify V1 application behavior, and correct integration or release-readiness issues.

## Audit Context

- Audit date: 2026-07-19
- Feature branch: `feature/SCRUM-45-audit-jira-github-workflow`
- Base branch: `dev`
- Base commit: `00c51ca`

## Application Audit

The audit traced each visible Student, Teacher, and Admin action to its route, controller, validation, model scope, database record, and Blade response.

Implemented or corrected during the audit:

1. Added complete Admin management flows for study materials and assignments.
2. Completed Teacher edit, delete, submission review, and download flows.
3. Scoped Student courses, routines, materials, and assignments by department, semester, and batch as applicable.
4. Connected Student and Teacher dashboards to live database data.
5. Added search, filters, pagination, ownership checks, deadline checks, upload validation, and private-file cleanup.
6. Normalized account emails and rate limited login and registration requests.
7. Removed retained registration password hashes after approval or rejection.
8. Added branded error pages for 403, 404, 419, 429, and 500 responses.
9. Replaced external font/icon dependencies with locally built assets and aligned the UI with documented theme tokens.
10. Removed unused starter components and verified responsive navigation, consistent identity controls, and working CTA links.
11. Added Composer and npm validation/security checks to the GitHub Actions workflow.

## Browser Verification

A fresh SQLite database was migrated and seeded for isolated browser testing.

The configured MAMP connection was also checked without changing data. MySQL 8.0.40 connected successfully to `unitrack_db` on port 8889, existing seed records were present, and `2026_07_19_000010_make_registration_request_password_nullable` was the only pending migration. A `migrate --pretend` preview generated the expected nullable-column SQL, and a second status check confirmed it remained pending. That migration must be applied after this branch is accepted and before the updated approval/rejection flow is used on that database.

Verified flows:

1. Student, Teacher, and Admin credentials redirect to the correct dashboards.
2. All 70 role pages reachable from the UI returned successful responses: 7 Student, 17 Teacher, and 46 Admin pages.
3. Cross-role dashboard access returns the branded 403 response.
4. Login password visibility, responsive layouts, mobile navigation, and logout work.
5. Registration role fields switch correctly.
6. A new Student request remains pending, appears in the Admin queue, can be approved, creates the User and Student profile, and can then log in.
7. Admin and Teacher create/edit/delete forms and Student submission forms resolve to real backend endpoints.

## GitHub Workflow Audit

Verified from the remote repository:

1. Feature pull requests target `dev`; release pull requests target `main` from `dev`.
2. Twenty pull requests were merged through the documented branch flow.
3. `main` and `dev` are protected by an active ruleset that blocks deletion and force pushes and requires one approving pull-request review.
4. The current `dev` and release CI runs passed.
5. No pull request was open at audit time.

Workflow findings that should be cleaned up without rewriting history:

1. Remote branches `feature/SCRUM-15-login-backend` and `feature/SCRUM-16-dashboard-redirection` remain after their work was superseded.
2. Older PR titles #7 and #13 through #16 omit the required colon after the Jira ID.
3. Historical commit `3da4c1a` does not include a Jira ID.
4. The GitHub ruleset does not require the CI status check, resolved review threads, code-owner review, or approval after the latest push.
5. Repository owners can bypass the ruleset, so the team process must still require green checks and review.

Recommended repository actions:

1. Delete obsolete merged or superseded feature branches after confirming they are no longer needed.
2. Make the CI workflow a required status check for `dev` and `main`.
3. Require review-thread resolution and approval after the latest push when repository settings allow it.
4. Continue using `SCRUM-ID: Short task title` for PRs and `SCRUM-ID Short action` for commits.

## Jira Audit Boundary

The task screenshot confirms SCRUM-45 is assigned to Khalid, is a child of SCRUM-44, and was in To Do when captured. Jira board data is private and is not stored in this repository, so Sprint 1, Sprint 2, and Sprint 3 field completeness must be confirmed directly in Jira.

Manual Jira checklist:

1. Every item has the correct epic or story parent and work type.
2. Every active item has an assignee, story points, sprint, status, and realistic dates.
3. Status follows `To Do -> In Progress -> In Review -> Done`.
4. Coding work links the Jira ID to its branch, commits, and pull request.
5. Items move to Done only after testing, approval, and merge.
6. Sprint 1 and Sprint 2 completed items are closed; incomplete work is moved deliberately, not silently left behind.
7. SCRUM-45 should move to In Review when its pull request opens and Done only after approval and merge.

## Verification Commands

```bash
php artisan route:list --except-vendor
APP_ENV=testing DB_CONNECTION=sqlite DB_DATABASE=/private/tmp/unitrack-scrum45.sqlite php artisan migrate:fresh --seed --force
php artisan test
./vendor/bin/pint --test
php artisan view:cache
npm run build
composer audit --locked
npm audit
git diff --check
```

Verification result:

- 78 Laravel tests passed with 556 assertions.
- All 91 application routes registered successfully.
- Blade template compilation and the Vite production build passed.
- Laravel Pint and Composer package validation passed.
- Composer and npm reported no known dependency vulnerabilities.
- The fresh migration and seed run passed on SQLite.
- The existing MAMP/MySQL connection passed a read-only status check; one branch migration remains pending by design.

## Release Readiness

The audited application flow is ready for pull-request review. Direct Jira field verification, applying the pending migration to the target MySQL environment, and the recommended GitHub ruleset/branch cleanup remain project-administration actions and do not block review of the application changes.
