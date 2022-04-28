<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use App\Models\User;

class Menu extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable=[       
        "user_id",
        "name"  ,
        "description"
    ];
    public function user()
    {
        return $this->blongsTo(User::class);
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
