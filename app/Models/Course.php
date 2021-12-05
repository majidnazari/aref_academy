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
        "users_id",
        "teachers_id",
        "years_id",
        "name",
        "lesson",
        "type"
    ];
    public function User()
    {
        return $this->belongsTo('user');
    }
}
