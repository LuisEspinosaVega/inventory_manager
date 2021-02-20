<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'main_admin',
        'main_inventory',
        'edit_inventory',
        'main_rh',
        'edit_rh',
        'main_social',
        'edit_social',
        'main_finance',
        'edit_finance'
    ];
}
