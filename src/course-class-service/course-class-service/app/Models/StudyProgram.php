<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $fillable = [
		'name',
];

	public function courses()
	{
			return $this->hasMany(Course::class);
	}

	public function faculty()
	{
			return $this->belongsTo(Faculty::class);
	}
	
}
