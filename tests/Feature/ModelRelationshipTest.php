<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\Notice;
use App\Models\Routine;
use App\Models\Student;
use App\Models\StudyMaterial;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\TestCase;

class ModelRelationshipTest extends TestCase
{
    public function test_unitrack_models_define_required_relationships(): void
    {
        $this->assertHasOne(new User, 'student', Student::class);
        $this->assertHasOne(new User, 'teacher', Teacher::class);
        $this->assertHasMany(new User, 'notices', Notice::class, 'posted_by');

        $this->assertBelongsTo(new Student, 'user', User::class);
        $this->assertHasMany(new Student, 'assignmentSubmissions', AssignmentSubmission::class);

        $this->assertBelongsTo(new Teacher, 'user', User::class);
        $this->assertHasMany(new Teacher, 'courses', Course::class);
        $this->assertHasMany(new Teacher, 'routines', Routine::class);
        $this->assertHasMany(new Teacher, 'studyMaterials', StudyMaterial::class);
        $this->assertHasMany(new Teacher, 'assignments', Assignment::class);

        $this->assertBelongsTo(new Course, 'teacher', Teacher::class);
        $this->assertHasMany(new Course, 'routines', Routine::class);
        $this->assertHasMany(new Course, 'studyMaterials', StudyMaterial::class);
        $this->assertHasMany(new Course, 'assignments', Assignment::class);

        $this->assertBelongsTo(new Routine, 'course', Course::class);
        $this->assertBelongsTo(new Routine, 'teacher', Teacher::class);

        $this->assertBelongsTo(new Notice, 'postedBy', User::class, 'posted_by');

        $this->assertBelongsTo(new StudyMaterial, 'course', Course::class);
        $this->assertBelongsTo(new StudyMaterial, 'teacher', Teacher::class);

        $this->assertBelongsTo(new Assignment, 'course', Course::class);
        $this->assertBelongsTo(new Assignment, 'teacher', Teacher::class);
        $this->assertHasMany(new Assignment, 'submissions', AssignmentSubmission::class);

        $this->assertBelongsTo(new AssignmentSubmission, 'assignment', Assignment::class);
        $this->assertBelongsTo(new AssignmentSubmission, 'student', Student::class);
    }

    private function assertHasOne(object $model, string $method, string $relatedClass): void
    {
        $relation = $model->{$method}();

        $this->assertInstanceOf(HasOne::class, $relation);
        $this->assertInstanceOf($relatedClass, $relation->getRelated());
    }

    private function assertHasMany(object $model, string $method, string $relatedClass, ?string $foreignKey = null): void
    {
        $relation = $model->{$method}();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf($relatedClass, $relation->getRelated());

        if ($foreignKey !== null) {
            $this->assertSame($foreignKey, $relation->getForeignKeyName());
        }
    }

    private function assertBelongsTo(object $model, string $method, string $relatedClass, ?string $foreignKey = null): void
    {
        $relation = $model->{$method}();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf($relatedClass, $relation->getRelated());

        if ($foreignKey !== null) {
            $this->assertSame($foreignKey, $relation->getForeignKeyName());
        }
    }
}
