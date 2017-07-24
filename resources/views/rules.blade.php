@extends('layouts.app')

@section('content')
    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="center-block">
                            Configuración
                        </div>
                    </div>
                    <div class="panel-body" id="settings">
                        <div class="row">
                            <h2>Reglas</h2>
                            <table class="table table-responsive table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Agencia</th>
                                    <th>Turno</th>
                                    <th>Recorrido</th>
                                    <th>Tipo de Viaje</th>
                                    <th>Num. Pax</th>
                                    <th>Valor del servicio</th>
                                    <th>Prioridad</th>
                                    <th><a @click="formRule()">Agregar</a></th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                <tr v-for="rule in rules">
                                    <th>{! rule.id !}</th>
                                    <td>{! agencyName(rule.agency_id) !}</td>
                                    <td>{! rule.turn !}</td>
                                    <td>{! routeName(rule.route_id) !}</td>
                                    <td>{! typeTripName(rule.type_trip_id) !}</td>
                                    <td>{! rule.number_passengers !}</td>
                                    <td>{! rule.price !}</td>
                                    <td>{! rule.priority !}</td>
                                    <td><a @click="formRule(rule)" class="btn"><span
                                                    class="glyphicon glyphicon-pencil"></span></a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('modal_form_rules')
    </div>
@endsection

@section('javascripts')
    <script type="application/javascript">
        app.__vue__.init();
    </script>
@endsection