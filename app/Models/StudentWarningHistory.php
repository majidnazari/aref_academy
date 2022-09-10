<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class StudentWarningHistory extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;    

    protected $table="student_warning_histories";

    protected $fillable=[
        "user_id_creator",
        "user_id_updator",
        "student_id",
        "course_id",
        "comment", 
        "response"      

    ];

    public function user_creator()
    {
        return $this->belongsTo(User::class,'user_id_creator');
    }
    public function user_updator()
    {
        return $this->belongsTo(User::class,'user_id_updator');
    }
    public function student()
    {
        return $this->belongsTo(Student::class,"student_id");
    }
    public function course()
    {
        return $this->belongsTo(Course::class,"course_id");
    }
}
