@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Usuarios con el Rol: {{ $role->name }}</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead style="background-color:#6777ef">
                                    <th style="color:#fff;">Nombre del Usuario</th>
                                    <th style="color:#fff;">Email</th>
                                    <th style="color:#fff;">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <!-- Aquí puedes agregar los enlaces para modificar los permisos -->
                                            <!-- Ejemplo: <a class="btn btn-primary" href="{{ route('users.permissions', $user->id) }}">Modificar Permisos</a> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
