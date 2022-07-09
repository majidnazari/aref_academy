<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupGate  extends Pivot //extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable=
    [
        "user_id_creator",
        "user_id",
        "group_id",
        "key"        
    ];
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
