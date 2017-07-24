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
                            <div class="col-sm-4">
                                <div class="row">
                                    <h2>Choferes</h2>
                                    <table class="table table-responsive table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th><a @click="formSetting('chauffeurs')">Agregar</a></th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-left">
                                        <tr v-for="chauffeur in chauffeurs">
                                            <th>{! chauffeur.id !}</th>
                                            <td>{! chauffeur.name !}</td>
                                            <td><a @click="formSetting('chauffeurs', chauffeur)" class="btn"><span
                                                            class="glyphicon glyphicon-pencil"></span></a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <h2>Agencias</h2>
                                    <table class="table table-responsive table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th><a @click="formSetting('agencies')">Agregar</a></th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-left">
                                        <tr v-for="agency in agencies">
                                            <th>{! agency.id !}</th>
                                            <td>{! agency.name !}</td>
                                            <td><a @click="formSetting('agencies', agency)" class="btn"><span
                                                            class="glyphicon glyphicon-pencil"></span></a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2>Vehiculos</h2>
                                        <table class="table table-responsive table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Asignado a</th>
                                                <th><a @click="formSetting('vehicles')">Agregar</a></th>
                                            </tr>
                                            </thead>
                                            <tbody class="text-left">
                                            <tr v-for="vehicle in vehicles">
                                                <th>{! vehicle.id !}</th>
                                                <td>{! vehicle.name !}</td>
                                                <td>{! chauffeurName(vehicle.chauffeur_id) !}</td>
                                                <td><a @click="formSetting('vehicles', vehicle)" class="btn"><span
                                                                class="glyphicon glyphicon-pencil"></span></a></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h2>Tipos de Viajes</h2>
                                        <table class="table table-responsive table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th><a @click="formSetting('types_trips')">Agregar</a></th>
                                            </tr>
                                            </thead>
                                            <tbody class="text-left">
                                            <tr v-for="type in types_trips">
                                                <th>{! type.id !}</th>
                                                <td>{! type.name !}</td>
                                                <td><a @click="formSetting('types_trips', type)" class="btn"><span
                                                                class="glyphicon glyphicon-pencil"></span></a></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-sm-6">
                                        <h2>Servicios</h2>
                                        <table class="table table-responsive table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th><a @click="formSetting('routes')">Agregar</a></th>
                                            </tr>
                                            </thead>
                                            <tbody class="text-left">
                                            <tr v-for="route in routes">
                                                <th>{! route.id !}</th>
                                                <td>{! route.name !}</td>
                                                <td><a @click="formSetting('routes', route)" class="btn"><span
                                                                class="glyphicon glyphicon-pencil"></span></a></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('modal_form_settings')
    </div>
@endsection

@section('javascripts')
    <script type="application/javascript">
        app.__vue__.init();
    </script>
@endsection