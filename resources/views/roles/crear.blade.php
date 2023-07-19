@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Crear Rol</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
                            <div class="form-group">
                                <label for="name">Nombre del Rol:</label>
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label>Permisos para este Rol:</label>
                                <div class="row">
                                    @foreach ($permission as $value)
                                        <div class="col-lg-4">
                                            <div class="form-check">
                                                {{ Form::checkbox('permission[]', $value->id, false, ['class' => 'form-check-input', 'id' => 'permission'.$value->id]) }}
                                                <label class="form-check-label" for="permission{{ $value->id }}">
                                                    {{ $value->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5>Usuarios con sus roles</h5>
                            <ul class="list-group">
                                @foreach ($roles as $role)
                                    <li class="list-group-item">
                                        <strong>{{ $role->name }}</strong>
                                        @if ($role->users->count() > 0)
                                            <ul>
                                                @foreach ($role->users as $user)
                                                    <li>{{ $user->name }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>No hay usuarios con este rol</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
