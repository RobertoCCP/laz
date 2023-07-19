@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Articulos de limpieza</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @can('crear-servicio')
                        <a class="btn btn-warning" href="{{ route('articulos.create') }}">Nuevo</a>
                        @endcan
                        <table class="table table-striped mt-2">
                            <thead style="background-color:#6777ef">
                                <th style="display: none;">ID</th>
                                <th style="color:#fff;">Nombre</th>
                                <th style="color:#fff;">precio</th>
                                <th style="color:#fff;">stock</th>
                                <th style="color:#fff;">acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($articulos as $articulo)
                                <tr>
                                    <td style="display: none;">{{ $articulo->id }}</td>
                                    <td>{{ $articulo->nombre }}</td>
                                    <td>{{ $articulo->precio }}</td>
                                    <td>{{ $articulo->stock }}</td>
                                    <td>
                                        <form action="{{ route('articulos.destroy',$articulo->id) }}" method="POST">
                                            
                                            @can('editar-articulo')
                                            <a class="btn btn-info" href="{{ route('articulos.edit',$articulo->id) }}">Editar</a>
                                            @endcan
                                            
                                            @can('editar-articulo')
                                            <a class="btn btn-success" href="{{ route('articulos.modificar',$articulo->id) }}">Modificar</a>
                                            @endcan

                                            @csrf
                                            @method('DELETE')
                                            @can('borrar-articulo')
                                            <button type="submit" class="btn btn-danger">Borrar</button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Ubicamos la paginacion a la derecha -->
                        <div class="pagination justify-content-end">
                            {!! $articulos->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection