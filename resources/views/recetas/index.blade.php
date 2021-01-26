@extends('layouts.app')

@section('botones')
    @include('ui.navegacion')
@endsection
@section('content')
    <h2 class="text-center mb-5">Administra tus recetas</h2>
     
    <div class="col-md-10 mx-auto bg-white p-3">
        <table class="table">
            <thead class="bg-primary text-light">
                <tr>
                    <th scole="col" class="text-center">Titulo</th>
                    <th scole="col" class="text-center">Categoria</th>
                    <th scole="col" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recetas as $receta)
                    <tr class="text-center">
                        <td>{{$receta->titulo}}</td>
                        <td>{{$receta->categoria->nombre}}</td>
                        <td>
                            <eliminar-receta
                                receta-id={{$receta->id}}
                            ></eliminar-receta>
                           
                           <a href="{{route('recetas.edit',['receta'=>$receta->id])}}" class="btn btn-dark d-block mb-2">Editar</a>
                           <a href="{{route('recetas.show',['receta'=>$receta->id])}}" class="btn btn-success d-block mb-2">Ver màs</a>
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
        <div class="col-12 mt-4 justify-content-center d-flex">
            {{ $recetas->links() }}
        </div>
        
        <h2 class="text-center my-5">Las receta que te gustan</h2>
        <div class="col-md-10 mx-auto bg-white p-3">
            @if (count($usuario->meGusta))
            <ul class="list-group">
                @foreach ($usuario->meGusta as $receta)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <p>{{$receta->titulo}}</p>
                        <a href="{{route('recetas.show',['receta'=>$receta->id])}}" class="btn btn-outline-success font-weight-blod text-uppercase" >Ver màs</a>
                    </div>
                @endforeach
            </ul>
            @else
                <p class="text-center">Aun no tienes recetas guardadas <small>Dale megusta a mas recetas</small></p>
            @endif
        </div>
    </div>
    
@endsection