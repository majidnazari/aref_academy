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
        "year_id",
        "teacher_id",       
        "name",
        "lesson",
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
}
