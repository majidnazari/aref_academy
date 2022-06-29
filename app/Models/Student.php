<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone',
        'first_name',
        'last_name',
        'level',
        'egucation_level',
        'parents_job_title',
        'home_phone',
        'father_phone',
        'mother_phone',
        'school',
        'average',
        'major',
        'introducing',
        'student_phone',
        'cities_id',
        'sources_id',
        'supporters_id',
        'archived'
    ];
    protected $columns = ['id', 'level', 'first_name', 'last_name','last_year_grade','consultants_id','parents_job_title','home_phone','mother_phone','father_phone','phone','school','created_at','updated_at','introducing','student_phone','sources_id','supporters_id','is_deleted','users_id','marketers_id','average','password','viewed','major','egucation_level','provinces_id','is_from_site','description','supporter_seen','saloon','supporter_start_date','banned','cities_id','archived','own_purchases','other_purchases','today_purchases']; // add all columns from you table

    // protected $fillable=[
    //     "id" ,
    //     "first_name",
    //     "last_name",
    //     "last_year_grade",
    //     "consultants_id",
    //     "parents_job_title",
    //     "home_phone",
    //     "father_phone",
    //     "mother_phone",
    //     "phone",
    //     "level",
    //     "school",
    //     "introducing",
    //     "student_phone",
    //     "sources_id",
    //     "supporters_id",
    //     "users_id",
    //     "marketers_id",
    //     "average",
    //     "viewed",
    //     'major',
    //     'egucation_level',
    //     "provinces_id",
    //     "is_from_site",
    //     "description",
    //     "supporter_seen",
    //     "saloon",
    //     "supporter_start_date",
    //     "banned",
    //     "cities_id",
    //     "archived",
    //     "outside_consultants",
    //     "own_purchases",
    //     "other_purchases",
    //     "today_purchases",

    //     "created_at",
    //     "updated_at",
    //     "is_deleted",

    // ];
}
