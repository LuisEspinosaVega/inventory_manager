<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'mandated',
        'type',
        'office_id',
        'user_id',
        'updated_by'
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
