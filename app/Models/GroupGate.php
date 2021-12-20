<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Group;
use App\Models\Gate;

class GroupGate extends Model
{
    use HasFactory;
    use softDeletes;
    protected $tabel="group_gates";
    protected $fillable=
    [
        "user_id",
        "group_id",
        "gate_id",
        "name"
    ];

    public function user()
    {
      
        return $this->belongsTo(User::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function gate()
    {
        return $this->belongsTo(Gate::class);
    }
}
