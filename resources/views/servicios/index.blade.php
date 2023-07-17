@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Servicios</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                
            
                        @can('crear-servicio')
                        <a class="btn btn-warning" href="{{ route('servicios.create') }}">Nuevo</a>
                        @endcan
            
                        <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">                                     
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Nombre</th> 
                                    <th style="color:#fff;">Descripción</th> 
                                    <th style="color:#fff;">precio</th>                                                                 
                              </thead>
                              <tbody>
                            @foreach ($servicios as $servicio)
                            <tr>
                                <td style="display: none;">{{ $servicio->id }}</td>    
                                <td>{{ $servicio->nombreServicio }}</td>
                                <td>{{ $servicio->descripcion }}</td>
                                <td>{{ $servicio->precio }}</td>
                                <td>
                                    <form action="{{ route('servicios.destroy',$servicio->id) }}" method="POST">                                        
                                        @can('editar-servicio')
                                        <a class="btn btn-info" href="{{ route('servicios.edit',$servicio->id) }}">Editar</a>
                                        @endcan

                                        @csrf
                                        @method('DELETE')
                                        @can('borrar-servicio')
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
                            {!! $servicios->links() !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection