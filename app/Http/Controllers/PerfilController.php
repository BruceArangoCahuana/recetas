<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Receta;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

   
    public function __construct()
    {
        $this->middleware('auth',['except'=>'show']);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {
        //obtner la receta con paginacion
        $recetas = Receta::where('user_id',$perfil->user_id)->paginate(6);
         return view('perfiles.show',compact('perfil','recetas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {
        //
        $this->authorize('view',$perfil);
        
        return view('perfiles.edit',compact('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {   
        //ejecutamos el policy
        $this->authorize('update',$perfil);
        //dd($request,['imagen']);
        //validar 
        $data = request()->validate([
            'nombre'=>'required',
            'url'=>'required',
            'biografia'=>'required'
        ]);
        //usuario sube la imagen 
        if($request['imagen']){
            $ruta_imagen = $request['imagen']->store('upload-perfiles','public');
            
            //crear un arreglo
            $array_imagen =['imagen'=>$ruta_imagen];
        }
        //asignar nombre url
        auth()->user()->url = $data['url'];
        auth()->user()->name = $data['nombre'];
        auth()->user()->save();
        //eliminar url y nombre  de data 
            unset($data['url']);
            unset($data['nombre']);

        //registrar validacion
        auth()->user()->perfil()->update(  array_merge(
              $data,
              $array_imagen ?? []
         ));
        //asignar biografia eh imagen
        
        
        //redireccionar
        return redirect()->action([RecetaController::class, 'index']);
    }

   
}
