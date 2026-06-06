# Jira Workflow - UniTrack ISD Lab

## Purpose of This Document

This document explains how the UniTrack team will use Jira for Scrum project management.

The goal is to manage project tasks properly, track team progress, and demonstrate Agile Scrum practices for the ISD Lab project.

## Jira Project Name

UniTrack ISD Lab

## Development Methodology

The team will follow Agile Scrum.

Scrum will help the team:

1. Break the project into small tasks
2. Plan work in sprints
3. Assign tasks to team members
4. Track progress using Jira board
5. Review completed work
6. Improve the process after each sprint

## Team Members

| Roll | Name | Jira Role | Project Role |
|---|---|---|---|
| 2207035 | Khalid | Administrator / Member | Scrum Master + Full Stack Developer |
| 2207036 | Sadik | Member | Frontend Developer |
| 2207031 | Siyam | Member | Backend Developer |

## Jira Work Types

The project will mainly use these Jira work types:

### Task

A small piece of work that needs to be completed.

Example:

```text
Create login page UI
```

### Story

A requirement written from the user's point of view.

Example:

```text
As a student, I want to view my dashboard so that I can see my courses and assignments.
```

### Bug

A problem that needs to be fixed.

Example:

```text
Login button does not redirect user after successful login.
```

### Feature

A larger group of related work.

Example:

```text
Authentication and Role Management
```

## Jira Board Columns

The Jira board will use these columns:

```text
To Do -> In Progress -> In Review -> Done
```

## Column Meaning

### To Do

The task is planned but not started yet.

### In Progress

A team member is currently working on the task.

### In Review

The task is completed and waiting for review, testing, or approval.

### Done

The task is completed, reviewed, tested, and accepted.

## Sprint Plan

### Sprint 1: Project Setup and Planning

Sprint goal:

```text
Set up the UniTrack project foundation, prepare Jira workflow, create GitHub branch workflow, and complete initial requirement documentation.
```

Main tasks:

1. Set up Jira board, sprint, and initial backlog
2. Set up GitHub repository and branch workflow
3. Prepare initial requirement and feature documentation
4. Create frontend project structure
5. Create backend project structure
6. Design initial database schema

### Sprint 2: Core Module Development

Sprint goal:

```text
Develop core modules including authentication, role-based access, profile management, course management, and routine management.
```

Main tasks:

1. Student, Teacher, and Admin login
2. Role-based dashboard redirection
3. Student profile management
4. Teacher profile management
5. Course management
6. Class routine management

### Sprint 3: Academic Content and Finalization

Sprint goal:

```text
Complete academic content modules, dashboards, search/filter, testing, and final documentation.
```

Main tasks:

1. Notice management
2. Study material upload and view
3. Assignment or task management
4. Student dashboard
5. Teacher dashboard
6. Admin dashboard
7. Search and filter
8. Testing and bug fixing
9. Final presentation preparation

## Task Assignment Rule

Each task should have:

1. Clear summary
2. Proper description
3. Assignee
4. Priority
5. Story point estimate
6. Sprint selection
7. Correct status

## Story Point Estimate Guide

Story points are used to estimate task difficulty.

| Story Point | Meaning |
|---|---|
| 1 | Very easy task |
| 2 | Easy task |
| 3 | Medium task |
| 5 | Larger or more complex task |

Example:

```text
Create login button style -> 1 point
Create login UI page -> 2 points
Implement role-based login API -> 3 points
Implement full material upload module -> 5 points
```

## Priority Guide

The team will mainly use these priorities:

### High

Important task needed for project progress.

### Medium

Normal planned task.

### Low

Optional or less urgent task.

## Daily Scrum Format

The team should give short updates using these three questions:

1. What did I complete?
2. What am I working on now?
3. Am I facing any blocker?

Example:

```text
Daily Scrum Update

Khalid:
Completed Jira board setup.
Working on GitHub workflow documentation.
Blocker: None.

Sadik:
Working on login page UI.
Blocker: Needs final color guideline.

Siyam:
Working on backend setup.
Blocker: Oracle connection setup needs checking.
```

## Scrum Master's Responsibilities

The Scrum Master is responsible for:

1. Creating and maintaining Jira board
2. Creating sprint backlog
3. Assigning tasks with the team
4. Tracking task status
5. Helping team members remove blockers
6. Keeping screenshots of Jira progress
7. Managing sprint review and retrospective notes
8. Making sure team follows the GitHub workflow

## Developer Responsibilities

Developers are responsible for:

1. Understanding assigned Jira tasks
2. Moving tasks to In Progress before starting work
3. Creating feature branches from `dev`
4. Writing meaningful commits with Jira issue ID
5. Creating pull requests after completing tasks
6. Moving tasks to In Review after PR creation
7. Fixing issues found during review
8. Moving tasks to Done after approval

## Definition of Done

A task can be moved to Done only when:

1. The required work is completed
2. Code is pushed to GitHub if it is a coding task
3. Pull request is created and reviewed if needed
4. Feature is tested
5. No major bug remains
6. Jira task has proper status update

## Screenshots to Keep for Presentation

The team should keep screenshots of:

1. Jira backlog
2. Active sprint board
3. Task assignment
4. Tasks moving through columns
5. Completed sprint
6. GitHub branches
7. Pull requests
8. Commit history
9. Final project screens

## Notes

All Jira updates should be honest and should reflect real progress. The main purpose of this ISD Lab project is to show proper teamwork, Scrum practice, GitHub collaboration, and software development workflow.
