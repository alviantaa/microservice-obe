<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
    
	use HasFactory;

	protected $table = 'course_classes';

	protected $fillable =[
		'course_id',
		'name',
		'class_code',
		'thumbnail_img',
		'creator_user_id',
		'syllabus_id'
	];

		public function students()
    {
        return $this->belongsToMany(User::class, 'join_classes', 'course_class_id', 'student_user_id');
    }
}
