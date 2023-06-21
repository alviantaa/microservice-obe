<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGradeDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_grade_id',
        'criteria_level_id', 
        'assignment_plan_task_id'
    ];
};