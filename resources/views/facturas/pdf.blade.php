<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background-color: #6777ef;
            color: #fff;
        }

        table th,
        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
    </style>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <h1>Reporte de Facturas</h1>
    <table>
        <thead>
            <tr>
                <th>ID Factura</th>
                <th>Cédula</th>
                <th>ID Usuario</th>
                <th>Fecha</th>
                <th>Subtotal</th>
                <th>Descuento</th>
                <th>IVA</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facturas as $factura)
            <tr>
                <td>{{ $factura->id_factura }}</td>
                <td>{{ $factura->cedula }}</td>
                <td>{{ $factura->id_usuario }}</td>
                <td>{{ $factura->fecha_fac }}</td>
                <td>{{ $factura->subtotal_fac }}</td>
                <td>{{ $factura->descuento }}</td>
                <td>{{ $factura->iva }}</td>
                <td>{{ $factura->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>