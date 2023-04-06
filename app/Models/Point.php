<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
