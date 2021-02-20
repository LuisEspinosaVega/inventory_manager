<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'image',
        'rol_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function rol(){
        return $this->belongsTo(Rol::class);
    }
}
