<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class RoomStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'student_id',
        'room_id',
        'teacher_id',
    ];
    public function students(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function rooms() : BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
