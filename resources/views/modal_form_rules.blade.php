<!-- Modal -->
<div class="modal fade" id="formRule" tabindex="-1" role="dialog" aria-labelledby="formRuleLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="formRuleLabel">Regla de agencia</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <input type="hidden" class="form-control" id="id" v-model="model.rule.id">

                    <div class="form-group form-group-sm" id="container_agency_id">
                        <label class="col-sm-6 control-label" for="agency">Agencia</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="agency" v-model="model.rule.agency_id">
                                <option value="ANY">Cualquiera</option>
                                <option v-for="agency in agencies" v-bind:value='agency.id'>{! agency.name !}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-sm" id="container_turn">
                        <label class="col-sm-6 control-label" for="turn">Turno</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="turn" v-model="model.rule.turn">
                                <option value="ANY">Cualquiera</option>
                                <option>AM</option>
                                <option>PM</option>
                                <option>NOCHE</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-sm" id="container_route_id">
                        <label class="col-sm-6 control-label" for="route">Servicio</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="route" v-model="model.rule.route_id">
                                <option value="ANY">Cualquiera</option>
                                <option v-for="route in routes" v-bind:value='route.id'>{! route.name !}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-sm" id="container_type_trip_id">
                        <label class="col-sm-6 control-label" for="type_trip">Tipo de viaje</label>
                        <div class="col-sm-6">

                            <select class="form-control" id="type_trip" v-model="model.rule.type_trip_id">
                                <option value="ANY">Cualquiera</option>
                                <option v-for="type_trip in types_trips" v-bind:value='type_trip.id'>{! type_trip.name !}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-sm" id="container_number_passengers">
                        <label class="col-sm-6 control-label" for="passengers">Pasajeros</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="passengers"
                                   v-model="model.rule.number_passengers"/>
                            <strong>(*)</strong> <small>(0) cero = cualquier cantidad</small>
                        </div>
                    </div>
                    <div class="form-group form-group-sm" id="container_price">
                        <label class="col-sm-6 control-label" for="price">Valor del servicio</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="price"
                                   v-model="model.rule.price"/>
                        </div>
                    </div>
                    <div class="form-group form-group-sm" id="container_priority">
                        <label class="col-sm-6 control-label" for="priority">Prioridad</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="priority"
                                   v-model="model.rule.priority"/>
                            <strong>(*)</strong> <small>(0) cero = prioridad maxima</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button @click="doneFormRule()" type="button" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>