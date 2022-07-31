<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        "user_id_creator",
        "branch_id",
        "year_id",
        "teacher_id",       
        "name",
        "lesson_id",
        "type",
        "education_level",
        "financial_status",
        "user_id_financial",
    ];
    public function user()
    {
        return $this->belongsTo(User::class,"user_id_creator");
    }
    public function year()
    {
        return $this->belongsTo(Year::class,"year_id");
    }
    public function teacher()
    {
        return $this->belongsTo(User::class,"teacher_id");
    }
    public function lesson()
    {
        return $this->belongsTo(Lesson::class,"lesson_id");
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class,"branch_id");
    }
    public function courseSession()
    {
        return $this->hasMany(CourseSession::class,"course_id");
    }
}
