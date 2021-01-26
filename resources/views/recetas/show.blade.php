@extends('layouts.app')


@section('content')
{{--<h1>{{$receta}}</h1>--}}
    <article class="contenido-receta bg-white p-5 shadow">
        <h1 class="text-center mb-4">{{$receta->titulo}}</h1>
        <div class="imagen-receta">
            <img src="/storage/{{$receta->imagen}}" alt="" class="w-100 imagen-fluid">
        </div>
        <div class="receta-meta mt-5">
            <p>
                <span class="font-weight-bold text-primary fs-1">
                    Categioria:
                </span>
                <a class="text-dark"href="{{route('categorias.show',['categoriaReceta'=>$receta->categoria->id])}}">
                    {{$receta->categoria->nombre}}
                </a>
                
            </p>
            <p>
                <span class="font-weight-bold text-primary fs-1">
                    Autor:
                    {{-- TODO: mostrar en usuario--}}
                </span>
                <a class="text-dark"href="{{route('perfiles.show',['perfil'=>$receta->autor->id])}}">
                    {{$receta->autor->name}}
                </a>
                
            </p>
            <p>
                <span class="font-weight-bold text-primary fs-1">
                    Fecha:
                    {{-- TODO: mostrar en usuario--}}
                </span>
                @php
                    $fecha = $receta->created_at;
                @endphp
                <fecha-receta fecha="{{$fecha}}"></fecha-receta>
                
                
            </p>
            <div class="ingredientes">
                <h2 class="my-3 text-primary">Ingredientes</h2>
                {!! $receta->ingredientes !!}
            </div>

            <div class="preparacion">
                <h2 class="my-3 text-primary">Preparaciòn</h2>
                {!! $receta->preparacion !!}
            </div>
            <div class="justify-content-center row text-center text-uppercase">
                <like-button receta-id="{{$receta->id}}" like="{{$like}}" likes="{{$likes}}"></like-button>
            </div>
            
           
        </div>
    </article>
@endsection