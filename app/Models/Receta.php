<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receta extends Model
{
    use HasFactory;
    //campos que se agregaran
    protected $fillable = [
        'titulo',
        'preparacion',
        'ingredientes',
        'imagen',
        'categoria_id'
    ];
    public function categoria()
    {
        return $this->belongsTo(CategoriaReceta::class);
    }
    //obtiene la info del usuario via FK
    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    //likes recibido por una receta
    public function likes()
    {
        return $this->belongsToMany(User::class,'likes_receta');
    }
}
