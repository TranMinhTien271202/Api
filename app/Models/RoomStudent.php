<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'student_id',
        'room_id',
    ];
}
