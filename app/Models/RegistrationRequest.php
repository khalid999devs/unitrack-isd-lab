<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'student_id',
    'teacher_id',
    'department',
    'semester',
    'batch',
    'designation',
    'phone',
    'address',
    'status',
    'reviewed_by',
    'reviewed_at',
    'rejection_reason',
])]
class RegistrationRequest extends Model
{
    use HasFactory;

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'reviewed_at' => 'datetime',
        ];
    }
}
