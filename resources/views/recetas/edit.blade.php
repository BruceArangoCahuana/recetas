@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css" integrity="sha512-CWdvnJD7uGtuypLLe5rLU3eUAkbzBR3Bm1SFPEaRfvXXI2v2H5Y0057EMTzNuGGRIznt8+128QIDQ8RqmHbAdg==" crossorigin="anonymous" />
@endsection

@section('botones')
   <a href="{{route('recetas.index')}}" class="btn btn-outline-primary mr-2 text-uppercase font-weight-bold">
    <svg class="icono" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
    </svg>
    Regresar</a>    
@endsection
@section('content')
    <h2 class="text-center mb-5">Editar la receta: {{$receta->titulo}}</h2>
  
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <form action="{{route('recetas.update',['receta'=>$receta->id])}}" enctype="multipart/form-data" method="POST" novalidate>
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="titulo">Titulo de la receta</label>

                    <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror" placeholder="Ingresar titulo de receta" value="{{$receta->titulo}}">
                    @error('titulo')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="categoria">Categorias</label>

                    <select 
                    name="categoria"
                     class="form-control @error('categoria') is-invalid @enderror" 
                     id="categoria">
                        <option value="">--Seleccione--</option>
                        @foreach ($categorias as $categoria)
                            <option 
                            value="{{$categoria->id}}" {{$receta->categoria_id == $categoria->id ? 'selected':''}}>{{$categoria->nombre}}</option>
                        @endforeach
                    </select>
                    @error('categoria')
                      <span class="invalid-feedback d-block" role="alert">
                        <strong>{{$message}}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="preparacion">Preparacion</label>

                    <input id="preparacion" type="hidden" name="preparacion" value="{{$receta->preparacion}}">
                    <trix-editor input="preparacion" class="form-control @error('preparacion') is-invalid @enderror"></trix-editor>

                    @error('preparacion')
                      <span class="invalid-feedback d-block" role="alert">
                        <strong>{{$message}}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="ingredientes">Ingerdientes</label>

                    <input id="ingredientes" type="hidden" name="ingredientes" value="{{$receta->ingredientes}}">
                    <trix-editor class="form-control @error('ingredientes') is-invalid @enderror" input="ingredientes"></trix-editor>

                    @error('ingredientes')
                    <span class="invalid-feedback d-block" role="alert">
                      <strong>{{$message}}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="imagen">Imagen</label>
                    <input id="imagen" type="file" class="form-control @error('imagen') is-invalid @enderror" name="imagen">
                    <div class="mt-4">
                        <p>Imagen actual:</p>
                        <img src="/storage/{{$receta->imagen}}" alt="" style="width:300px">
                    </div>
                    @error('imagen')
                    <span class="invalid-feedback d-block" role="alert">
                      <strong>{{$message}}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Editar receta">
                </div>
            </form>
        </div>
    </div>
    
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js" integrity="sha512-/1nVu72YEESEbcmhE/EvjH/RxTg62EKvYWLG3NdeZibTCuEtW5M4z3aypcvsoZw03FAopi94y04GhuqRU9p+CQ==" crossorigin="anonymous" defer></script>
@endsection