<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'office_id',
        'user_id',
        'coin',
        'mandated',
        'type',
        'purchase_date',
        'purchase_order',
        'updated_by'
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
