@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Facturas</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @can('crear-factura')
                        <a class="btn btn-warning" href="{{ route('facturas.create') }}">Nueva</a>
                        @endcan
                        <a href="{{ route('facturas.generatePDF') }}" class="btn btn-primary">Generar PDF</a>
                        <table class="table table-striped mt-2">
                            <thead style="background-color:#6777ef">
                                <tr>
                                    <th style="display: none;">ID</th>
                                    <th style="color:#fff;">Cédula</th>
                                    <th style="color:#fff;">Fecha</th>
                                    <th style="color:#fff;">Subtotal</th>
                                    <th style="color:#fff;">Descuento</th>
                                    <th style="color:#fff;">IVA</th>
                                    <th style="color:#fff;">Total</th>
                                    <th style="color:#fff;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($facturas as $factura)
                                <tr>
                                    <td style="display: none;">{{ $factura->id_factura }}</td>
                                    <td>{{ $factura->cedula }}</td>
                                    <td>{{ $factura->fecha_fac }}</td>
                                    <td>{{ $factura->subtotal_fac }}</td>
                                    <td>{{ $factura->descuento }}</td>
                                    <td>{{ $factura->iva }}</td>
                                    <td>{{ $factura->total }}</td>
                                    <td>
                                        <form action="{{ route('facturas.destroy', $factura->id_factura) }}" method="POST">
                                            @can('editar-factura')
                                            <a class="btn btn-info" href="{{ route('facturas.edit', $factura->id_factura) }}">Editar</a>
                                            @endcan

                                            @csrf
                                            @method('DELETE')
                                            @can('borrar-factura')
                                            <button type="submit" class="btn btn-danger">Borrar</button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Ubicamos la paginación a la derecha -->
                        <div class="pagination justify-content-end">
                            {!! $facturas->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
