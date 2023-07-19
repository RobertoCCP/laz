@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Crear Factura</h3>
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

                        <form action="{{ route('facturas.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="cedula">Cédula</label>
                                        <select name="cedula" class="form-control">
                                            @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->cedula }}">{{ $cliente->cedula }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="id_usuario">ID Usuario</label>
                                        <input type="number" name="id_usuario" class="form-control" value="{{ auth()->user()->id }}" readonly>
                                    </div>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="fecha_fac">Fecha</label>
                                        <input name="fecha_fac" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="subtotal_fac">Subtotal</label>
                                        <input type="number" name="subtotal_fac" class="form-control" min="0">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="descuento">Descuento</label>
                                        <input type="number" name="descuento" class="form-control" value="0" min="0">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="iva">IVA</label>
                                        <input type="number" name="iva" class="form-control" value="12" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="total">Total</label>
                                        <input type="number" name="total" class="form-control" readonly>
                                    </div>
                                </div>

                            </div>

                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    var fechaActual = new Date().toISOString().split('T')[0];
    document.querySelector('input[name="fecha_fac"]').value = fechaActual;

    function calcularTotal() {
        var subtotal = parseFloat(document.querySelector('input[name="subtotal_fac"]').value);
        var descuento = parseFloat(document.querySelector('input[name="descuento"]').value);
        var iva = parseFloat(document.querySelector('input[name="iva"]').value);

        // Asegurarnos de que el subtotal sea siempre un número positivo
        if (isNaN(subtotal) || subtotal < 0) {
            subtotal = 0;
            document.querySelector('input[name="subtotal_fac"]').value = 0;
        }

        var total = (subtotal - descuento) * (iva / 10);

        if (!isNaN(total)) {
            document.querySelector('input[name="total"]').value = total.toFixed(2);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        calcularTotal();
    });

    document.querySelectorAll('input[name="subtotal_fac"], input[name="descuento"], input[name="iva"]').forEach(function(input) {
        input.addEventListener('input', calcularTotal);
    });
</script>
@endsection