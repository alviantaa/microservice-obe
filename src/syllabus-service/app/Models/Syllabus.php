<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    use HasFactory;

    protected $fillable = [
        'course',
        'title',
        'author',
        'head_of_study_program',
        'creator_user_id',     					
    ];
}
