@extends('layouts.app')

@section('content')
    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="center-block">
                            Liquidaciones
                        </div>
                    </div>
                    <div class="panel-body" id="settings">
                        <div class="row">
                            <h2>Liquidaciones</h2>
                            <table class="table table-responsive table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Agencia</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                    <th>Servicios</th>
                                    <th>Total</th>
                                    <th><a @click="formLiquidation()">Nueva</a></th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                <tr v-for="liquidation in liquidations">
                                    <th>{! liquidation.id !}</th>
                                    <td>{! agencyName(liquidation.agency_id) !}</td>
                                    <td>{! liquidation.date_init !}</td>
                                    <td>{! liquidation.date_end !}</td>
                                    <td>{! liquidation.services.length !}</td>
                                    <td>{! liquidation.total !}</td>
                                    <td><a @click="deleteLiquidation(liquidation)" class="btn"><span
                                                    class="glyphicon glyphicon-remove"></span></a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('modal_form_liquidation')
    </div>
@endsection

@section('javascripts')
    <script type="application/javascript">
        app.__vue__.init();
        app.__vue__.loadLiquidations();
    </script>
@endsection