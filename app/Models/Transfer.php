<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'updated_by',
        'mandated',
        'office_id',
        'destiny',
        'comment',
        'applicant',
        'authorizes',
        'receive'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function office(){
        return $this->belongsTo(Office::class);
    }
}
