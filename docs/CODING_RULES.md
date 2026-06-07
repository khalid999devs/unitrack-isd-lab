# Coding Rules - UniTrack ISD Lab

## Purpose

This document defines the coding rules for UniTrack. It helps team members and AI coding assistants write consistent, readable, reviewable code for the Laravel, Blade, Tailwind, and MySQL codebase.

## General Coding Principles

1. Keep changes focused on the assigned Jira task.
2. Follow Laravel conventions before creating custom structure.
3. Prefer clear names over comments.
4. Keep files small enough to review.
5. Avoid unrelated refactoring in feature branches.
6. Do not commit generated dependency folders such as `vendor` or `node_modules`.
7. Do not commit `.env` or local secrets.

## Comment Rules

1. Do not add unnecessary comments inside code.
2. Use comments only when they explain important reasoning.
3. Keep comments short, precise, and specific.
4. Do not write comments that repeat the code.
5. Remove outdated comments when changing nearby code.

Good comment:

```php
// Keep courses when a teacher profile is removed.
```

Bad comment:

```php
// Set the name variable to the name value.
```

## Variable Naming Rules

1. Use meaningful names that describe the data.
2. Use camelCase for PHP variables.
3. Use snake_case for database columns.
4. Avoid unclear names such as `$data`, `$item`, or `$temp` when a better name is available.
5. Use role-specific names where it improves readability, such as `$studentUser` or `$assignedTeacher`.

## Function and Method Naming Rules

1. Use camelCase for PHP methods.
2. Method names should describe the action or relationship.
3. Controller action names should match Laravel conventions where possible.
4. Eloquent relationship methods should use clear relationship names, such as `teacher()`, `courses()`, or `studyMaterials()`.

## Controller Rules

1. Controllers should handle request flow, validation, authorization checks, and view responses.
2. Keep business logic out of Blade views.
3. Keep database queries readable and scoped to the feature.
4. Use form request classes later if validation becomes large.
5. Do not add controller methods that are not needed by the current Jira task.

## Model Rules

1. Models should represent one database table.
2. Add only relationship methods and safe casts needed by the feature.
3. Keep model names singular, such as `Student`, `Teacher`, and `Course`.
4. Keep table names plural and snake_case.
5. Do not hide important behavior in model methods without tests or documentation.

## Blade View Rules

1. Keep Blade views focused on presentation.
2. Reuse components for repeated UI patterns.
3. Do not place database queries in Blade files.
4. Escape displayed data with Blade defaults unless raw HTML is intentionally required.
5. Keep empty states clear and user-friendly.

## Tailwind CSS Rules

1. Use theme tokens from `resources/css/app.css` for project colors.
2. Follow the UI specification for spacing, cards, buttons, forms, and dashboards.
3. Avoid random one-off colors when a documented token exists.
4. Keep responsive classes intentional and readable.
5. Do not create crowded layouts; preserve spacing and readability.

## Database and Migration Rules

1. Use Laravel migration conventions.
2. Use MySQL-compatible column types.
3. Add foreign keys for required relationships.
4. Choose delete behavior intentionally, such as `cascadeOnDelete()` or `nullOnDelete()`.
5. Keep schema changes in migrations, not manual database edits.
6. Do not change old migrations after they are merged unless the team agrees.
7. Update seeders only with safe local demo data.

## Git and Commit Rules

1. Work on a feature branch created from `dev`.
2. Do not push directly to `main` or `dev`.
3. Include the Jira task ID in branch names and commit messages.
4. Keep commits focused and meaningful.
5. Do not commit `.env`, `vendor`, `node_modules`, `public/build`, or local IDE files.

Commit format:

```text
SCRUM-ID Short action message
```

## Pull Request Rules

1. Open pull requests from feature branches into `dev`.
2. Do not open feature pull requests directly into `main`.
3. Keep one Jira task per pull request.
4. Include a clear summary of changes.
5. Include testing or verification commands.
6. Wait for review before merging.

## Code Quality Checks

Run these checks before opening a pull request:

```bash
npm run build
./vendor/bin/pint --test
php artisan test
```

Use this command to fix PHP formatting:

```bash
./vendor/bin/pint
```

## Rule for AI Coding Assistants

AI assistants must follow this repository's docs and existing code style. They should make small, scoped changes, avoid unrelated rewrites, avoid unnecessary comments, and explain any assumption that affects implementation or verification.

## Final Code Review Checklist

Before requesting review, confirm:

1. The branch name includes the Jira task ID.
2. The change matches the assigned task scope.
3. No unrelated files were changed.
4. `.env`, `vendor`, and `node_modules` are not tracked.
5. New code follows Laravel naming and structure.
6. Blade and Tailwind changes follow the UI specification.
7. Migrations and relationships are intentional.
8. `npm run build` passes.
9. `./vendor/bin/pint --test` passes.
10. `php artisan test` passes.
11. README or sprint notes are updated when setup behavior changes.
