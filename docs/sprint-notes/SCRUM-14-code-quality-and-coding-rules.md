# SCRUM-14 Code Quality and Coding Rules

## Jira Task ID

SCRUM-14

## Task Title

Set up coding rules and automated code quality checks

## Purpose

This task adds team coding standards and automated checks so UniTrack pull requests are easier to review and safer to merge.

## Files Added

1. `docs/CODING_RULES.md`
2. `.github/workflows/ci.yml`
3. `docs/sprint-notes/SCRUM-14-code-quality-and-coding-rules.md`

## Tools Configured

1. Laravel Pint for PHP formatting checks.
2. Composer scripts for local formatting commands.
3. GitHub Actions for pull request and `dev` branch checks.

## CI Checks Added

The `UniTrack CI` workflow runs on pull requests to `dev` and `main`, and pushes to `dev`.

CI checks:

1. Install Composer dependencies.
2. Copy `.env.example` to `.env`.
3. Generate the Laravel app key.
4. Prepare SQLite for CI.
5. Install npm dependencies with `npm ci`.
6. Run `npm run build`.
7. Run `./vendor/bin/pint --test`.
8. Run `php artisan test`.

## Local Commands

```bash
composer install
npm install
npm run build
./vendor/bin/pint --test
./vendor/bin/pint
php artisan test
```

## How This Helps PR Review

1. Developers have one shared coding rules document.
2. Formatting issues are caught before review.
3. Frontend build issues are caught before merge.
4. Laravel tests run automatically on pull requests.
5. Reviewers can focus on behavior, structure, and task fit.

## Verification Results

Completed local verification:

```bash
composer install              # passed
npm install                   # passed
npm run build                 # passed
./vendor/bin/pint --test      # passed
php artisan test              # passed
CI-style SQLite test          # passed
```

## Assumptions

1. SCRUM-14 is the Jira issue ID for this branch.
2. Laravel Pint is already present as a development dependency.
3. SQLite is used only for CI checks; local development remains MySQL by default.
4. This task does not change application features or database schema.
