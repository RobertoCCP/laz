@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Gráficos por Tabla</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row legend-items">
                                <div class="col-lg-2">
                                    <span class="legend-color" style="background-color: red;"></span>
                                    <span class="legend-text">Nunca</span>
                                </div>
                                <div class="col-lg-2">
                                    <span class="legend-color" style="background-color: orange;"></span>
                                    <span class="legend-text">Una vez</span>
                                </div>
                                <div class="col-lg-2">
                                    <span class="legend-color" style="background-color: yellow;"></span>
                                    <span class="legend-text">Dos veces</span>
                                </div>
                                <div class="col-lg-2">
                                    <span class="legend-color" style="background-color: lightgreen;"></span>
                                    <span class="legend-text">Tres veces</span>
                                </div>
                                <div class="col-lg-2">
                                    <span class="legend-color" style="background-color: darkgreen;"></span>
                                    <span class="legend-text">Excesivas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                @foreach ($tables as $table)
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ ucfirst($table) }}</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chart-{{ $table }}"></canvas>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @foreach ($tables as $table)
        @php
            $chartData = [];
            $colors = [];
            foreach ($likertData as $userData) {
                $actions = $userData['actions'][$table] ?? null;
                $total = $actions ? $actions['total'] : 0;
                $chartData[] = $total;
                if ($total === 0) {
                    $colors[] = 'red';
                } elseif ($total === 1) {
                    $colors[] = 'orange';
                } elseif ($total === 2) {
                    $colors[] = 'yellow';
                } elseif ($total === 3) {
                    $colors[] = 'lightgreen';
                } elseif ($total >= 4) {
                    $colors[] = 'darkgreen';
                }
            }
        @endphp
        <script>
            var ctx = document.getElementById('chart-{{ $table }}').getContext('2d');

            var data = {
                labels: [@foreach ($likertData as $userData) '{{ $userData["user"]->name }}', @endforeach],
                datasets: [{
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: {!! json_encode($colors) !!}
                }]
            };

            var options = {
                responsive: true,
                maintainAspectRatio: false
            };

            var chart = new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: options
            });
        </script>
    @endforeach
@endsection
