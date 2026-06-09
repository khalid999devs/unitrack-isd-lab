# Component Usage Guide - SCRUM-10

## Overview
This guide shows how to use the Blade components created for SCRUM-10. All components follow the UniTrack UI/UX Design Specification and use theme tokens from `resources/css/app.css`.

---

## 1. Form Input Component
**File:** `resources/views/components/form-input.blade.php`

### Purpose
Reusable form input field with label, validation errors, and hints. Supports text, email, password, textarea, and select inputs.

### Usage Examples

#### Text Input
```blade
<x-form-input
    name="full_name"
    label="Full Name"
    placeholder="Enter your full name"
    required
/>
```

#### Email Input
```blade
<x-form-input
    name="email"
    type="email"
    label="Email Address"
    placeholder="example@domain.com"
    required
    error="Invalid email format"
/>
```

#### Password Input
```blade
<x-form-input
    name="password"
    type="password"
    label="Password"
    placeholder="••••••••"
    required
    hint="Must be at least 8 characters"
/>
```

#### Textarea
```blade
<x-form-input
    name="description"
    type="textarea"
    label="Description"
    placeholder="Enter description..."
    hint="Maximum 500 characters"
/>
```

#### Select Dropdown
```blade
<x-form-input
    name="department"
    type="select"
    label="Department"
    required
>
    <option value="">Select a department</option>
    <option value="cs">Computer Science</option>
    <option value="cse">Civil Engineering</option>
</x-form-input>
```

### Props
| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | string | '' | Input field name |
| `label` | string | null | Field label |
| `type` | string | 'text' | Input type: text, email, password, textarea, select |
| `placeholder` | string | null | Input placeholder |
| `value` | string | null | Input value |
| `required` | bool | false | Is field required |
| `disabled` | bool | false | Is field disabled |
| `error` | string | null | Error message to display |
| `hint` | string | null | Help text below input |

---

## 2. Badge Component
**File:** `resources/views/components/badge.blade.php`

### Purpose
Display small tag-like elements for roles, status, and categories.

### Usage Examples

#### Role Badges
```blade
<x-badge variant="student">Student</x-badge>
<x-badge variant="teacher">Teacher</x-badge>
<x-badge variant="admin">Admin</x-badge>
```

#### Status Badges
```blade
<x-badge variant="success">Completed</x-badge>
<x-badge variant="warning">Pending</x-badge>
<x-badge variant="error">Failed</x-badge>
<x-badge variant="info">Draft</x-badge>
```

#### Default Badge
```blade
<x-badge>General Tag</x-badge>
```

### Props
| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | 'default' | Badge style: student, teacher, admin, success, error, warning, info, default |

---

## 3. Table Component
**File:** `resources/views/components/table.blade.php`

### Purpose
Display data in a clean, responsive table with optional hover effects.

### Usage Example

#### Basic Table
```blade
<x-table
    :headers="['Student ID', 'Name', 'Email', 'Department', 'Action']"
    :rows="$students"
    emptyMessage="No students found"
>
    @foreach ($students as $student)
        <tr>
            <td class="px-4 py-3 text-sm">{{ $student->id }}</td>
            <td class="px-4 py-3 text-sm">{{ $student->name }}</td>
            <td class="px-4 py-3 text-sm">{{ $student->email }}</td>
            <td class="px-4 py-3 text-sm">{{ $student->department }}</td>
            <td class="px-4 py-3 text-sm">
                <a href="#" class="text-primary-blue hover:underline">Edit</a>
            </td>
        </tr>
    @endforeach
</x-table>
```

#### Table Without Headers
```blade
<x-table :rows="$items">
    <!-- Your row content -->
</x-table>
```

### Props
| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `headers` | array | [] | Column headers |
| `rows` | array | [] | Data rows |
| `emptyMessage` | string | 'No data available' | Message when no data |
| `hoverable` | bool | true | Enable row hover effect |

---

## 4. Form Group Component
**File:** `resources/views/components/form-group.blade.php`

### Purpose
Wrapper component for form containers with consistent styling.

### Usage Example

```blade
<x-form-group title="Personal Information" description="Enter your details">
    <x-form-input
        name="first_name"
        label="First Name"
        required
    />
    <x-form-input
        name="last_name"
        label="Last Name"
        required
    />
    <x-form-input
        name="email"
        type="email"
        label="Email"
        required
    />
</x-form-group>
```

### Props
| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | string | null | Form group title |
| `description` | string | null | Form group description |

---

## 5. Modal Component
**File:** `resources/views/components/modal.blade.php`

### Purpose
Confirmation dialog for delete and critical actions.

### Usage Example

