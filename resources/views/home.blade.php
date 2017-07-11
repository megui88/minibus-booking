@extends('layouts.app')

@section('content')
    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="center-block">
                            Dashboard <a @click="goToday()">ir a Hoy</a><br>
                            <a @click="createService()" role="button" class="btn btn-primary">Crear servicio</a>
                        </div>
                    </div>
                    <div class="panel-body" id="dashboard">
                        <div class="row">
                            <div class="col-lg-2">
                                <h3><a @click="lastDay()">
                                        <span class="glyphicon glyphicon-chevron-left"
                                              aria-hidden="true"></span>
                                        {! day.clone().add(-1,
                                        'day').calendar(null, {
                                        sameDay: '[Hoy]',
                                        nextDay: '[Mañana]',
                                        nextWeek: 'dddd',
                                        lastDay: '[Ayer]',
                                        lastWeek: 'dddd [pasado]',
                                        sameElse: 'DD/MM'
                                        }).toString() !}
                                    </a>
                                </h3>
                            </div>
                            <div class="col-lg-8" style="text-transform:capitalize;">
                                <h1>{! day.calendar(null, {
                                    sameDay: '[Hoy] DD MMMM',
                                    nextDay: '[Mañana], dddd DD',
                                    nextWeek: 'dddd DD',
                                    lastDay: '[Ayer], dddd DD',
                                    lastWeek: 'dddd DD',
                                    sameElse: 'dddd, DD MMMM'
                                    }).toString() !}</h1>
                            </div>
                            <div class="col-lg-2">
                                <h3><a @click="nextDay()">
                                        {! day.clone().add(1, 'day').calendar(null, {
                                        sameDay: '[Hoy]',
                                        nextDay: '[Mañana]',
                                        nextWeek: 'dddd',
                                        lastDay: '[Ayer]',
                                        lastWeek: 'dddd [pasado]',
                                        sameElse: 'DD/MM'
                                        }).toString() !}
                                        <span class="glyphicon glyphicon-chevron-right"
                                              aria-hidden="true"></span>
                                    </a>
                                </h3>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-responsive table-striped  table-hover table-bordered">
                                <thead>
                                <tr class="thead-inverse">
                                    <th>#</th>
                                    <th>Servicio</th>
                                    <th>Agencia</th>
                                    <th>Turno</th>
                                    <th>Hora</th>
                                    <th>Vehiculo</th>
                                    <th>Chofer</th>
                                    <th>Guía</th>
                                    <th>Pasajeros</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in services" @click="edit(item)">
                                    <th scope="row">{! item.id !}</th>
                                    <td>{! routeName(item.route_id) !}</td>
                                    <td>{! agencyName(item.agency_id) !}</td>
                                    <td>{! item.turn !}</td>
                                    <td>{! item.hour !}</td>
                                    <td>{! vehicleName(item.vehicle_id) !}</td>
                                    <td>{! chauffeurName(item.chauffeur_id) !}</td>
                                    <td>{! item.courier !}</td>
                                    <td>{! item.passengers !}</td>
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
    </script>
@endsection
