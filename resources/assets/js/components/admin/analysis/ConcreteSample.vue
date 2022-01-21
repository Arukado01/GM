<template>
    <div>
        <div id="accordion-concrete-samples" role="tablist" aria-multiselectable="true">
            <div class="card mb-0">
                <div class="card-header" role="tab" id="heading-samples">
                    <h5 class="mb-0">
                        <a data-toggle="collapse" data-parent="#accordion-concrete-samples" href="#collapse-samples"
                           aria-expanded="false"
                           aria-controls="collapseSamples">
                            Toma de muestras
                        </a>
                    </h5>
                </div>

                <div id="collapse-samples" class="collapse" role="tabpanel" aria-labelledby="heading-samples">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="" @click.prevent="showForm('sample-table')" class="btn"
                                   :class="{'btn-outline-primary': showTableContent, 'btn-outline-danger': showFormContent} ">
                                    <span v-if="showTableContent">
                                        <i class="fa fa-plus"></i> Agregar Muestra
                                    </span>
                                    <span v-else-if="showFormContent">
                                        <i class="fa fa-arrow-left"></i> Atrás
                                    </span>
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <h5>
                                    Fecha de Actualización
                                </h5>
                                {{ sample_concrete_update_format }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr class="divider">
                            </div>
                        </div>
                        <transition
                                enter-active-class="animated fadeIn"
                                leave-active-class="animated fadeOut"
                                mode="out-in"
                                v-on:after-leave="afterLeaveTable">
                            <div class="row" v-show="showTableContent">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="concrete-samples-table" class="table table-hover table-bordered"
                                                   cellspacing="0" style="width: 100% !important;">
                                                <thead>
                                                <tr>
                                                    <th rowspan="2">Fecha</th>
                                                    <th rowspan="2">Destino</th>
                                                    <th rowspan="2">Tipo</th>
                                                    <th rowspan="2">Muestra</th>
                                                    <th colspan="4">Ensayos Pendientes (Días)</th>
                                                    <th colspan="4">Validaciones Pendientes</th>
                                                    <th rowspan="2">Acciones</th>
                                                </tr>
                                                <tr>
                                                    <th>7</th>
                                                    <th>14</th>
                                                    <th>28</th>
                                                    <th>56</th>
                                                    <th>Testigo 56 Días</th>
                                                    <th>
                                                        <div class="tooltip-core">
                                                            <span class="tooltip-core-text-base">Esclerom...</span>
                                                            <span class="tooltiptext-core" data-placement="top">
                                                                Esclerometría
                                                            </span>
                                                        </div>
                                                    </th>
                                                    <th>Proveedor</th>
                                                    <th>Núcleos</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr>
                                            <h4>Observaciones</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p v-if="concreteSampleObservations.length <= 0">
                                                No hay observaciones disponibles
                                            </p>
                                            <div v-else>
                                                <blockquote class="blockquote"
                                                            v-for="concreteSampleObservation in concreteSampleObservations">
                                                    <p>{{ concreteSampleObservation.observations }}</p>
                                                    <hr>
                                                    <div class="text-right">
                                                        <a href="" class="btn btn-outline-danger"
                                                           @click.prevent="deleteConcreteSampleObservations(concreteSampleObservation)">
                                                            <i class="fa fa-trash"></i>
                                                            Eliminar
                                                        </a>
                                                        <a href="" class="btn btn-primary"
                                                           @click.prevent="editConcreteSampleObservations(concreteSampleObservation)">
                                                            <i class="fa fa-edit"></i>
                                                            Editar
                                                        </a>
                                                    </div>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea id="txt_observation_gen" cols="30" rows="10"
                                                          v-model="cnSmpObservation.observations"
                                                          placeholder="Escriba aquí sus observaciones"
                                                          class="form-control">
                                                </textarea>
                                                <div class="row">
                                                    <div class="col-md-6"
                                                         v-if="cnSmpObservation.observations !== null">
                                                        <a href=""
                                                           @click.prevent="cnSmpObservation = {hashid: null, observations: null}"
                                                           class="btn btn-outline-danger btn-block">
                                                            Cancelar
                                                        </a>
                                                    </div>
                                                    <div :class="[cnSmpObservation.observations === null ? 'col-md-12' : 'col-md-6']">
                                                        <a href="" @click.prevent="saveConcreteSampleObservation()"
                                                           class="btn btn-outline-primary btn-block">
                                                            Agregar observaciones generales Para las toma de muestras
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </transition>
                        <transition
                                enter-active-class="animated fadeIn"
                                leave-active-class="animated fadeOut"
                                mode="out-in"
                                v-on:after-leave="afterLeaveForm">
                            <div class="row" v-show="showFormContent">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            <div class="form-group">
                                                <div class="text-center date-select-content" v-if="!editSample">
                                                    <i class="fa fa-calendar"></i>
                                                    <date-picker :date="date" :option="option"></date-picker>
                                                </div>
                                                <label v-if="dateSelected != ''">
                                                    Fecha seleccionada: {{ dateSelected }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" :class="{'has-danger': errorDestination}">
                                                <label for="txt-destination">Destino</label>
                                                <input type="text" v-model="concreteSample.destination"
                                                       id="txt-destination"
                                                       class="form-control" v-if="!editSample">
                                                <p v-else>
                                                    {{ concreteSample.destination }}
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" :class="{'has-danger': errorType}">
                                                <label for="txt-type">Tipo</label>
                                                <input type="text" v-if="!editSample" v-model="concreteSample.type"
                                                       name="txt-type"
                                                       id="txt-type" class="form-control">
                                                <p v-else>
                                                    {{ concreteSample.type }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txt-sample">Muestra</label>
                                                <input type="text" v-if="!editSample" v-model="concreteSample.sample"
                                                       name="txt-sample"
                                                       id="txt-sample"
                                                       class="form-control">

                                                <p v-else>
                                                    {{ concreteSample.sample }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt-fc_seven_days">%. F'c 7 días</label>
                                                <input type="number" v-model="concreteSample.fc_seven_days" min="0"
                                                       name="txt-fc_seven_days" id="txt-fc_seven_days"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt-fc_fourteen_days">%. F'c 14 días</label>
                                                <input type="number" v-model="concreteSample.fc_fourteen_days" min="0"
                                                       name="txt-fc_fourteen_days" id="txt-fc_fourteen_days"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt-fc_twenty_eight_days">%. F'c 28 días</label>
                                                <input type="number" min="0" name="txt-fc_twenty_eight_days"
                                                       v-model="concreteSample.fc_twenty_eight_days"
                                                       id="txt-fc_twenty_eight_days"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt-fc_fifty_six_days">%. F'c 56 días</label>
                                                <input type="number" min="0" name="txt-fc_fifty_six_days"
                                                       v-model="concreteSample.fc_fifty_six_days"
                                                       id="txt-fc_fifty_six_days"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt-t_56_days">Testigo 56 Días</label>
                                                <textarea name="txt-t_56_days" id="txt-t_56_days"
                                                          v-model="concreteSample.t_56_days"
                                                          class="form-control" cols="30"
                                                          rows="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt-sclerometry">Esclerometria</label>
                                                <textarea name="txt-sclerometry" id="txt-sclerometry"
                                                          v-model="concreteSample.sclerometry"
                                                          class="form-control" cols="30"
                                                          rows="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt-provider">Proveedor</label>
                                                <textarea name="txt-provider" id="txt-provider"
                                                          v-model="concreteSample.provider"
                                                          class="form-control" cols="30"
                                                          rows="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt-cores">Núcleos</label>
                                                <textarea name="txt-cores" id="txt-cores"
                                                          v-model="concreteSample.cores"
                                                          class="form-control" cols="30"
                                                          rows="10"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <a href="" @click.prevent="saveConcreteSample" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Guardar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
            <div class="card mb-0">
                <div class="card-header" role="tab" id="headingTwo">
                    <h5 class="mb-0">
                        <a data-toggle="collapse" data-parent="#accordion-concrete-samples" href="#collapseTwo"
                           aria-expanded="false"
                           aria-controls="collapseTow">
                            Hallazgos en cantidad de cilindros tomados
                        </a>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="" @click.prevent="showFormVerify('verify-table')" class="btn"
                                   :class="{'btn-outline-primary': showTableContentVerify, 'btn-outline-danger': showFormContentVerify} ">
                                    <span v-if="showTableContentVerify">
                                        <i class="fa fa-plus"></i> Agregar Verificación
                                    </span>
                                    <span v-else-if="showFormContentVerify">
                                        <i class="fa fa-arrow-left"></i> Atrás
                                    </span>
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <h5>
                                    Fecha de Actualización
                                </h5>
                                {{ verify_concrete_update_format }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr class="divider">
                            </div>
                        </div>
                        <transition
                                enter-active-class="animated fadeIn"
                                leave-active-class="animated fadeOut"
                                mode="out-in"
                                v-on:after-leave="afterLeaveVerifyTable">
                            <div class="row" v-show="showTableContentVerify">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="concrete-quantity-test-table"
                                                   class="table table-hover table-bordered" style="width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Destino</th>
                                                    <th>M<sup>3</sup><br>Fundida</th>
                                                    <th>Cant. Muestras<br>Teóricas</th>
                                                    <th>Cant. Muestras<br>Tomadas</th>
                                                    <th>Observaciones</th>
                                                    <th>Acciones</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr>
                                            <h4>Observaciones</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p v-if="quantityConcreteSampleObservations.length <= 0">
                                                No hay observaciones disponibles
                                            </p>
                                            <div v-else>
                                                <blockquote class="blockquote"
                                                            v-for="quantityConcreteSampleObservation in quantityConcreteSampleObservations">
                                                    <p>{{ quantityConcreteSampleObservation.observation }}</p>
                                                    <hr>
                                                    <div class="text-right">
                                                        <a href=""
                                                           @click.prevent="deleteQuantityConcreteSampleObservation(quantityConcreteSampleObservation)"
                                                           class="btn btn-outline-danger">
                                                            <i class="fa fa-trash"></i>
                                                            Eliminar
                                                        </a>
                                                        <a href=""
                                                           @click.prevent="editQuantityConcreteSampleObservation(quantityConcreteSampleObservation)"
                                                           class="btn btn-primary">
                                                            <i class="fa fa-edit"></i>
                                                            Editar
                                                        </a>
                                                    </div>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea id="txt_quantity_observation_gen" cols="30" rows="10"
                                                          v-model="quantityGenObservation.observation"
                                                          placeholder="Escriba aquí sus observaciones"
                                                          class="form-control">
                                                </textarea>
                                                <div class="row">
                                                    <div class="col-md-6"
                                                         v-if="quantityGenObservation.observation !== null">
                                                        <a href=""
                                                           @click.prevent="quantityGenObservation = {hashid: null, observation: null}"
                                                           class="btn btn-outline-danger btn-block">
                                                            Cancelar
                                                        </a>
                                                    </div>
                                                    <div :class="[quantityGenObservation.observation === null ? 'col-md-12' : 'col-md-6']">
                                                        <a href=""
                                                           @click.prevent="saveQuantityConcreteSampleObservation()"
                                                           class="btn btn-outline-primary btn-block">
                                                            Agregar observaciones generales para verificación de ensayos
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition>
                        <transition
                                enter-active-class="animated fadeIn"
                                leave-active-class="animated fadeOut"
                                mode="out-in"
                                v-on:after-leave="afterLeaveVerifyForm">
                            <div class="row" v-show="showFormContentVerify">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            <div class="form-group">
                                                <div class="text-center date-select-content"
                                                     v-if="!editQuantityCheckSample">
                                                    <i class="fa fa-calendar"></i>
                                                    <date-picker :date="dateQuantity"
                                                                 :option="optionQuantity"></date-picker>
                                                </div>
                                                <label v-if="dateQuantitySelected != ''">
                                                    Fecha seleccionada: {{ dateQuantitySelected }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"
                                                 :class="{'has-danger': errorQuantityCheckSampleDestination}">
                                                <label for="txt_destination">Destino</label>
                                                <input type="text" id="txt_destination" class="form-control"
                                                       v-model="quantityCheckSample.destination"
                                                       v-if="!editQuantityCheckSample">
                                                <p v-else>
                                                    {{ quantityCheckSample.destination }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="txt_m3_fused">
                                                    M<sup>3</sup> Fundida
                                                </label>
                                                <input type="number" id="txt_m3_fused" class="form-control"
                                                       v-model="quantityCheckSample.m3_fused">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="txt_cant_theoretical_samples">
                                                    Cant. Muestras Teóricas
                                                </label>
                                                <input type="number" id="txt_cant_theoretical_samples"
                                                       class="form-control"
                                                       v-model="quantityCheckSample.cant_theoretical_samples">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="txt_cant_samples_taken">
                                                    Cant. Muestras Tomadas
                                                </label>
                                                <input type="number" id="txt_cant_samples_taken" class="form-control"
                                                       v-model="quantityCheckSample.cant_samples_taken">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txt_observations">Observaciones</label>
                                                <textarea id="txt_observations" cols="30" rows="10"
                                                          class="form-control"
                                                          v-model="quantityCheckSample.observation">
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr class="divider">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <a href="" @click.prevent="saveQuantityCheckSample" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Guardar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Config from './../../../admin_conf';
    import Datepicker from 'vue-datepicker';

    moment.locale('es');
    export default {
        components: {
            'date-picker': Datepicker,
        },
        props: {
            pSampleConcrete: String,
            pVerifyConcrete: String,
            urlDataConcreteSamples: String,
            urlDataConcreteQuantityTest: String,
            pProjectId: String,
            pIsAdmin: {
                type: Number
            }
        },
        data() {
            return {
                sample_concrete_update: '',
                sample_concrete_update_format: 'No se ha registrado ninguna fecha',
                verify_concrete_update: '',
                verify_concrete_update_format: 'No se ha registrado ninguna fecha',
                showTableContentVerify: true,
                showFormContentVerify: false,
                editSample: false,
                editQuantityCheckSample: false,
                showTableContent: true,
                showFormContent: false,
                dataTableConcreteSamples: null,
                dateSelected: '',
                dateSelectedNoFormat: '',
                concreteSample: {
                    hashid: null,
                    date: null,
                    destination: null,
                    type: null,
                    sample: null,
                    fc_seven_days: null,
                    fc_fourteen_days: null,
                    fc_twenty_eight_days: null,
                    fc_fifty_six_days: null,
                    sclerometry: null,
                    provider: null,
                    cores: null,
                    t_56_days: null,
                },
                errorDestination: false,
                errorType: false,
                errorQuantityCheckSampleDestination: false,
                cnSmpObservation: {
                    hashid: null,
                    observations: null
                },
                concreteSampleObservations: [],
                date: {
                    time: ''
                },
                dateQuantity: {
                    time: ''
                },
                dateQuantitySelected: '',
                dateQuantitySelectedNoFormat: '',
                quantityCheckSample: {
                    hashid: null,
                    date: null,
                    destination: null,
                    m3_fused: 0,
                    cant_theoretical_samples: 0,
                    cant_samples_taken: 0,
                    observation: null
                },
                editQuantitySample: false,
                quantityGenObservation: {
                    hashid: null,
                    observation: null
                },
                quantityConcreteSampleObservations: [],
                dateQuantityPlaceholder: 'Presiona aquí para seleccionar una fecha',
                option: {
                    type: 'day',
                    week: ['Lun', 'Mar', 'Míe', 'Jue', 'Vie', 'Sáb', 'Dom'],
                    month: [
                        'Enero',
                        'Febrero',
                        'Marzo',
                        'Abril',
                        'Mayo',
                        'Junio',
                        'Julio',
                        'Agosto',
                        'Septiembre',
                        'Octubre',
                        'Noviembre',
                        'Diciembre'
                    ],
                    format: 'YYYY-MM-DD',
                    placeholder: 'Presiona aquí para seleccionar una fecha',
                    color: {
                        header: '#5863cc',
                        headerText: '#fbf6ff'
                    },
                    buttons: {
                        ok: 'Ok',
                        cancel: 'Cancelar'
                    },
                    overlayOpacity: 0.5, // 0.5 as default
                    dismissible: false // as true as default
                },
                optionQuantity: {
                    type: 'day',
                    week: ['Lun', 'Mar', 'Míe', 'Jue', 'Vie', 'Sáb', 'Dom'],
                    month: [
                        'Enero',
                        'Febrero',
                        'Marzo',
                        'Abril',
                        'Mayo',
                        'Junio',
                        'Julio',
                        'Agosto',
                        'Septiembre',
                        'Octubre',
                        'Noviembre',
                        'Diciembre'
                    ],
                    format: 'YYYY-MM-DD',
                    placeholder: 'Presiona aquí para seleccionar una fecha',
                    color: {
                        header: '#5863cc',
                        headerText: '#fbf6ff'
                    },
                    buttons: {
                        ok: 'Ok',
                        cancel: 'Cancelar'
                    },
                    overlayOpacity: 0.5, // 0.5 as default
                    dismissible: false // as true as default
                },
                timeoption: {
                    type: 'min',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    format: 'YYYY-MM-DD HH:mm'
                },
            }
        },
        watch: {
            'date.time'(val) {
                if (val !== '') {
                    let date = moment(val);
                    this.dateSelectedNoFormat = val;
                    this.concreteSample.date = val;
                    this.option.placeholder = 'Cambiar fecha';
                    this.date.time = '';
                    this.dateSelected = date.format('MMMM DD [de] YYYY').capitalize();
                }
            },
            'dateQuantity.time'(val) {
                if (val !== '') {
                    let date = moment(val);
                    this.dateQuantitySelectedNoFormat = val;
                    this.quantityCheckSample.date = val;
                    this.optionQuantity.placeholder = 'Cambiar fecha';
                    this.dateQuantity.time = '';
                    this.dateQuantitySelected = date.format('MMMM DD [de] YYYY').capitalize();

                }
            },
            'quantityCheckSample.m3_fused'(val) {
                if (val === '')
                    this.quantityCheckSample.m3_fused = 0;
                this.quantityCheckSample.cant_theoretical_samples = Math.ceil(val / 40);
            },
            'quantityCheckSample.cant_samples_taken'(val) {
                if (val === '')
                    this.quantityCheckSample.cant_samples_taken = 0;
            },
            sample_concrete_update(val) {
                if (val !== '') {
                    let date = moment(val);
                    this.sample_concrete_update_format = this.$dateStringFormat(date);
                } else {
                    this.sample_concrete_update_format = 'No se ha registrado ninguna fecha';
                    this.sample_concrete_update = '';
                }
            },
            verify_concrete_update(val) {
                if (val !== '') {
                    let date = moment(val);
                    this.verify_concrete_update_format = this.$dateStringFormat(date);
                } else {
                    this.verify_concrete_update_format = 'No se ha registrado ninguna fecha';
                    this.verify_concrete_update = '';
                }
            }
        },
        mounted() {
            this.sample_concrete_update = this.pSampleConcrete;
            this.verify_concrete_update = this.pVerifyConcrete;
            this.loadConcreteSampleObservations();
            this.initDataTable();
            this.initConcreteVerifyTable();
            this.loadQuantityConcreteSampleObservation();
        },
        methods: {
            loadConcreteSampleObservations() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase + `/admin/project/${this.pProjectId}/concrete-sample-observations`;

                axios.get(url)
                    .then(resp => {
                        this.concreteSampleObservations = resp.data
                    })
                    .catch(resp => {
                        if (resp.status === 500)
                            toastr.error('Pedimos disculpas ha ocurrido un error interno<br>Por favor refresque la pagina.', 'Error!');
                    });
            },
            saveConcreteSampleObservation() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;
                if (this.cnSmpObservation.observations === null) {
                    toastr.error('El campo de observaciones no debe de estar vacío.', 'Error!!');
                    let el = $("#txt_observation_gen");
                    el.parent('.form-group').addClass('has-danger');
                    return false;
                }

                if (this.cnSmpObservation.hashid === null || this.cnSmpObservation.hashid === '') {
                    url += `/admin/project/${this.pProjectId}/concrete-sample-observations`;
                    axios.post(url, this.cnSmpObservation)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.cnSmpObservation = {
                                hashid: null,
                                observations: null
                            };
                            this.loadConcreteSampleObservations();
                        });
                } else {
                    url += `/admin/concrete-sample-observations/${this.cnSmpObservation.hashid}`;

                    axios.put(url, this.cnSmpObservation)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.cnSmpObservation = {
                                hashid: null,
                                observations: null
                            };

                            this.loadConcreteSampleObservations();
                        });
                }
            },
            editConcreteSampleObservations: function (obj) {
                this.cnSmpObservation.hashid = obj.hashid;
                this.cnSmpObservation.observations = obj.observations;

                let el = $("#txt_observation_gen");

                el.focus();
                $('html, body').stop().animate({
                    scrollTop: el.offset().top
                }, 900, 'swing');
            },
            deleteConcreteSampleObservations(obj) {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                url += `/admin/concrete-sample-observations/${obj.hashid}`;

                axios.delete(url)
                    .then(resp => {
                        toastr.success(resp.data.message, 'Mensaje!!');
                        this.cnSmpObservation = {
                            hashid: null,
                            observations: null
                        };
                        this.loadConcreteSampleObservations();
                    });
            },
            showForm(to) {
                this.$eventShowOverlay.$emit('show');
                if (this.showTableContent) {
                    this.showTableContent = false;
                } else if (this.showFormContent) {
                    this.showFormContent = false;
                    this.dateSelected = '';
                    this.option.placeholder = 'Presiona aquí para seleccionar una fecha';
                    this.dateSelectedNoFormat = '';
                    this.resetValues(this.concreteSample);
                    this.dataTableConcreteSamples.ajax.reload();
                }

                switch (to) {
                    case 'sample-table':
                        this.editSample = false;
                        break;
                }
            },
            deleteConcreteSample() {

            },
            saveConcreteSample() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                if (this.concreteSample.date === '' || this.concreteSample.date === null) {
                    toastr.error('Debe seleccionar una fecha para poder continuar.', 'Error!');
                    return false;
                } else if (this.concreteSample.destination === '' || this.concreteSample.destination === null) {
                    this.errorDestination = true;
                    toastr.error('Debe digitar el Destino para poder continuar.', 'Error!');
                    return false;
                } else if (this.concreteSample.type === '' || this.concreteSample.type === null) {
                    this.errorType = true;
                    toastr.error('Debe digitar el Tipo para poder continuar.', 'Error!');
                    return false;
                }

                if (this.concreteSample.hashid !== null && this.concreteSample.hashid !== '') {
                    url += `/admin/concrete-samples/${this.concreteSample.hashid}`;
                    axios.put(url, this.concreteSample)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Éxito!');
                            this.showForm();
                            this.sample_concrete_update = resp.data.last_update;
                            this.editSample = false;
                        });
                } else {
                    url += `/admin/project/${this.pProjectId}/concrete-samples`;
                    axios.post(url, this.concreteSample)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Éxito!');
                            this.showForm();
                            this.sample_concrete_update = resp.data.last_update;
                            this.editSample = false;
                        })
                }
            },
            resetValues(object) {
                this.$cleanObjectValues(object, 0);
            },
            initDataTable() {
                let vm = this;
                vm.dataTableConcreteSamples = $('#concrete-samples-table').DataTable({
                    language: Config.langDataTable,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: vm.urlDataConcreteSamples,
                        error(xhr) {
                            if (xhr.status === 500)
                                toastr.error('Pedimos disculpas ha ocurrido un error interno<br>Por favor refresque la pagina.', 'Error!');
                        }
                    },
                    drawCallback() {
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    initComplete() {
                        vm.$eventHideOverlay.$emit('hide');
                    },
                    fnDrawCallback() {
                        let buttons = document.getElementsByClassName('btn-edit-concrete-sample');
                        if (buttons) {
                            [...buttons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');
                                let tr = button.parentNode.parentElement.parentElement.parentElement;
                                let data = vm.dataTableConcreteSamples.row(tr).data();
                                console.log(url)
                                console.log(tr)
                                console.log(data.hashid)

                                vm.concreteSample.hashid = data.hashid;
                                vm.date.time = data.date;
                                vm.concreteSample.date = data.date;
                                vm.concreteSample.destination = data.destination_value;
                                vm.concreteSample.type = data.type;
                                vm.concreteSample.sample = data.sample;
                                vm.concreteSample.fc_seven_days = data.fc_seven_days_value;
                                vm.concreteSample.fc_fourteen_days = data.fc_fourteen_days_value;
                                vm.concreteSample.fc_twenty_eight_days = data.fc_twenty_eight_days_value;
                                vm.concreteSample.fc_fifty_six_days = data.fc_fifty_six_days_value;
                                vm.concreteSample.sclerometry = data.sclerometry_value ? data.sclerometry_value.replace(/&quot;/g, '"') : '';
                                vm.concreteSample.provider = data.provider_value ? data.provider_value.replace(/&quot;/g, '"') : '';
                                vm.concreteSample.cores = data.cores_value ? data.cores_value.replace(/&quot;/g, '"') : '';
                                vm.concreteSample.t_56_days = data.t_56_days_value ? data.t_56_days_value.replace(/&quot;/g, '"') : '';

                                if (!vm.pIsAdmin)
                                    vm.editSample = true;
                                vm.showForm();
                            }));
                        } else {
                            vm.dataTableConcreteSamples.column(8).visible(false);
                        }

                        let deleteButtons = document.getElementsByClassName('btn-delete-concrete-sample');
                        if (deleteButtons) {
                            [...deleteButtons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');
                                let tr = button.parentNode.parentElement.parentElement.parentElement;
                                let data = vm.dataTableConcreteSamples.row(tr).data();

                                vm.concreteSample.hashid = data.hashid;
                                axios.delete(url)
                                    .then(resp => {
                                        toastr.success(resp.data.message, 'Mensaje!');
                                        vm.dataTableConcreteSamples.ajax.reload();
                                    })
                            }));
                        }
                    },
                    columns: [
                        {data: 'date', name: 'date', orderable: false},
                        {data: 'destination', name: 'destination', orderable: false, searchable: false},
                        {data: 'type', name: 'type', orderable: false, searchable: false},
                        {data: 'sample', name: 'sample', orderable: false, searchable: false},
                        {
                            data: 'fc_seven_days',
                            name: 'fc_seven_days',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'fc_fourteen_days',
                            name: 'fc_fourteen_days',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'fc_twenty_eight_days',
                            name: 'fc_twenty_eight_days',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'fc_fifty_six_days',
                            name: 'fc_fifty_six_days',
                            orderable: false,
                            searchable: false,
                        },
                        {data: 't_56_days', name: 't_56_days', orderable: false, searchable: false},
                        {data: 'sclerometry', name: 'sclerometry', orderable: false, searchable: false},
                        {data: 'provider', name: 'provider', orderable: false, searchable: false},
                        {data: 'cores', name: 'cores', orderable: false, searchable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
            },
            afterLeaveTable() {
                this.showFormContent = true;
                this.$eventHideOverlay.$emit('hide');
            },
            afterLeaveForm() {
                this.showTableContent = true;
                this.$eventHideOverlay.$emit('hide');
            },
            /*--------- Verify Samples*/
            showFormVerify(to) {
                this.$eventShowOverlay.$emit('show');

                if (this.showTableContentVerify) {
                    this.showTableContentVerify = false;
                } else if (this.showFormContentVerify) {
                    this.showFormContentVerify = false;
                    this.dateQuantitySelected = '';
                    this.dateQuantitySelectedNoFormat = '';
                    this.optionQuantity.placeholder = 'Presiona aquí para seleccionar una fecha';
                    this.resetValues(this.quantityCheckSample);
                    this.dataTableConcreteQuantityTest.ajax.reload();
                }
            },
            afterLeaveVerifyTable() {
                this.showFormContentVerify = true;
                this.$eventHideOverlay.$emit('hide');
            },
            afterLeaveVerifyForm() {
                this.showTableContentVerify = true;
                this.$eventHideOverlay.$emit('hide');

            },
            initConcreteVerifyTable() {
                let vm = this;
                vm.dataTableConcreteQuantityTest = $('#concrete-quantity-test-table').DataTable({
                    language: Config.langDataTable,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: vm.urlDataConcreteQuantityTest,
                        error(xhr) {
                            if (xhr.status === 500)
                                toastr.error('Pedimos disculpas ha ocurrido un error interno<br>Por favor refresque la pagina.', 'Error!');
                        }
                    },
                    drawCallback() {
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    initComplete() {
                        vm.$eventHideOverlay.$emit('hide');
                    },
                    fnDrawCallback() {
                        let buttons = document.getElementsByClassName('btn-edit-quantity-test');
                        if (buttons) {
                            [...buttons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');
                                let tr = button.parentNode.parentElement.parentElement.parentElement;
                                let data = vm.dataTableConcreteQuantityTest.row(tr).data();

                                vm.quantityCheckSample.hashid = data.hashid;
                                vm.dateQuantity.time = data.date;
                                vm.quantityCheckSample.date = data.date;
                                vm.quantityCheckSample.destination = data.destination_value;
                                vm.quantityCheckSample.m3_fused = data.m3_fused;
                                vm.quantityCheckSample.cant_theoretical_samples = data.cant_theoretical_samples;
                                vm.quantityCheckSample.cant_samples_taken = data.cant_samples_taken;
                                vm.quantityCheckSample.observation = data.observation_value ? data.observation_value.replace(/&quot;/g, '"') : '';

                                if (!vm.pIsAdmin)
                                    vm.editQuantityCheckSample = true;

                                vm.showFormVerify();

                            }));
                        } else {
                            vm.dataTableConcreteQuantityTest.column(6).visible(false);
                        }

                        let deleteButtons = document.getElementsByClassName('btn-delete-quantity-test');
                        if (deleteButtons) {
                            [...deleteButtons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');
                                let tr = button.parentNode.parentElement.parentElement.parentElement;
                                let data = vm.dataTableConcreteQuantityTest.row(tr).data();

                                vm.quantityCheckSample.hashid = data.hashid;

                                axios.delete(url)
                                    .then(resp => {
                                        toastr.success(resp.data.message, 'Mensaje!');
                                        vm.dataTableConcreteQuantityTest.ajax.reload();
                                    });

                            }));
                        }
                    },
                    columns: [
                        {data: 'date', name: 'date', orderable: false},
                        {data: 'destination', name: 'destination', orderable: false, searchable: false, width: '100%'},
                        {data: 'm3_fused', name: 'm3_fused', orderable: false, searchable: false},
                        {
                            data: 'cant_theoretical_samples',
                            name: 'cant_theoretical_samples',
                            orderable: false,
                            searchable: false,
                            width: "10%"
                        },
                        {
                            data: 'cant_samples_taken',
                            name: 'cant_samples_taken',
                            orderable: false,
                            searchable: false,
                            width: "10%"
                        },
                        {data: 'observation', name: 'observation', orderable: false, searchable: false, width: '25%'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
            },
            saveQuantityCheckSample() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                if (this.quantityCheckSample.date === '' || this.quantityCheckSample.date === null) {
                    toastr.error('Debe seleccionar una fecha para poder continuar.', 'Error!');
                    return false;
                } else if (this.quantityCheckSample.destination === '' || this.quantityCheckSample.destination === null) {
                    this.errorQuantityCheckSampleDestination = true;
                    toastr.error('Debe digitar el Destino para poder continuar.', 'Error!');
                    return false;
                }

                if (this.quantityCheckSample.hashid === null) {
                    url += `/admin/project/${this.pProjectId}/quantity-check-test`;
                    axios.post(url, this.quantityCheckSample)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.verify_concrete_update = resp.data.last_update;
                            this.showFormVerify();
                        });
                } else {
                    url += `/admin/quantity-check-test/${this.quantityCheckSample.hashid}`;
                    axios.put(url, this.quantityCheckSample)
                        .then(resp => {
                            toastr.success(resp.data.message);
                            this.verify_concrete_update = resp.data.last_update;
                            this.showFormVerify();
                        });
                }
            },
            loadQuantityConcreteSampleObservation() {
                let url = Config.adminUrlBase() + Config.adminApiUrlBase
                    + `/admin/project/${this.pProjectId}/quantity-concrete-sample-observations`;

                axios.get(url)
                    .then(resp => {
                        this.quantityConcreteSampleObservations = resp.data
                    })
                    .catch(resp => {
                        if (resp.status === 500)
                            toastr.error('Pedimos disculpas ha ocurrido un error interno<br>Por favor refresque la pagina.', 'Error!');

                    });
            },
            saveQuantityConcreteSampleObservation() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                if (this.quantityGenObservation.observation === null) {
                    toastr.error('El campo de observaciones no debe de estar vacío.', 'Error!!');
                    let el = $("#txt_quantity_observation_gen");
                    el.parent('.form-group').addClass('has-danger');
                    return false;
                }

                if (this.quantityGenObservation.hashid === null) {
                    url += `/admin/project/${this.pProjectId}/quantity-concrete-sample-observations`;

                    axios.post(url, this.quantityGenObservation)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.quantityGenObservation = {
                                hashid: null,
                                observation: null
                            };
                            this.loadQuantityConcreteSampleObservation();
                        });
                } else {
                    url += `/admin/quantity-concrete-sample-observations/${this.quantityGenObservation.hashid}`;

                    axios.put(url, this.quantityGenObservation)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.quantityGenObservation = {
                                hashid: null,
                                observation: null
                            };
                            this.loadQuantityConcreteSampleObservation();
                        });
                }
            },
            editQuantityConcreteSampleObservation(obj) {
                this.quantityGenObservation = obj;

                let el = $("#txt_quantity_observation_gen");
                el.focus();
                $('html, body').stop().animate({
                    scrollTop: el.offset().top
                }, 900, 'swing');
            },
            deleteQuantityConcreteSampleObservation(obj) {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                url += `/admin/quantity-concrete-sample-observations/${obj.hashid}`;

                axios.delete(url)
                    .then(resp => {
                        toastr.success(resp.data.message, 'Mensaje!!');
                        this.quantityGenObservation = {
                            hashid: null,
                            observations: null
                        };
                        this.loadQuantityConcreteSampleObservation();
                    });
            },
        }
    }
</script>