```blade
<!-- Delete Button -->
<button onclick="document.getElementById('deleteModal').classList.remove('hidden')">
    Delete Item
</button>

<!-- Modal -->
<x-modal
    id="deleteModal"
    title="Delete Student"
    message="Are you sure you want to delete this student? This action cannot be undone."
    confirmText="Delete"
    cancelText="Cancel"
    confirmAction="{{ route('admin.students.destroy', $student->id) }}"
/>
```

### Props
| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | string | 'modal' | Modal HTML ID |
| `title` | string | 'Confirmation' | Modal title |
| `message` | string | 'Are you sure?' | Confirmation message |
| `confirmText` | string | 'Confirm' | Confirm button text |
| `cancelText` | string | 'Cancel' | Cancel button text |
| `confirmAction` | string | '#' | Form submission action |

---

## 6. Badge List Component
**File:** `resources/views/components/badge-list.blade.php`

### Purpose
Display multiple badges together in a responsive row.

### Usage Example

```blade
<x-badge-list :items="[
    ['label' => 'Student', 'variant' => 'student'],
    ['label' => 'Active', 'variant' => 'success'],
    ['label' => 'Semester 5', 'variant' => 'info'],
]" />
```

### Props
| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `items` | array | [] | Array of badge objects |

---

## 7. Empty State Component
**File:** `resources/views/components/empty-state.blade.php`

### Purpose
Display user-friendly message when no data is available.

### Usage Example

```blade
<x-empty-state
    icon="📚"
    title="No Courses Found"
    message="You haven't enrolled in any courses yet."
>
    <x-button href="{{ route('courses.index') }}">Browse Courses</x-button>
</x-empty-state>
```

### Props
| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `icon` | string | '📋' | Emoji or icon for state |
| `title` | string | 'No Data' | Empty state title |
| `message` | string | 'Nothing to display at the moment.' | Empty state message |

---

## 8. Spinner Component
**File:** `resources/views/components/spinner.blade.php`

### Purpose
Loading indicator for async operations.

### Usage Example

```blade
<!-- Small Spinner -->
<x-spinner size="sm" />

<!-- Medium Spinner (default) -->
<x-spinner />

<!-- Large Spinner -->
<x-spinner size="lg" />
```

### Props
| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `size` | string | 'md' | Size: sm, md, lg |

---

## Complete Form Example

```blade
<x-form-group title="Create New Student" description="Add a new student to the system">
    <form action="{{ route('admin.students.store') }}" method="POST">
        @csrf

        <x-form-input
            name="student_id"
            label="Student ID"
            placeholder="STU001"
            required
            error="{{ $errors->first('student_id') }}"
        />

        <x-form-input
            name="name"
            label="Full Name"
            placeholder="John Doe"
            required
            error="{{ $errors->first('name') }}"
        />

        <x-form-input
            name="email"
            type="email"
            label="Email Address"
            placeholder="john@example.com"
            required
            error="{{ $errors->first('email') }}"
        />

        <x-form-input
            name="department"
            type="select"
            label="Department"
            required
            error="{{ $errors->first('department') }}"
        >
            <option value="">Select Department</option>
            <option value="cs">Computer Science</option>
            <option value="cse">Civil Engineering</option>
        </x-form-input>

        <x-form-input
            name="semester"
            type="select"
            label="Semester"
            required
            error="{{ $errors->first('semester') }}"
        >
            <option value="">Select Semester</option>
            <option value="1">Semester 1</option>
            <option value="2">Semester 2</option>
        </x-form-input>

        <div class="mt-6 flex gap-3">
            <x-button type="submit">Create Student</x-button>
            <x-button href="{{ route('admin.students.index') }}" variant="secondary">Cancel</x-button>
        </div>
    </form>
</x-form-group>
```

---

## Theme Tokens Used

All components use CSS variables from `resources/css/app.css`:

- `--color-primary-blue` - Primary button and focus states
- `--color-primary-navy` - Dark backgrounds and headings
- `--color-border-soft` - Input and card borders
- `--color-input-border` - Form input borders
- `--color-error` / `--color-error-bg` - Error states
- `--color-role-*-bg` / `--color-role-*-text` - Role badges
- `--color-success-*`, `--color-warning-*`, `--color-info-*` - Status indicators
- `--shadow-card` - Card shadow effect
- `--color-page-bg`, `--color-muted-bg` - Background colors

---

## Component Summary

| Component | Status | Purpose |
|-----------|--------|---------|
| form-input | ✅ | Reusable form inputs with validation |
| badge | ✅ | Role and status badges |
| table | ✅ | Data table display |
| form-group | ✅ | Form container wrapper |
| modal | ✅ | Confirmation dialogs |
| badge-list | ✅ | Multiple badges display |
| empty-state | ✅ | No data messaging |
| spinner | ✅ | Loading indicator |

All components follow Laravel Blade conventions and the UniTrack UI/UX Design Specification.
