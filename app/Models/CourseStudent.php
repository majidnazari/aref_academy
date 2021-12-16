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
        "user_id_created",
        "user_id_approved"
    ];
    public function User()
    {
        return $this->belongsTo('user');
    }
    public function Course()
    {
        return $this->belongsTo('course');
    }
    public function Student()
    {
        return $this->belongsTo('student');
    }
    
}
