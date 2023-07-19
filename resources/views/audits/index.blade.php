@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Registros de Auditoría</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Botón para borrar todos los registros de auditoría -->
                            <form action="{{ route('audits.destroyAll') }}" method="POST" class="mb-3">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar todos los registros de auditoría?')">Borrar Todos</button>
                            </form>

                            <!-- Resto de la tabla y contenido -->
                            <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">
                                    <th style="color:#fff;">ID</th>
                                    <th style="color:#fff;">Nombre del Usuario</th>
                                    <th style="color:#fff;">Acción</th>
                                    <th style="color:#fff;">Ubicación de la Acción</th>
                                    <th style="color:#fff;">Fecha</th>
                                    <th style="color:#fff;">Correo del Usuario</th>
                                    <th style="color:#fff;">Dirección IP</th> <!-- Nueva columna para la dirección IP -->
                                </thead>
                                <tbody>
                                    @foreach ($audits as $audit)
                                        <tr>
                                            <td>{{ $audit->id }}</td>
                                            <td>{{ $audit->user->name }}</td>
                                            <td>{{ $audit->action }}</td>
                                            <td>{{ $audit->table_name }}</td>
                                            <td>{{ $audit->created_at }}</td>
                                            <td>{{ $audit->user->email }}</td>
                                            <td>{{ $audit->ip_address }}</td> <!-- Mostramos la dirección IP del usuario -->
                                            <td>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Ubicamos la paginación a la derecha -->
                            <div class="pagination justify-content-end">
                                {!! $audits->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
