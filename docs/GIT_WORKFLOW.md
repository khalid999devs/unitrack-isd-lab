# Git Workflow - UniTrack ISD Lab

## Project Name

UniTrack: Student Academic Resource Management System

## Purpose of This Document

This document explains how the team will use Git and GitHub during the development of the UniTrack ISD Lab project.

The goal is to keep the project organized, avoid code conflicts, and show proper team collaboration using GitHub, Jira, branches, commits, and pull requests.

## Team Members

| Roll | Name | Role |
|---|---|---|
| 2207035 | Khalid | Scrum Master + Full Stack Developer |
| 2207036 | Sadik | Frontend Developer |
| 2207031 | Siyam | Backend Developer |

## Main Branches

The project will use two main branches:

### 1. main

The `main` branch will contain the stable and final version of the project.

Rules:

1. Do not push directly to `main`.
2. Only tested and reviewed code should be merged into `main`.
3. Final project version will be submitted from this branch.

### 2. dev

The `dev` branch will be used as the main development branch.

Rules:

1. All feature branches will be created from `dev`.
2. Completed features will be merged into `dev` through pull requests.
3. The team will test features in `dev` before merging into `main`.

## Feature Branch Rules

Each Jira task should have its own feature branch.

Branch naming format:

```text
feature/JIRA-ID-short-task-name
```

Examples:

```text
feature/SCRUM-5-github-branch-workflow
feature/SCRUM-8-login-ui
feature/SCRUM-9-backend-setup
feature/SCRUM-10-database-schema
```

## Commit Message Rules

Every commit message should include the Jira task ID.

Commit format:

```text
JIRA-ID short message
```

Examples:

```text
SCRUM-5 Add Git workflow documentation
SCRUM-8 Create login page UI
SCRUM-9 Set up Laravel backend structure
SCRUM-10 Create initial database schema
```

Good commit messages:

```text
SCRUM-8 Create login form layout
SCRUM-9 Add Laravel project setup
SCRUM-10 Add users and roles table structure
```

Bad commit messages:

```text
update
fix
done
final
changes
```

## Pull Request Rules

A pull request must be created when a feature branch is ready to merge into `dev`.

Pull request title format:

```text
JIRA-ID: Short task title
```

Example:

```text
SCRUM-8: Create login page UI
```

Pull request description should include:

```text
What was done:
- Added login page layout
- Added role selection for Student, Teacher, and Admin

Testing:
- Checked page responsiveness
- Checked form layout

Related Jira task:
SCRUM-8
```

## Development Workflow

Each team member should follow this workflow.

### Step 1: Pull latest dev branch

```bash
git checkout dev
git pull origin dev
```

### Step 2: Create a new feature branch

```bash
git checkout -b feature/SCRUM-ID-task-name
```

Example:

```bash
git checkout -b feature/SCRUM-8-login-ui
```

### Step 3: Work on the task

Make the required code changes.

### Step 4: Add and commit changes

```bash
git add .
git commit -m "SCRUM-8 Create login page UI"
```

### Step 5: Push the feature branch

```bash
git push origin feature/SCRUM-8-login-ui
```

### Step 6: Create pull request

Create a pull request from:

```text
feature/SCRUM-8-login-ui -> dev
```

### Step 7: Review and merge

The Scrum Master or another member will check the pull request before merging. Required project checks must pass, review feedback must be resolved, and the remote feature branch should be deleted after the merge.

## Jira and GitHub Connection

Each GitHub branch, commit, and pull request should include the Jira issue ID.

Example Jira task ID:

```text
SCRUM-8
```

Use it in:

Branch name:

```text
feature/SCRUM-8-login-ui
```

Commit message:

```text
SCRUM-8 Create login page UI
```

Pull request title:

```text
SCRUM-8: Create login page UI
```

This helps Jira connect development work with project management tasks.

## Task Status Workflow in Jira

Each task should move through these statuses:

```text
To Do -> In Progress -> In Review -> Done
```

### To Do

The task is planned but not started.

### In Progress

A team member is currently working on the task.

### In Review

The task is completed and waiting for code review or testing.

### Done

The task is fully completed, reviewed, and merged if needed.

## Important Team Rules

1. Do not push directly to `main`.
2. Always create a feature branch from `dev`.
3. Always include Jira task ID in branch names and commits.
4. Always create a pull request before merging into `dev`.
5. Pull latest `dev` before starting new work.
6. Keep commits small and meaningful.
7. Update Jira task status honestly.
8. Communicate if there is any blocker.
9. Do not merge a pull request while required project checks are failing.
10. Delete merged feature branches unless they are intentionally retained for release support.

## Example Full Workflow

For Jira task:

```text
SCRUM-8 Design login and role selection UI
```

Commands:

```bash
git checkout dev
git pull origin dev
git checkout -b feature/SCRUM-8-login-role-ui
git add .
git commit -m "SCRUM-8 Create login and role selection UI"
git push origin feature/SCRUM-8-login-role-ui
```

Then create a pull request:

```text
feature/SCRUM-8-login-role-ui -> dev
```

After review, merge into `dev`.

## Final Submission Rule

Before final project submission:

1. All completed features must be merged into `dev`.
2. The team will test the project from `dev`.
3. After final testing, `dev` will be merged into `main`.
4. The final submitted version will be from `main`.
