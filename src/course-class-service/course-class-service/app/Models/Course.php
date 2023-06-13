<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

		protected $table = 'courses';

		protected $fillable =[
			'creator_user_id',
			'study_program_id',
			'code',
			'name',
			'course_credit',
			'lab_credit',
			'type',
			'short_description',
			'minimal_requirement',
			'study_material',
			'learning_media'
		];

		public function creator()
    {
        return $this->belongsTo(User::class, 'creator_user_id');
    }

		public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class, 'study_program_id');
    }

    public function courseClasses(){
        return $this->hasMany(CourseClass::class);
    }

    public function syllabuses()
    {
        return $this->hasMany(Syllabus::class);
    }
}
