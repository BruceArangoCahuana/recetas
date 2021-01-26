<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Http\Request;
use App\Models\CategoriaReceta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{
     /**
     * Class constructor.
     */
    public function __construct()
    {
        //autenticar usuarios
        $this->middleware('auth',['except'=>['show','search']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //        $recetas = Auth::user()->recetas;
        $usuario = auth()->user();
        // mostrar la cantidad de megusta de una receta
        $meGusta = auth()->user()->meGusta;
        $recetas = Receta::where('user_id',$usuario->id)->paginate(4);
        return view('recetas.index')->with('recetas',$recetas)->with('usuario',$usuario);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // obtener las categorias sin modelos
          //$categorias = DB::table('categoria_recetas')->get()->pluck('nombre','id');
        //con modelo

        $categorias = CategoriaReceta::all(['id','nombre']);
        return view('recetas.create')->with('categorias',$categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //add($request->all());
        //
        $data = $request->validate([
            'titulo'=>'required|min:6',
            'categoria'=>'required',
            'preparacion'=>'required',
            'ingredientes'=>'required',
            'imagen'=>'required|image'
        ]);
        //ruta imagen
        $ruta_imagen = $request['imagen']->store('upload-recetas','public');
        //rise de la imagen 
       /*
        DB::table('recetas')->insert([
            'titulo'=> $data['titulo'],
            'preparacion'=>$data['preparacion'],
            'ingredientes'=>$data['ingredientes'],
            'imagen'=>$ruta_imagen,
            'user_id'=>Auth::user()->id,
            'categoria_id'=>$data['categoria']
            
        ]);*/
        auth()->user()->recetas()->create([
            'titulo'=> $data['titulo'],
            'preparacion'=>$data['preparacion'],
            'ingredientes'=>$data['ingredientes'],
            'imagen'=>$ruta_imagen,
            'categoria_id'=>$data['categoria']
        ]);
        ///pasar una ruta a traves de un action
        return redirect()->action([RecetaController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        //obtener si al usurio le gusta la receta y esta autenticado
        $like = (auth()->user())? auth()->user()->meGusta->contains($receta->id):false;
        //mostramos la cantidad de like
        $likes = $receta->likes->count();
        return view('recetas.show',compact('receta','like','likes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        //
        $this->authorize('view',$receta);
        $categorias = CategoriaReceta::all(['id','nombre']);
        return view('recetas.edit',\compact('categorias','receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        //revisamos que se cumpla la policy
        $this->authorize('update',$receta);
        $data = $request->validate([
            'titulo'=>'required|min:6',
            'categoria'=>'required',
            'preparacion'=>'required',
            'ingredientes'=>'required',
        ]);
        //actualizar los datos
        $receta->titulo = $data['titulo'];
        $receta->categoria_id = $data['categoria'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];


        //detectar nueva imagen
        if(request('imagen')){
            $ruta_imagen = $request['imagen']->store('upload-recetas','public');
            $receta->imagen = $ruta_imagen;
        }
        $receta->save();
        return redirect()->action([RecetaController::class, 'index']);
    }

    public function search(Request $request)
    {
        # code...
        $busqueda = $request->get('buscar');
        $recetas = Receta::where('titulo','like','%'.$busqueda.'%')->paginate(1);
        $recetas->appends(['buscar'=>$busqueda]);
        return view('busquedas.show',compact('recetas','busqueda'));

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        //autorizar el delte del usuario
        $this->authorize('delete',$receta);

        $receta->delete();
        return redirect()->action([RecetaController::class, 'index']);
    }
}
