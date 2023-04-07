<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'student_id',
        'teacher_id',
        'subject_id',
        'semester_id'
    ];

    public function teachers(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    public function students(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function subjects(): BelongsTo
    {
        return $this->belongsTo(Subject::class , 'subject_id');
    }
    public function semesters(): BelongsTo
    {
        return $this->belongsTo(Semester::class , 'semester_id');
    }
}
