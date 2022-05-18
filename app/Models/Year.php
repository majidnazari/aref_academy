<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Year extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "user_id_creator",
        'name',
        'active'
       // 'year'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,"user_id_creator");
    }
}
