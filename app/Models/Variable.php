<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'description',
        'name'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
