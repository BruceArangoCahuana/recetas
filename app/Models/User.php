<?php

namespace App\Models;

use App\Models\Perfil;
use App\Models\Receta;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'url'
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

    //evento que se ejecuta cuando un usuario es creado
    protected static function boot()
    {
        parent::boot();
        //asignar perfil una vez se hay creado un usuario nuevo
        static::created(function($user){
            $user->perfil()->create();
        });
    }

    //relacion nde 1:n un usuario a muchas recetas
    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }
    //relacion de uno a uno 1:1 hasone
    public function perfil()
    {
        return $this->hasOne(Perfil::class);
    }
    //a las recetas que le han dado megusta
    public function meGusta()
    {
        return $this->belongsToMany(Receta::class,'likes_receta');
    }
}
