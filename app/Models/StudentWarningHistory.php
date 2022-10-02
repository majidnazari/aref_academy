<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class StudentWarningHistory extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;  
    use SoftDeletes;  

    protected $table="student_warning_histories";

    protected $fillable=[
        "user_id_creator",
        "user_id_updater",
        "student_id",
        "course_id",
        "comment", 
        "response"      

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
}
