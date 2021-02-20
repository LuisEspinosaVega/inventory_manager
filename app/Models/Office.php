<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'city',
        'address',
        'cp',
        'phone',
        'email',
        'contact'
    ];

    public function entries(){
        return $this->hasMany(Entry::class);
    }

    public function outlets(){
        return $this->hasMany(Outlet::class);
    }

    public function transfers(){
        return $this->hasMany(Transfer::class);
    }
}
