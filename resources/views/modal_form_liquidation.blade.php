<!-- Modal -->
<div class="modal fade" id="formLiquidation" tabindex="-1" role="dialog" aria-labelledby="formLiquidationLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="formLiquidationLabel">Regla de agencia</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="alert alert-warning" role="alert" v-if="'' !== formLiquidationMessage">
                        <strong>Atención!</strong> {! formLiquidationMessage !}
                    </div>
                    <div class="form-group form-group-sm" id="container_agency_id">
                        <label class="col-sm-6 control-label" for="agency">Agencia</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="agency" v-model="model.liquidation.agency_id">
                                <option value=null>Seleccione una agencia</option>
                                <option v-for="agency in agencies" v-bind:value='agency.id'>{! agency.name !}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-sm" id="container_date_init">
                        <label class="col-sm-6 control-label" for="date_init">Desde</label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control" id="date_init" v-model="model.liquidation.date_init">
                        </div>
                    </div>
                    <div class="form-group form-group-sm" id="container_date_end">
                        <label class="col-sm-6 control-label" for="date_end">Hasta</label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control" id="date_end" v-model="model.liquidation.date_end">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button @click="doneFormLiquidation()" type="button" class="btn btn-primary">Liquidar</button>
                </div>
            </div>
        </div>
    </div>
</div>