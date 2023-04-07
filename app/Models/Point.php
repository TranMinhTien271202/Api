<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'student_id',
        'teacher_id',
        'room_id',
        'subject_id'
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
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function rooms(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
