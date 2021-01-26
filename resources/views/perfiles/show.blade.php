@extends('layouts.app')


@section('content')
    
    <div class="container">
        <div class="row">
            <div class="col-md-5 perfil">
                @if($perfil->imagen)
                    <img src="/storage/{{$perfil->imagen}}" alt="" class="img-fluid img-thumbnail" style="width:300px;height:200px;">
                @endif
            </div>
            <div class="col-md-7 mt-5 mt-md-0">
                 <h2 class="text-center mb-2 text-primary">{{$perfil->usuario->name}}</h2>
                 <a href="{{$perfil->usuario->url}}">Visitar sitio web</a>
                 <div class="biografia">
                     {!! $perfil->biografia !!}
                 </div>
            </div>
        </div>
    </div>
    <h2 class="text-center my-5">Receta creada por : {{$perfil->usuario->name}}</h2>
    <div class="container">
        <div class="row mx-auto">
            @if (count($recetas) > 0)
            @foreach ($recetas as $receta)
                <div class="col-md-4 mb-2">
                    <div class="card shadow">
                        <img src="/storage/{{$receta->imagen}}" alt="" class="card-img-top">
                    <div class="card-body p-2">
                        <h3 class="text-center">{{$receta->titulo}}</h3>
                        <div class="meta-receta d-flex justify-content-between">
                            @php
                            $fecha = $receta->created_at;
                            @endphp
                            <p class="text-primary fecha font-weight-bold">
                                <fecha-receta fecha="{{$fecha}}"></fecha-receta>
                            </p>
                            <p>{{count($receta->likes)}} Les gusto</p>
                        </div>
                        <a href="{{route('recetas.show',['receta'=>$receta->id])}}" class="btn btn-primary w-100 mt-4 text-uppercase font-weight-bold">Leer màs</a>
                    </div>
                        
                    </div>
                </div>
            @endforeach

            @else
                <p class="text-center w-100">Aun no hay recetas creadas...</p>
            @endif   
            
            <div class="col-12 mt-4 justify-content-center d-flex">
                {{$recetas}}
             </div>
        </div>
    </div>
   {{--@include('ui.footer')--}}
@endsection 
