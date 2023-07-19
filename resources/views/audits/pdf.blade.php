<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Informe de Auditoría</title>
    <style>
        /* Estilos CSS existentes */
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

        /* Nuevos estilos */
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .info {
            font-size: 14px;
            margin-bottom: 15px;
        }

        .page-number {
            font-size: 12px;
            position: absolute;
            top: 0;
            right: 0;
            padding: 5px 10px;
        }

        .business-name {
            font-size: 18px;
            font-weight: bold;
        }

        /* Estilos de la tabla */
        .table-container {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            text-align: left;
        }

        .table-container th, .table-container td {
            padding: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="info">
        Fecha y hora de impresión: {{ now() }}
    </div>
    <div class="page-number">
        Página <span class="page">1</span> de <span class="total-pages">1</span>
    </div>
    <h2 class="business-name">Lavanderia Charlies</h2>
    <h2>Informe de Auditoría</h2>
    <div class="table-container">
        <table>
            <!-- Encabezado de la tabla -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Usuario</th>
                    <th>Acción</th>
                    <th>Ubicación de la Acción</th>
                    <th>Fecha</th>
                    <th>Correo del Usuario</th>
                    <th>Direccion IP</th>
                </tr>
            </thead>
            <!-- Datos de la tabla -->
            <tbody>
                @foreach ($audits as $audit)
                    <tr>
                        <td>{{ $audit->id }}</td>
                        <td>{{ $audit->user->name }}</td>
                        <td>{{ $audit->action }}</td>
                        <td>{{ $audit->table_name }}</td>
                        <td>{{ $audit->created_at }}</td>
                        <td>{{ $userEmail }}</td>
                        <td>{{ $audit->ip_address }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Script para obtener el número total de páginas -->
    <script>
        // Esperar a que la página se cargue completamente
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el número total de páginas de la tabla
            const totalRows = document.querySelectorAll('.table-container tbody tr').length;
            const rowsPerPage = 30; // Cambia este valor según el número de filas que deseas mostrar por página

            // Calcular el número total de páginas
            const totalPages = Math.ceil(totalRows / rowsPerPage);

            // Mostrar el número total de páginas en la página
            document.querySelector('.total-pages').textContent = totalPages;

            // Actualizar el número de página actual cada vez que haya un salto de página
            const observer = new IntersectionObserver(function(entries) {
                const visibleRows = entries.filter(entry => entry.isIntersecting).length;
                const currentPage = Math.ceil((visibleRows + rowsPerPage) / rowsPerPage);
                document.querySelector('.page').textContent = currentPage;
            }, { threshold: 0.5 });

            document.querySelectorAll('.table-container tbody tr').forEach(row => observer.observe(row));
        });
    </script>
</body>
</html>
