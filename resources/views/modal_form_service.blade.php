<!-- Modal -->
<div class="modal fade" id="formService" tabindex="-1" role="dialog" aria-labelledby="formServiceLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="formServiceLabel">Servicio</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="alert alert-warning" role="alert" v-if="'' !== formServiceMessage">
                        <strong>Atención!</strong> {!  formServiceMessage !}
                    </div>
                    <input type="hidden" class="form-control" id="id" v-model="model.service.id">

                    <div class="form-group form-group-sm" v-if="model.service.id === null">
                        <label class="col-sm-6 control-label" for="number_services">Cantidad de
                            servicios</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="number_services"
                                   v-model="model.number">
                        </div>
                    </div>
                    <div class="form-group form-group-sm" v-if="model.service.id === null">
                        <label class="col-sm-6 control-label" for="date_services">Fecha del servicio</label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control" id="date_services"
                                   v-model="model.service.date" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group form-group-sm" id="container_agency_id">
                        <label class="col-sm-6 control-label" for="agency">Agencia</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="agency" v-model="model.service.agency_id">
                                <option value="">Seleccionar uno</option>
                                <option v-for="agency in agencies" v-bind:value='agency.id'>{! agency.name !}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-sm" id="container_turn">
                        <label class="col-sm-6 control-label" for="turn">Turno</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="turn" v-model="model.service.turn">
                                <option value="">Seleccionar uno</option>
                                <option>AM</option>
                                <option>PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-sm" id="container_route_id">
                        <label class="col-sm-6 control-label" for="route">Servicio</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="route" v-model="model.service.route_id">
                                <option value="">Seleccionar uno</option>
                                <option v-for="route in routes" v-bind:value='route.id'>{! route.name !}</option>
                            </select>
                        </div>
                    </div>
                    <div v-if="model.service.id !== null">
                        <div class="form-group form-group-sm" id="container_vehicle_id">
                            <label class="col-sm-6 control-label" for="vehicle">Vehiculo</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="vehicle" v-model="model.service.vehicle_id">
                                    <option value="">Seleccionar uno</option>
                                    <option v-for="vehicle in vehicles" v-bind:value='vehicle.id'>{! vehicle.name !}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-sm" id="container_chauffeur_id">
                            <label class="col-sm-6 control-label" for="chauffeur">Chofer</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="chauffeur" v-model="model.service.chauffeur_id">
                                    <option value="">Seleccionar uno</option>
                                    <option v-for="chauffeur in chauffeurs" v-bind:value='chauffeur.id'>{! chauffeur.name !}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-group-sm" id="container_courier">
                            <label class="col-sm-6 control-label" for="courier">Guía</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="courier"
                                       v-model="model.service.courier"/>
                            </div>
                        </div>
                        <div class="form-group form-group-sm" id="container_passengers">
                            <label class="col-sm-6 control-label" for="passengers">Pasajeros</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="passengers"
                                       v-model="model.service.passengers"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm" id="container_hour">
                        <label class="col-sm-6 control-label" for="hour">Hora</label>
                        <div class="col-sm-6">
                            <input type="time" class="form-control" id="hour"
                                   v-model="model.service.hour"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button @click="doneForm()" type="button" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>