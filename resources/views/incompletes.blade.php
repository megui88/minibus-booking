@extends('layouts.app')

@section('content')
    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="center-block">
                            Servicios Incompletos
                        </div>
                    </div>
                    <div class="panel-body" id="dashboard">
                        <div class="row">
                            <table class="table table-responsive table-striped  table-hover table-bordered">
                                <thead>
                                <tr class="thead-inverse">
                                    <th>Fecha</th>
                                    <th>Servicio</th>
                                    <th>Agencia</th>
                                    <th>Turno</th>
                                    <th>Hora</th>
                                    <th>Vehiculo</th>
                                    <th>Chofer</th>
                                    <th>Guía</th>
                                    <th>Pasajeros</th>
                                    <th>Tipo de viaje</th>
                                    <th>Peaje</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in incompletes" v-bind:class="{'danger': false == item.enabled, 'success': item.paying !== null}">
                                    <th scope="row">{! _moment(item.date).calendar(null, {
                                        sameDay: '[Hoy] DD MMMM',
                                        nextDay: '[Mañana], dddd DD',
                                        nextWeek: 'dddd DD',
                                        lastDay: '[Ayer], dddd DD',
                                        lastWeek: 'dddd DD',
                                        sameElse: 'dddd, DD MMMM'
                                        }).toString() !}</th>
                                    <td>{! routeName(item.route_id) !}</td>
                                    <td>{! agencyName(item.agency_id) !}</td>
                                    <td>{! item.turn !}</td>
                                    <td>{! item.hour !}</td>
                                    <td>{! vehicleName(item.vehicle_id) !}</td>
                                    <td>{! chauffeurName(item.chauffeur_id) !}</td>
                                    <td>{! item.courier !}</td>
                                    <td v-bind:class="{'danger': item.passengers < 1 }">{! item.passengers !}</td>
                                    <td v-bind:class="{'danger': item.type_trip_id == null }">{! typeTripName(item.type_trip_id) !}</td>
                                    <td v-bind:class="{'danger': item.tax < 1 }">{! item.tax !}</td>
                                    <td>
                                        <a @click="edit(item)">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <span>&nbsp;&nbsp;</span>
                                        <a v-if="item.enabled && item.paying == null" @click="disable(item.id)">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('modal_form_service')
    </div>
@endsection
@section('javascripts')
    <script type="application/javascript">
        app.__vue__.init();
        app.__vue__.getIncompletes();
    </script>
@endsection
