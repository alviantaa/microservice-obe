<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentData extends Model
{
    use HasFactory;

    protected $table = 'student_data';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'student_id_number',
    ];
}
