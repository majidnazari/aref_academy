<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class StudentWarning extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table="student_warnings";

    protected $fillable=[
        "user_id_creator",
       // "user_id_updater",
        "student_id",
        "course_id",
        "comment",        
        "student_warning_history_id"

    ];

    public function user_creator()
    {
        return $this->belongsTo(User::class,'user_id_creator');
    }
    public function user_updater()
    {
        return $this->belongsTo(User::class,'user_id_updater');
    }
    public function student()
    {
        return $this->belongsTo(Student::class,"student_id");
    }
    public function course()
    {
        return $this->belongsTo(Course::class,"course_id");
    }
    public function studentWarningHistory()
    {
        return $this->belongsTo(StudentWarningHistory::class,"student_warning_history_id");
    }
}
