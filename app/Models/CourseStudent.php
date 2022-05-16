<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseStudent extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[        
        "course_id",
        "student_id",
        "status",
        "user_id_creator",
        "user_id_approved"
    ];
    public function user()
    {
        return $this->belongsTo('user');
    }
    public function course()
    {
        return $this->belongsTo('course');
    }
    public function student()
    {
        return $this->belongsTo('student');
    }
    
}
