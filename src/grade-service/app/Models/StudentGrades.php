<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGrades extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'student_user_id',
        'assignment_id',
        'published',
    ];
}
