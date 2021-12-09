<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Gate extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable=[

        "user_id",
        "name"  ,
        "description"
    ];
    public function User()
    {
        return $this->blongsTo('user');
    }
}
