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
        "type"
    ];
    public function user()
    {
        return $this->belongsTo('user');
    }
    public function year()
    {
        return $this->belongsTo('year');
    }
    public function teacher()
    {
        return $this->belongsTo('teacher');
    }
}
