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
                            @can('generar-pdf')
                                <a href="{{ route('audits.generatePDF') }}" class="btn btn-primary" target="_blank">Generar PDF</a>
                            @endcan
                            <a href="{{ route('audits.likert') }}" class="btn btn-primary">Ver Escala de Likert</a>
                            <a href="{{ route('audits.chart') }}" class="btn btn-primary">Ver Gráfico Circular</a>
                            <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">
                                    <th style="color:#fff;">ID</th>
                                    <th style="color:#fff;">Nombre del Usuario</th>
                                    <th style="color:#fff;">Acción</th>
                                    <th style="color:#fff;">Ubicación de la Acción</th>
                                    <th style="color:#fff;">Fecha</th>
                                    <th style="color:#fff;">Correo del Usuario</th>
                                    <th style="color:#fff;">Acciones</th>
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
                                            <td>
                                                <form action="{{ route('audits.destroy', $audit->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este registro de auditoría?')">Borrar</button>
                                                </form>
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
