# UI and UX Design Specification - UniTrack ISD Lab

## Purpose of This Document

This document defines the UI and UX design requirements for the UniTrack system. It explains the visual theme, color palette, typography, layout rules, components, page designs, spacing, responsiveness, and interaction behavior.

This document will help the frontend developer, backend developer, Scrum Master, and code generation tools build a consistent, professional, and premium-looking interface.

## Design Direction

UniTrack should look like a modern academic SaaS dashboard. The design should be clean, premium, trustworthy, and easy to use.

The interface should not look like a basic student project. It should feel like a polished university management product with clear navigation, readable content, elegant cards, and professional form/table design.

## Brand Personality

The design should feel:

1. Professional
2. Academic
3. Clean
4. Trustworthy
5. Modern
6. Organized
7. Premium
8. Easy to understand

## Color Palette

## Primary Colors

### Primary Navy

Hex:

```text
#0F172A
```

Use for:

1. Sidebar background
2. Main headings
3. Important text
4. Premium dark sections

### Primary Blue

Hex:

```text
#2563EB
```

Use for:

1. Primary buttons
2. Active menu item
3. Links
4. Important actions
5. Focus states

### Royal Blue Hover

Hex:

```text
#1D4ED8
```

Use for:

1. Button hover
2. Active states
3. Link hover

## Secondary Colors

### Soft Blue Background

Hex:

```text
#EFF6FF
```

Use for:

1. Light info cards
2. Selected menu backgrounds
3. Soft blue highlights

### Indigo Accent

Hex:

```text
#4F46E5
```

Use for:

1. Dashboard highlights
2. Secondary action emphasis
3. Decorative accents

## Neutral Colors

### Page Background

Hex:

```text
#F8FAFC
```

Use for:

1. Main page background
2. Dashboard background

### Card Background

Hex:

```text
#FFFFFF
```

Use for:

1. Cards
2. Forms
3. Tables
4. Modals

### Border Color

Hex:

```text
#E2E8F0
```

Use for:

1. Card borders
2. Form input borders
3. Table dividers

### Muted Background

Hex:

```text
#F1F5F9
```

Use for:

1. Table header background
2. Disabled fields
3. Light sections

### Main Text

Hex:

```text
#111827
```

Use for:

1. Headings
2. Main content text

### Secondary Text

Hex:

```text
#64748B
```

Use for:

1. Descriptions
2. Small text
3. Table subtext

### Placeholder Text

Hex:

```text
#94A3B8
```

Use for:

1. Input placeholders
2. Disabled text

## Status Colors

### Success

Hex:

```text
#16A34A
```

Use for:

1. Success alerts
2. Completed status
3. Positive messages

### Success Background

Hex:

```text
#DCFCE7
```

### Error

Hex:

```text
#DC2626
```

Use for:

1. Delete buttons
2. Error alerts
3. Validation errors

### Error Background

Hex:

```text
#FEE2E2
```

### Warning

Hex:

```text
#F59E0B
```

Use for:

1. Deadline warnings
2. Pending status

### Warning Background

Hex:

```text
#FEF3C7
```

## Typography

## Font Family

Use:

```text
Inter, ui-sans-serif, system-ui, sans-serif
```

Fallback:

```text
system-ui, Arial, sans-serif
```

## Font Sizes

| Element       | Size         | Weight |
| ------------- | ------------ | ------ |
| Page Title    | 28px to 32px | 700    |
| Section Title | 20px to 24px | 600    |
| Card Title    | 16px to 18px | 600    |
| Body Text     | 14px to 16px | 400    |
| Small Text    | 12px to 13px | 400    |
| Button Text   | 14px         | 600    |
| Table Header  | 12px to 13px | 600    |

## Layout Rules

## Main App Layout

The authenticated app should use a dashboard layout.

Structure:

1. Left sidebar
2. Top navbar
3. Main content area
4. Card-based content sections

Suggested dimensions:

1. Sidebar width: 260px
2. Top navbar height: 64px
3. Main content padding: 24px to 32px
4. Card padding: 20px to 24px
5. Border radius: 12px to 16px

## Page Background

Use:

```text
#F8FAFC
```

Main content should have enough white space and should not look crowded.

## Sidebar Design

Background:

```text
#0F172A
```

Text:

```text
#CBD5E1
```

Active menu background:

```text
#2563EB
```

Active menu text:

