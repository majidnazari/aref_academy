<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Course extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        "user_id_creator",
        "branch_id",
        "year_id",
        "teacher_id",       
        "name",
        "gender",
        "lesson_id",
        "type",
        "education_level",
        "financial_status",
        "user_id_financial",
        "sum_not_registered_session",
        "sum_noAction_session",
        "sum_dellay60_session",
        "sum_dellay45_session",
        "sum_dellay30_session",
        "sum_dellay15_session",
        "sum_present_session",
        "sum_absent_session",
        "total_remain_session",
        "total_done_session",
        "total_session",
        "total_transferred",
        "total_noMoney",
        "total_withMoney"
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
    public function courseStudent()
    {
        return $this->hasMany(CourseStudent::class,"course_id");
    }
}
