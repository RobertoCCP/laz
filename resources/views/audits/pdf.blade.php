<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Informe de Auditoría</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background-color: #6777ef;
            color: #fff;
        }

        table th, table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h2>Informe de Auditoría</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Usuario</th>
                <th>Acción</th>
                <th>Ubicación de la Acción</th>
                <th>Fecha</th>
                <th>Correo del Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($audits as $audit)
                <tr>
                    <td>{{ $audit->id }}</td>
                    <td>{{ $audit->user->name }}</td>
                    <td>{{ $audit->action }}</td>
                    <td>{{ $audit->table_name }}</td>
                    <td>{{ $audit->created_at }}</td>
                    <td>{{ $userEmail }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
