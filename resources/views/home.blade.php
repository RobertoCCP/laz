@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Modulos</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-xl-4">

                                <div class="card bg-c-blue order-card">
                                    <div class="card-block">
                                        <h5>Usuarios</h5>
                                        @php
                                        use App\Models\User;
                                        $cant_usuarios = User::count();
                                        @endphp
                                        <h2 class="text-right"><i class="fas fa-users f-left"></i><span>{{$cant_usuarios}}</span></h2>
                                        <p class="m-b-0 text-right"><a href="/usuarios" class="text-white">Ver más</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
                                <div class="card bg-c-green order-card">
                                    <div class="card-block">
                                        <h5>Roles</h5>
                                        @php
                                        use Spatie\Permission\Models\Role;
                                        $cant_roles = Role::count();
                                        @endphp
                                        <h2 class="text-right"><i class="fas fa-lock f-left"></i><span>{{$cant_roles}}</span></h2>
                                        <p class="m-b-0 text-right"><a href="/roles" class="text-white">Ver más</a></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4">
                                <div class="card bg-c-pink order-card">
                                    <div class="card-block">
                                        <h5>Clientes</h5>
                                        @php
                                        use App\Models\Cliente;
                                        $cant_clientes = Cliente::count();
                                        @endphp
                                        <h2 class="text-right"><i class="fas fa-user f-left"></i><span>{{$cant_clientes}}</span></h2>
                                        <p class="m-b-0 text-right"><a href="/clientes" class="text-white">Ver más</a></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4">
                                <div class="card bg-c-blue order-card">
                                    <div class="card-block">
                                        <h5>Audits</h5>
                                        @php
                                        use App\Models\Audit;
                                        $cant_audits = Audit::count();
                                        @endphp
                                        <h2 class="text-right"><i class="fas fa-search f-left"></i><span>{{$cant_audits}}</span></h2>
                                        <p class="m-b-0 text-right"><a href="/audits" class="text-white">Ver más</a></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4">
                                <div class="card bg-c-green order-card">
                                    <div class="card-block">
                                        <h5>Servicios</h5>
                                        @php
                                        use App\Models\Servicio;
                                        $cant_servicios = Servicio::count();
                                        @endphp
                                        <h2 class="text-right"><i class="fas fa-cogs f-left"></i><span>{{$cant_servicios}}</span></h2>
                                        <p class="m-b-0 text-right"><a href="/servicios" class="text-white">Ver más</a></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4">
                                <div class="card bg-c-pink order-card">
                                    <div class="card-block">
                                        <h5>Facturas</h5>
                                        @php
                                        use App\Models\Factura;
                                        $cant_facturas = Factura::count();
                                        @endphp
                                        <h2 class="text-right"><i class="fas fa-file-invoice f-left"></i><span>{{$cant_facturas}}</span></h2>
                                        <p class="m-b-0 text-right"><a href="/facturas" class="text-white">Ver más</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
                                <div class="card bg-c-blue order-card">
                                    <div class="card-block">
                                        <h5>Articulos</h5>
                                        @php
                                        use App\Models\Articulo;
                                        $cant_articulos = Articulo::count();
                                        @endphp
                                        <h2 class="text-right"><i class="fas fa-box f-left"></i><span>{{$cant_articulos}}</span></h2>
                                        <p class="m-b-0 text-right"><a href="/articulos" class="text-white">Ver más</a></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection