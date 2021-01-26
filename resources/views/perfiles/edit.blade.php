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
    {{--$perfil->usuario--}}
    <h1 class="text-center">Editar mi Perfil</h1>
    <div class="row justify-content-center mt-5">
        <div class="col-md-1 bg-white p-3 shadow">
            <form action="{{route('perfiles.update',['perfil'=>$perfil->id])}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre">Nombre</label>

                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" placeholder="Ingresar tu nombre" value="{{$perfil->usuario->name}}">
                    @error('nombre')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="url">Sitio Web</label>

                    <input type="text" name="url" id="url" class="form-control @error('url') is-invalid @enderror" placeholder="Ingresar tu sitio web" value="{{$perfil->usuario->url}}">
                    @error('url')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="biografia">Biografia</label>

                    <input id="biografia" type="hidden" name="biografia" value="{{$perfil->biografia}}">
                    <trix-editor class="form-control @error('biografia') is-invalid @enderror" input="biografia"></trix-editor>

                    @error('biografia')
                    <span class="invalid-feedback d-block" role="alert">
                      <strong>{{$message}}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="imagen">Foto de perfil</label>
                    <input id="imagen" type="file" class="form-control @error('imagen') is-invalid @enderror" name="imagen">
                    @if($perfil->imagen)
                        <div class="mt-4">
                            <p>Imagen actual:</p>
                           <img src="/storage/{{$perfil->imagen}}" style="width:280px;height:180px">
                        </div>
                        @error('imagen')
                        <span class="invalid-feedback d-block" role="alert">
                        <strong>{{$message}}</strong>
                        </span>
                    @enderror
                  @endif
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Registrar">
                </div>
            </form>
        </div>
    </div>
  
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js" integrity="sha512-/1nVu72YEESEbcmhE/EvjH/RxTg62EKvYWLG3NdeZibTCuEtW5M4z3aypcvsoZw03FAopi94y04GhuqRU9p+CQ==" crossorigin="anonymous" defer></script>
@endsection