```text
#FFFFFF
```

Sidebar should include:

1. UniTrack logo/title
2. Role label
3. Navigation links
4. Logout link at bottom

Sidebar item style:

1. Height: 44px
2. Padding: 12px to 16px
3. Border radius: 10px
4. Icon on left if available
5. Label beside icon

## Top Navbar Design

Background:

```text
#FFFFFF
```

Border bottom:

```text
#E2E8F0
```

Navbar should include:

1. Page title
2. Search input if needed
3. User name
4. User role badge
5. Profile/logout dropdown if implemented

## Component Design

## Buttons

### Primary Button

Background:

```text
#2563EB
```

Hover:

```text
#1D4ED8
```

Text:

```text
#FFFFFF
```

Style:

1. Height: 40px to 44px
2. Padding: 10px 16px
3. Border radius: 10px
4. Font weight: 600
5. Smooth hover transition

Use for:

1. Login
2. Save
3. Create
4. Upload
5. Submit

### Secondary Button

Background:

```text
#FFFFFF
```

Border:

```text
#CBD5E1
```

Text:

```text
#334155
```

Hover background:

```text
#F1F5F9
```

Use for:

1. Cancel
2. Back
3. Reset

### Danger Button

Background:

```text
#DC2626
```

Hover:

```text
#B91C1C
```

Text:

```text
#FFFFFF
```

Use for:

1. Delete
2. Remove

## Cards

Card background:

```text
#FFFFFF
```

Border:

```text
#E2E8F0
```

Shadow:

```text
0 8px 24px rgba(15, 23, 42, 0.06)
```

Border radius:

```text
16px
```

Card padding:

```text
24px
```

Use cards for:

1. Dashboard statistics
2. Form sections
3. Profile summary
4. Notice preview
5. Assignment preview
6. Material preview

## Forms

Input background:

```text
#FFFFFF
```

Input border:

```text
#CBD5E1
```

Focus border:

```text
#2563EB
```

Focus ring:

```text
rgba(37, 99, 235, 0.15)
```

Input height:

```text
42px to 46px
```

Input border radius:

```text
10px
```

Form rules:

1. Label should be above input.
2. Required fields should be clearly marked.
3. Validation errors should appear below input.
4. Forms should be grouped inside cards.
5. Submit button should be at the bottom right or bottom left consistently.

## Tables

Table background:

```text
#FFFFFF
```

Header background:

```text
#F8FAFC
```

Header text:

```text
#475569
```

Row text:

```text
#111827
```

Border:

```text
#E2E8F0
```

Table rules:

1. Use clean table header.
2. Add spacing inside cells.
3. Add action buttons on the right.
4. Use search/filter above table.
5. Empty table should show a clear message.
6. Rows should have hover background.

Hover background:

```text
#F8FAFC
```

## Badges

Use badges for:

1. Role
2. Status
3. Course semester
4. Deadline status
5. Target role

Badge style:

1. Small rounded pill
2. Font size: 12px
3. Padding: 4px 8px
4. Font weight: 600

Role badge colors:

Student:

```text
Background: #DBEAFE
Text: #1D4ED8
```

Teacher:

```text
Background: #EDE9FE
Text: #6D28D9
```

Admin:

```text
Background: #FEE2E2
Text: #B91C1C
```

## Alerts

Success alert:

```text
Background: #DCFCE7
Text: #166534
Border: #BBF7D0
```

Error alert:

```text
Background: #FEE2E2
Text: #991B1B
Border: #FECACA
```

Warning alert:

```text
Background: #FEF3C7
Text: #92400E
Border: #FDE68A
```

## Page Design Details

## Login Page

Design style:

1. Centered login card
2. Premium academic look
3. Soft background
4. UniTrack title and short subtitle
5. Email input
6. Password input
7. Login button
8. Error message area

Background:

```text
#F8FAFC
```

Login card:

1. Width: 420px
2. Padding: 32px
3. Border radius: 20px
4. Background: #FFFFFF
5. Shadow: soft large shadow

Login title:

```text
UniTrack
```

Subtitle:

```text
Student Academic Resource Management System
```

## Student Dashboard

Layout:

1. Welcome section
2. Summary cards
3. Routine preview
4. Latest notices
5. Upcoming assignments
6. Recent study materials

Cards:

1. My Courses
2. Today's Classes
3. New Notices
4. Upcoming Assignments

