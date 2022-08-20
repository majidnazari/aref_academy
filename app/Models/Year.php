<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

// use OwenIt\Auditing\Auditable;
// use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Contracts\Auditable;


class Year extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    //use \OwenIt\Auditing\Auditable;
    use \OwenIt\Auditing\Auditable;

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
