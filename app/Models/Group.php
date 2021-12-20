<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Group extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable=
    [
        "user_id",
        "name"
    ];

    public function user()
    {
        return  $this->belongsTo(User::class);
    }
}
