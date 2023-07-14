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
                            <table class="table table-striped mt-2">
                                <thead style="background-color:#6777ef">
                                    <tr>
                                        <th style="color:#fff;">Usuario</th>
                                        @foreach ($tables as $table)
                                            <th style="color:#fff;">{{ ucfirst($table) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($likertData as $userData)
                                        <tr>
                                            <td>{{ $userData['user']->name }}</td>
                                            @foreach ($tables as $table)
                                                <td>
                                                    @if (isset($userData['actions'][$table]))
                                                        @php
                                                            $actions = $userData['actions'][$table];
                                                            $neverChecked = $actions['total'] === 0 ? 'checked' : '';
                                                            $onceChecked = $actions['once'] ? 'checked' : '';
                                                            $twiceChecked = $actions['twice'] ? 'checked' : '';
                                                            $threeTimesChecked = $actions['three_times'] ? 'checked' : '';
                                                            $excessiveChecked = $actions['excessive'] ? 'checked' : '';
                                                        @endphp

                                                        <input type="checkbox" disabled {{ $neverChecked }}>
                                                        Nunca<br>
                                                        <input type="checkbox" disabled {{ $onceChecked }}>
                                                        Una vez<br>
                                                        <input type="checkbox" disabled {{ $twiceChecked }}>
                                                        Dos veces<br>
                                                        <input type="checkbox" disabled {{ $threeTimesChecked }}>
                                                        Tres veces<br>
                                                        <input type="checkbox" disabled {{ $excessiveChecked }}>
                                                        Excesivas<br>
                                                        <strong>Total: {{ $actions['total'] }}</strong>
                                                    @else
                                                        <input type="checkbox" disabled checked>
                                                        Nunca<br>
                                                        <input type="checkbox" disabled>
                                                        Una vez<br>
                                                        <input type="checkbox" disabled>
                                                        Dos veces<br>
                                                        <input type="checkbox" disabled>
                                                        Tres veces<br>
                                                        <input type="checkbox" disabled>
                                                        Excesivas<br>
                                                        <strong>Total: 0</strong>
                                                    @endif
                                                </td>
                                            @endforeach
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
