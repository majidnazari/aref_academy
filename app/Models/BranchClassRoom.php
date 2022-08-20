<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class BranchClassRoom extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        "user_id_creator",
        "branch_id",
        "name",
        "description",
    ];

    public function user()
    {
        return $this->belongsTo(User::class,"user_id_creator");
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class,"branch_id");
    }
}
