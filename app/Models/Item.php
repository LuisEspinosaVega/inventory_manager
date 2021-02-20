<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'catalog_id',
        'serial_number',
        'lot',
        'caducity',
        'image',
        'user_id',
        'updated_by',
        'stock',
        'min_stock',
        'max_stock'
    ];

    public function catalog(){
        return $this->belongsTo(Catalog::class);
    }

    public function logs(){
        return $this->hasMany(Log::class);
    }
}
