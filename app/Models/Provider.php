<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'bank',
        'account',
        'office',
        'clabe',
        'coin',
        'reazon',
        'rfc',
        'cp',
        'country',
        'city',
        'address',
        'contact',
        'email',
        'phone',
        'about',
        'image'
    ];

    public function entries(){
        return $this->hasMany(Entry::class);
    }
}
