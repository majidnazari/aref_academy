<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gate extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable=[

        "users_id",
        "name"  ,
        "description"
    ];
    public function User()
    {
        return $this->blongsTo('user');
    }
}
