<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'category',
        'sub_category',
        'image',
        'color_primary',
        'color_secondary',
        'group',
        'family',
        'brand',
        'model',
        'created_by',
        'updated_by'
    ];

    public function items(){
        return $this->hasMany(Item::class);
    }
}
