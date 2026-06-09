# Quick Component Reference - SCRUM-10

A quick lookup guide for the 13 reusable Blade components.

## All Components at a Glance

### Layout Components (2)
```blade
<x-sidebar :role="'student'" :active="'dashboard'" />
<x-navbar title="Dashboard" role="student" />
```

### Button Component (1)
```blade
<x-button>Primary</x-button>
<x-button variant="secondary">Secondary</x-button>
<x-button variant="danger">Delete</x-button>
```

### Container Components (3)
```blade
<!-- Card container with title and value -->
<x-card title="My Courses" value="12" description="Assigned courses" />

<!-- Form wrapper -->
<x-form-group title="Create Student">
    <!-- form inputs -->
</x-form-group>

<!-- Empty state display -->
<x-empty-state icon="📚" title="No Courses" message="Not enrolled yet" />
```

### Form Components (2)
```blade
<!-- Text/Email/Password inputs -->
<x-form-input name="email" type="email" label="Email" required />

<!-- Textarea -->
<x-form-input name="desc" type="textarea" label="Description" />

<!-- Select -->
<x-form-input name="dept" type="select" label="Department" required>
    <option value="cs">CS</option>
</x-form-input>

<!-- With error and hint -->
<x-form-input name="phone" label="Phone" error="Invalid format" hint="Use +88..." />
```

### Display Components (4)
```blade
<!-- Single badge -->
<x-badge variant="student">Student</x-badge>
<x-badge variant="success">Active</x-badge>

<!-- Multiple badges -->
<x-badge-list :items="[
    ['label' => 'Student', 'variant' => 'student'],
    ['label' => 'Active', 'variant' => 'success'],
]" />

<!-- Data table -->
<x-table :headers="['ID', 'Name', 'Email']">
    <tr>
        <td class="px-4 py-3">1</td>
        <td class="px-4 py-3">John</td>
        <td class="px-4 py-3">john@ex.com</td>
    </tr>
</x-table>

<!-- Alert messages -->
<x-alert type="success">Done!</x-alert>
<x-alert type="error">Error occurred</x-alert>
<x-alert type="warning">Warning</x-alert>
<x-alert type="info">Information</x-alert>
```

### Dialog & Loading (2)
```blade
<!-- Modal confirmation -->
<x-modal id="delete" title="Delete?" message="Are you sure?"
    confirmText="Delete" confirmAction="{{ route('delete') }}" />

<!-- Loading spinner -->
<x-spinner size="md" />
```

## Most Common Patterns

### Login Form
```blade
<x-form-group title="Login" description="Enter your credentials">
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <x-form-input name="email" type="email" label="Email" required />
        <x-form-input name="password" type="password" label="Password" required />
        <x-button type="submit" class="w-full mt-4">Login</x-button>
    </form>
</x-form-group>
```

### Student List
```blade
<x-table :headers="['ID', 'Name', 'Email', 'Status', 'Action']">
    @foreach ($students as $student)
        <tr>
            <td class="px-4 py-3">{{ $student->id }}</td>
            <td class="px-4 py-3">{{ $student->name }}</td>
            <td class="px-4 py-3">{{ $student->email }}</td>
            <td class="px-4 py-3">
                <x-badge variant="success">{{ $student->status }}</x-badge>
            </td>
            <td class="px-4 py-3">
                <a href="#" class="text-primary-blue">Edit</a>
            </td>
        </tr>
    @endforeach
</x-table>
```

### Create Form
```blade
<x-form-group title="Create Student">
    <form action="{{ route('store') }}" method="POST">
        @csrf
        <x-form-input name="student_id" label="ID" required />
        <x-form-input name="name" label="Name" required />
        <x-form-input name="email" type="email" label="Email" required />
        <x-form-input name="dept" type="select" label="Department" required>
            <option value="">Select</option>
            <option value="cs">CS</option>
        </x-form-input>
        <div class="mt-6 flex gap-3">
            <x-button type="submit">Create</x-button>
            <x-button type="button" variant="secondary" onclick="history.back()">Cancel</x-button>
        </div>
    </form>
</x-form-group>
```

### Delete Confirmation
```blade
<!-- Button to trigger modal -->
<button onclick="document.getElementById('deleteModal').classList.remove('hidden')">
    Delete
</button>

<!-- Modal -->
<x-modal id="deleteModal" title="Delete Student?" 
    message="This action cannot be undone."
    confirmText="Delete" cancelText="Cancel"
    confirmAction="{{ route('students.destroy', $student) }}" />
```

### Dashboard Cards
```blade
<section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <x-card title="Courses" value="12" description="Enrolled courses" />
    <x-card title="Notices" value="5" description="New notices" />
    <x-card title="Materials" value="24" description="Study materials" />
    <x-card title="Assignments" value="3" description="Pending tasks" />
</section>
```

## Props Quick Reference

| Component | Key Props |
|-----------|-----------|
| form-input | name, type, label, placeholder, required, error, hint |
| badge | variant (student/teacher/admin/success/error/warning/info) |
| table | headers[], rows[], emptyMessage |
| button | variant (primary/secondary/danger), href, type |
| card | title, description, value |
| modal | id, title, message, confirmText, confirmAction |
| alert | type (success/error/warning/info) |
| empty-state | icon, title, message |
| spinner | size (sm/md/lg) |

## Badge Variants

```
Role Badges:     Status Badges:
- student        - success
- teacher        - error
- admin          - warning
- default        - info
```

## Input Types

```
Form Input supported types:
- text (default)
- email
- password
- textarea
- select (use with <option> tags)
```

## Key Design Tokens

```
Colors: primary-blue, primary-navy, error, success, warning, info
Borders: border-soft, input-border
Shadows: shadow-card, shadow-auth-card
Spacing: Use Tailwind gap-3, px-4, py-3, mt-6 etc
```

## Common Class Utilities

```blade
<!-- Spacing -->
<div class="space-y-4 gap-3 px-4 py-3 mb-4 mt-6">

<!-- Grid layouts -->
<section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

<!-- Flexbox layouts -->
<div class="flex flex-wrap gap-3">
<div class="flex items-center justify-between">

<!-- Responsive text -->
<h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">

<!-- Colors -->
<span class="text-primary-blue text-secondary-text text-error">
<div class="bg-card-bg bg-muted-bg bg-page-bg">
```

---

**Full documentation:** See `docs/COMPONENT_USAGE_GUIDE.md`

**Component showcase:** Visit `/showcase` route to see all components in action

**For help:** Check the example pages in `resources/views/` directory
