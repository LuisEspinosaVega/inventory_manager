<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'outlet_id',
        'entry_id',
        'transfer_id',
        'amount',
        'item_id',
        'status'
    ];

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
