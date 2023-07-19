@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Modificar Articulo</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">                            
                   
                        @if ($errors->any())                                                
                            <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                <strong>¡Revise los campos!</strong>                        
                                @foreach ($errors->all() as $error)                                    
                                    <span class="badge badge-danger">{{ $error }}</span>
                                @endforeach                        
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif


                        <form action="{{ route('articulos.actualizar',$articulo->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Nombre Articulo</label>
                                        <input type="text" name="nombre" class="form-control" value="{{ $articulo->nombre }}">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="cantidad">Cantidad a añadir</label>
                                        <input type="number" name="cantidad" class="form-control" value="0">
                                    </div>
                                </div>
                                
                                <br>
                                <button type="submit" class="btn btn-primary">Guardar</button>                            
                            </div>
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection