<!-- Modal -->
<div class="modal fade" id="formSetting" tabindex="-1" role="dialog" aria-labelledby="formSettingLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="formSettingLabel">Configuracíon</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <input type="hidden" class="form-control" id="id" v-model="model.setting.id">

                    <div class="form-group form-group-sm" id="container_name">
                        <label class="col-sm-6 control-label" for="name">Nombre</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="name"
                                   v-model="model.setting.name"/>
                        </div>
                    </div>

                    <div class="form-group form-group-sm" id="container_number_passengers" v-if="model.entity_type == 'types_trip'">
                        <label class="col-sm-6 control-label" for="number_passengers">Numero de Pasajeros</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="number_passengers"
                                   v-model="model.setting.number_passengers"/>
                        </div>
                    </div>

                    <div class="form-group form-group-sm" id="container_chauffeur" v-if="model.entity_type == 'vehicles'">
                        <label class="col-sm-6 control-label" for="chauffeur">Chofer</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="chauffeur" v-model="model.setting.chauffeur_id">
                                <option>Seleccionar uno</option>
                                <option v-for="chauffeur in chauffeurs" v-bind:value='chauffeur.id'>{! chauffeur.name !}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button @click="doneFormSetting()" type="button" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>