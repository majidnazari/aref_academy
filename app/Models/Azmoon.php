<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Azmoon extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        "user_id_creator",
        "course_id",
        "course_session_id",
        "isSMSsend",
        "score"        
    ];
    public function user()
    {
        return $this->belongsTo(User::class,"user_id_creator");
    }
    public function course()
    {
        return $this->belongsTo(Course::class,"course_id");
    }
    public function courseSession()
    {
        return $this->belongsTo(CourseSession::class,"course_session_id");
    }
}