UX goal:

Student should quickly understand academic updates after login.

## Teacher Dashboard

Layout:

1. Welcome section
2. Assigned course cards
3. Class schedule preview
4. Uploaded materials summary
5. Posted assignments summary
6. Notice management shortcut

Cards:

1. Assigned Courses
2. Today's Classes
3. Uploaded Materials
4. Active Assignments

UX goal:

Teacher should quickly access academic content creation features.

## Admin Dashboard

Layout:

1. Welcome section
2. System statistics cards
3. Quick management links
4. Recent notices/materials/assignments summary

Cards:

1. Total Students
2. Total Teachers
3. Total Courses
4. Total Routines
5. Total Notices
6. Total Assignments

UX goal:

Admin should quickly manage the whole academic system.

## Student Management Page

Used by Admin.

Components:

1. Page title
2. Add Student button
3. Search input
4. Student table
5. Edit button
6. Delete button

Table columns:

1. Student ID
2. Name
3. Email
4. Department
5. Semester
6. Batch
7. Action

## Teacher Management Page

Used by Admin.

Components:

1. Page title
2. Add Teacher button
3. Search input
4. Teacher table
5. Edit button
6. Delete button

Table columns:

1. Teacher ID
2. Name
3. Email
4. Department
5. Designation
6. Action

## Course Management Page

Used by Admin.

Components:

1. Page title
2. Add Course button
3. Search input
4. Department filter
5. Semester filter
6. Course table

Table columns:

1. Course Code
2. Course Title
3. Department
4. Semester
5. Credit
6. Assigned Teacher
7. Action

## Class Routine Page

Components:

1. Page title
2. Filter by semester/batch
3. Filter by day
4. Routine table

Table columns:

1. Day
2. Time
3. Course
4. Teacher
5. Room

Admin can add, edit, and delete routines.

Students and teachers can only view relevant routines.

## Notice Page

Components:

1. Page title
2. Create Notice button for Admin/Teacher
3. Search input
4. Notice cards or table
5. Notice detail view

Notice card should show:

1. Title
2. Short description
3. Posted by
4. Date
5. Target role badge

## Study Materials Page

Components:

1. Page title
2. Upload Material button for Teacher/Admin
3. Course filter
4. Material list
5. Download/view button

Material card/table should show:

1. Title
2. Course
3. Uploaded by
4. Date
5. File action

## Assignment Page

Components:

1. Page title
2. Create Assignment button for Teacher/Admin
3. Course filter
4. Deadline filter
5. Assignment list

Assignment item should show:

1. Title
2. Course
3. Description preview
4. Deadline
5. Posted by

Deadline warning:

If deadline is near, show warning badge.

## Responsive Design

Desktop:

1. Sidebar visible
2. Cards in grid
3. Tables full width

Tablet:

1. Sidebar can be smaller or collapsible
2. Cards use 2-column grid
3. Tables can scroll horizontally

Mobile:

1. Sidebar should become a menu if implemented
2. Cards use 1-column layout
3. Forms should be full width
4. Tables should be horizontally scrollable

## UX Rules

1. User should always know which page they are on.
2. Active sidebar item should be highlighted.
3. Success message should appear after create/update/delete.
4. Error message should be clear and simple.
5. Delete actions should require confirmation.
6. Empty states should explain what to do next.
7. Forms should not be too crowded.
8. Search and filter should be near the related table/list.
9. Important actions should be visually clear.
10. The system should feel consistent across all roles.

## Empty State Messages

Students empty courses:

```text
No courses found for your profile.
```

No notices:

```text
No notices available at this moment.
```

No materials:

```text
No study materials uploaded yet.
```

No assignments:

```text
No assignments found.
```

No search result:

```text
No matching results found. Try changing your search or filter.
```

## Loading State

Use simple loading text or spinner:

```text
Loading...
```

For form submit:

```text
Saving...
```

For upload:

```text
Uploading...
```

## Final UI Quality Checklist

Before final submission, check:

1. Login page looks clean and professional.
2. Sidebar navigation works for all roles.
3. Dashboard cards are aligned.
4. Tables are readable.
5. Forms have proper spacing.
6. Buttons are consistent.
7. Colors are consistent.
8. Error and success messages work.
9. Search and filter are easy to use.
10. Pages are responsive enough for desktop and tablet.
11. UI does not look crowded.
12. All role dashboards look complete.
