<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Crear el perfil del usuario al momento de crear al usuario
    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->profile()->create();
        });
    }

    //Relacion con el perfil, un usuario puede tener un perfil
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function entries(){
        return $this->hasMany(Entry::class);
    }

    public function outlets(){
        return $this->hasMany(Outlet::class);
    }

    public function transfers(){
        return $this->hasMany(Transfer::class);
    }

    public function items(){
        return $this->hasMany(Item::class);
    }
}
