<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CategoriaReceta;

class InicioController extends Controller
{
    //
    public function index()
    {   
        //mostrar la receta por cantidad de votos
        $votados = Receta::withCount('likes')->orderBy('likes_count','desc')->take(3)->get();
        
        //obtener las recetas mas nuevas
        $nuevas = Receta::latest()->take(5)->get();
        //obtener todas las categorias
        $categorias = CategoriaReceta::all();
        //agrupar la receta por categoria
        $recetas =[];
        foreach ($categorias as $categoria){
            $recetas[Str::slug($categoria->nombre)][]=Receta::where("categoria_id",$categoria->id)->take(3)->get();
        }
        
        return view("inicio.index",compact('nuevas','recetas','votados'));
    }
}
