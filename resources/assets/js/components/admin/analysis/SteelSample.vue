<template>
    <div>
        <div id="accordion-steel-samples" role="tablist" aria-multiselectable="true">
            <!--<div class="card mb-0">
                <div class="card-header" role="tab" id="heading-samples">
                    <h5 class="mb-0">
                        <a data-toggle="collapse" data-parent="#accordion-steel-samples" href="#collapse-steel-samples"
                           aria-expanded="false"
                           aria-controls="collapseSamples">
                            Toma de muestras
                        </a>
                    </h5>
                </div>

                <div id="collapse-steel-samples" class="collapse" role="tabpanel" aria-labelledby="heading-samples">
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
                                {{ sample_steel_update_format }}
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
                                            <table id="steel-samples-table" class="table table-hover table-bordered"
                                                   style="width: 100% !important;" cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Uso</th>
                                                    <th>Tipo</th>
                                                    <th>Fy [MPa]</th>
                                                    <th>Fu [MPa]</th>
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
                                            <p v-if="steelSampleObservationsData.length <= 0">
                                                No hay observaciones disponibles
                                            </p>
                                            <div v-else>
                                                <blockquote class="blockquote"
                                                            v-for="steelSampleObservation in steelSampleObservationsData">
                                                    <p>{{ steelSampleObservation.observations }}</p>
                                                    <hr>
                                                    <div class="text-right">
                                                        <a href="" class="btn btn-outline-danger"
                                                           @click.prevent="deleteSteelSampleObservations(steelSampleObservation)">
                                                            <i class="fa fa-trash"></i>
                                                            Eliminar
                                                        </a>
                                                        <a href="" class="btn btn-primary"
                                                           @click.prevent="editSteelSampleObservations(steelSampleObservation)">
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
                                                <textarea id="txt_steel_sample_observations" cols="30" rows="10"
                                                          v-model="steelSampleObservations.observations"
                                                          placeholder="Escriba aquí sus observaciones"
                                                          class="form-control">
                                                </textarea>
                                                <div class="row">
                                                    <div class="col-md-6"
                                                         v-if="steelSampleObservations.observations !== null || ''">
                                                        <a href=""
                                                           @click.prevent="steelSampleObservations = {hashid: null, observations: null}"
                                                           class="btn btn-outline-danger btn-block">
                                                            Cancelar
                                                        </a>
                                                    </div>
                                                    <div :class="[steelSampleObservations.observations === null ? 'col-md-12' : 'col-md-6']">
                                                        <a href="" @click.prevent="saveSteelSampleObservation()"
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
                                            <div class="form-group" :class="{'has-danger': steelSampleErrors.use}">
                                                <label for="txt-use">Uso</label>
                                                <input type="text" v-model="steelSample.use"
                                                       id="txt-use"
                                                       class="form-control" v-if="!editSample">
                                                <p v-else>
                                                    {{ steelSample.use }}
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group" :class="{'has-danger': steelSampleErrors.type}">
                                                <label for="txt-type">Tipo</label>
                                                <input type="text" v-if="!editSample" v-model="steelSample.type"
                                                       name="txt-type"
                                                       id="txt-type" class="form-control">
                                                <p v-else>
                                                    {{ steelSample.type }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="txt-fy_mpa">Fy [MPa]</label>
                                                <input type="number" min="0" name="txt-fy_mpa"
                                                       v-model="steelSample.fy_mpa"
                                                       id="txt-fy_mpa"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="txt-fu_mpa">Fu [MPa]</label>
                                                <input type="number" min="0" name="txt-fu_mpa"
                                                       v-model="steelSample.fu_mpa"
                                                       id="txt-fu_mpa"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txt-observations">Observaciones</label>
                                                <textarea name="txt-observations" id="txt-observations"
                                                          v-model="steelSample.observations"
                                                          class="form-control" cols="30"
                                                          rows="10"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <a href="" @click.prevent="saveSteelSample" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Guardar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>-->
            <div class="card mb-0">
                <div class="card-header" role="tab" id="heading-steel-quantity">
                    <h5 class="mb-0">
                        <a data-toggle="collapse" data-parent="#accordion-steel-samples" href="#collapse-steel-quantity"
                           aria-expanded="false"
                           aria-controls="collapseTow">
                            ENSAYOS TRACCIÓN ACERO
                        </a>
                    </h5>
                </div>
                <div id="collapse-steel-quantity" class="collapse show" role="tabpanel"
                     aria-labelledby="heading-steel-quantity">
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
                                {{ verify_steel_update_format }}
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
                                            <table id="steel-quantity-sample-table"
                                                   class="table table-hover table-bordered"
                                                   style="" cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <th>ZONA</th>
                                                    <th>Área Aprox.<br>[m<sup>2</sup>]</th>
                                                    <th>Consumo Aprox. <br>[Ton]</th>
                                                    <th>%Avance Aprox. Estructura</th>
                                                    <th>Ensayos Teóricos.<br>(c/50Tn)</th>
                                                    <th>Ensayos Ejecutados</th>
                                                    <th>Ensayos <br>por Validar</th>
                                                    <th>Acciones</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th colspan="4" style="text-align:right">Total:</th>
                                                    <th class="text-center text-bold"></th>
                                                    <th class="text-center text-bold"></th>
                                                    <th class="text-center text-bold"></th>
                                                </tr>
                                                </tfoot>
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
                                            <p v-if="quantityCheckSampleObservationsData.length <= 0">
                                                No hay observaciones disponibles
                                            </p>
                                            <div v-else>
                                                <blockquote class="blockquote"
                                                            v-for="quantityCheckSampleObservation in quantityCheckSampleObservationsData">
                                                    <p>{{ quantityCheckSampleObservation.observations }}</p>
                                                    <hr>
                                                    <div class="text-right">
                                                        <a href=""
                                                           @click.prevent="deleteQuantitySteelSampleObservation(quantityCheckSampleObservation)"
                                                           class="btn btn-outline-danger">
                                                            <i class="fa fa-trash"></i>
                                                            Eliminar
                                                        </a>

                                                        <a href=""
                                                           @click.prevent="editQuantitySteelSampleObservation(quantityCheckSampleObservation)"
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
                                                <textarea id="txt_quantity_check_sample_observations" cols="30"
                                                          rows="10"
                                                          v-model="quantityCheckSampleObservation.observations"
                                                          placeholder="Escriba aquí sus observaciones"
                                                          class="form-control">
                                                </textarea>
                                                <div class="row">
                                                    <div class="col-md-6"
                                                         v-if="quantityCheckSampleObservation.observations !== null">
                                                        <a href=""
                                                           @click.prevent="quantityCheckSampleObservation = {hashid: null, observations: null}"
                                                           class="btn btn-outline-danger btn-block">
                                                            Cancelar
                                                        </a>
                                                    </div>
                                                    <div :class="[quantityCheckSampleObservation.observations === null ? 'col-md-12' : 'col-md-6']">
                                                        <a href=""
                                                           @click.prevent="saveQuantityCheckSampleObservation()"
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
                                        <div class="col-md-6">
                                            <div class="form-group"
                                                 :class="{'has-danger': quantityCheckSampleErrors.zone}">
                                                <label for="txt_quantity_check_sample_zone">Zona</label>
                                                <input type="text" id="txt_quantity_check_sample_zone"
                                                       class="form-control"
                                                       v-model="quantityCheckSample.zone"
                                                       v-if="!editQuantityCheckSample">
                                                <p v-else>
                                                    {{ quantityCheckSample.zone }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"
                                                 :class="{'has-danger': quantityCheckSampleErrors.approx_area}">
                                                <label for="txt_approx_area">Area Aproximada [m<sup>2</sup>]</label>
                                                <input type="text" id="txt_approx_area" class="form-control"
                                                       v-model="quantityCheckSample.approx_area"
                                                       v-if="!editQuantityCheckSample">
                                                <p v-else>
                                                    {{ quantityCheckSample.approx_area }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt_approx_intake">
                                                    Consumo Aproximado [Ton]
                                                </label>
                                                <input type="number" id="txt_approx_intake" class="form-control"
                                                       v-model="quantityCheckSample.approx_intake">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt_cant_theoretical_sample">
                                                    Cant. Ensayos Teóricos (c/50Tn)
                                                </label>
                                                <input type="number" id="txt_cant_theoretical_sample"
                                                       class="form-control"
                                                       v-model="quantityCheckSample.cant_theoretical_sample">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt_percent_approx_advance">
                                                    % Avance Aproximado
                                                </label>
                                                <input type="number" id="txt_percent_approx_advance"
                                                       class="form-control"
                                                       v-model="quantityCheckSample.percent_approx_advance">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt_test_performed">
                                                    Cant. Ensayos ejecutados
                                                </label>
                                                <input type="number" id="txt_test_performed"
                                                       class="form-control"
                                                       v-model="quantityCheckSample.test_performed">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txt_test_performed">
                                                    Ensayos pendientes por validación
                                                </label>
                                                <input type="number" id="txt_pending_test_validation"
                                                       class="form-control"
                                                       v-model="quantityCheckSample.pending_test_validation">
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
            pSampleSteel: String,
            pVerifySteel: String,
            urlDataSteelSamples: String,
            urlDataSteelQuantitySample: String,
            pProjectId: String,
            pIsAdmin: {
                type: Number
            }
        },
        data() {
            return {
                sample_steel_update: '',
                sample_steel_update_format: 'No se ha registrado ninguna fecha',
                verify_steel_update: '',
                verify_steel_update_format: 'No se ha registrado ninguna fecha',
                showTableContentVerify: true,
                showFormContentVerify: false,
                editSample: false,
                editQuantityCheckSample: false,
                showTableContent: true,
                showFormContent: false,
                dataTableSteelSamples: null,
                dateSelected: '',
                dateSelectedNoFormat: '',
                steelSample: {
                    hashid: null,
                    date: null,
                    use: null,
                    type: null,
                    fy_mpa: null,
                    fu_mpa: null,
                    observations: null,
                },
                steelSampleErrors: {
                    use: false,
                    type: false,
                },
                steelSampleObservations: {
                    hashid: null,
                    observations: null
                },
                steelSampleObservationsData: [],
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
                    zone: null,
                    approx_area: null,
                    approx_intake: 0,
                    cant_theoretical_sample: 0,
                    percent_approx_advance: 0,
                    test_performed: 0,
                    pending_test_validation: 0
                },
                quantityCheckSampleErrors: {
                    zone: false,
                    approx_area: false
                },
                editQuantitySample: false,
                quantityCheckSampleObservation: {
                    hashid: null,
                    observations: null,
                    quantity_check_type: 'steel'
                },
                quantityCheckSampleObservationsData: [],
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
                    this.steelSample.date = val;
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
            'steelSampleObservations.observations'(val) {
                if (val === '')
                    this.steelSampleObservations.observations = null;
            },
            'quantityCheckSample.approx_intake'(val) {
                if (val === '')
                    this.quantityCheckSample.approx_intake = 0;
                this.quantityCheckSample.cant_theoretical_sample = Math.ceil(val / 50);
            },
            'quantityCheckSample.percent_approx_advance'(val) {
                if (val === '')
                    this.quantityCheckSample.percent_approx_advance = 0;
            },
            'quantityCheckSampleObservation.observations'(val) {
                if (val === '')
                    this.quantityCheckSampleObservation.observations = null;
            },
            sample_steel_update(val) {
                if (val !== '') {
                    let date = moment(val);
                    this.sample_steel_update_format = this.$dateStringFormat(date);
                } else {
                    this.sample_steel_update_format = 'No se ha registrado ninguna fecha';
                    this.sample_steel_update = '';
                }
            },
            verify_steel_update(val) {
                if (val !== '') {
                    let date = moment(val);
                    this.verify_steel_update_format = this.$dateStringFormat(date);
                } else {
                    this.verify_steel_update_format = 'No se ha registrado ninguna fecha';
                    this.verify_steel_update = '';
                }
            }
        },
        mounted() {
            this.sample_steel_update = this.pSampleSteel;
            this.verify_steel_update = this.pVerifySteel;
            this.loadSteelSampleObservations();
            this.initDataTable();
            this.initQuantityCheckSampleTable();
            this.loadQuantityCheckSampleObservation();
        },
        methods: {
            loadSteelSampleObservations() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase + `/admin/project/${this.pProjectId}/steel-sample-observations`;

                axios.get(url)
                    .then(resp => {
                        this.steelSampleObservationsData = resp.data
                    })
                    .catch(resp => {
                        console.log(resp.response);
                        if (resp.response.code)
                            toastr.error('Pedimos disculpas ha ocurrido un error interno<br>Por favor refresque la pagina.', 'Error!');
                    });
            },
            saveSteelSampleObservation() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;
                if (this.steelSampleObservations.observations === null) {
                    toastr.error('El campo de observaciones no debe de estar vacío.', 'Error!!');
                    let el = $("#txt_steel_sample_observations");
                    el.parent('.form-group').addClass('has-danger');
                    return false;
                }

                if (this.steelSampleObservations.hashid === null || this.steelSampleObservations.hashid === '') {
                    url += `/admin/project/${this.pProjectId}/steel-sample-observations`;
                    axios.post(url, this.steelSampleObservations)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.steelSampleObservations = {
                                hashid: null,
                                observations: null
                            };
                            this.loadSteelSampleObservations();
                        });
                } else {
                    url += `/admin/steel-sample-observations/${this.steelSampleObservations.hashid}`;

                    axios.put(url, this.steelSampleObservations)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.steelSampleObservations = {
                                hashid: null,
                                observations: null
                            };
                            this.loadSteelSampleObservations();
                        });
                }
            },
            editSteelSampleObservations: function (obj) {
                this.steelSampleObservations.hashid = obj.hashid;
                this.steelSampleObservations.observations = obj.observations;

                let el = $("#txt_steel_sample_observations");

                el.focus();
                $('html, body').stop().animate({
                    scrollTop: el.offset().top
                }, 900, 'swing');
            },
            deleteSteelSampleObservations(obj) {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                url += `/admin/steel-sample-observations/${obj.hashid}`;

                axios.delete(url)
                    .then(resp => {
                        toastr.success(resp.data.message, 'Mensaje!!');
                        this.steelSampleObservations = {
                            hashid: null,
                            observations: null
                        };
                        this.loadSteelSampleObservations();
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
                    this.resetValues(this.steelSample);
                    this.dataTableSteelSamples.ajax.reload();
                }

                switch (to) {
                    case 'sample-table':
                        this.editSample = false;
                        break;
                }
            },
            saveSteelSample() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                if (this.steelSample.date === '' || this.steelSample.date === null) {
                    toastr.error('Debe seleccionar una fecha para poder continuar.', 'Error!');
                    return false;
                } else if (this.steelSample.use === '' || this.steelSample.use === null) {
                    this.steelSampleErrors.use = true;
                    toastr.error('Debe digitar el Uso para poder continuar.', 'Error!');
                    return false;
                } else if (this.steelSample.type === '' || this.steelSample.type === null) {
                    this.steelSampleErrors.type = true;
                    toastr.error('Debe digitar el Tipo para poder continuar.', 'Error!');
                    return false;
                }

                if (this.steelSample.hashid !== null && this.steelSample.hashid !== '') {
                    url += `/admin/steel-samples/${this.steelSample.hashid}`;
                    axios.put(url, this.steelSample)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Éxito!');
                            this.sample_steel_update = resp.data.last_update;
                            this.showForm();
                            this.editSample = false;
                        });
                } else {
                    url += `/admin/project/${this.pProjectId}/steel-samples`;
                    axios.post(url, this.steelSample)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Éxito!');
                            this.sample_steel_update = resp.data.last_update;
                            this.showForm();
                            this.editSample = false;
                        })
                }
            },
            resetValues(object) {
                this.$cleanObjectValues(object, 0);
            },
            initDataTable() {
                let vm = this;
                vm.dataTableSteelSamples = $('#steel-samples-table').DataTable({
                    language: Config.langDataTable,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: vm.urlDataSteelSamples,
                        error(xhr) {
                            if (xhr.response.code)
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
                        let buttons = document.getElementsByClassName('btn-edit-steel-sample');
                        if (buttons) {
                            [...buttons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');
                                // console.log(url);
                                let tr = button.parentNode.parentElement.parentElement.parentElement;
                                let data = vm.dataTableSteelSamples.row(tr).data();

                                vm.steelSample.hashid = data.hashid;
                                vm.date.time = data.date;
                                vm.steelSample.date = data.date;
                                vm.steelSample.use = data.use_value;
                                vm.steelSample.type = data.type;
                                vm.steelSample.fy_mpa = data.fy_mpa;
                                vm.steelSample.fu_mpa = data.fu_mpa;
                                vm.steelSample.observations = data.observations_value ? data.observations_value.replace(/&quot;/g, '"') : '';

                                if (!vm.pIsAdmin)
                                    vm.editSample = true;
                                vm.showForm();

                            }));
                        } else {
                            vm.dataTableSteelSamples.column(6).visible(false);
                        }

                        let deleteButtons = document.getElementsByClassName('btn-delete-steel-sample');
                        if (deleteButtons) {
                            [...deleteButtons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');
                                console.log(url);
                                let tr = button.parentNode.parentElement.parentElement.parentElement;
                                let data = vm.dataTableSteelSamples.row(tr).data();

                                vm.steelSample.hashid = data.hashid;

                                axios.delete(url)
                                    .then(resp => {
                                        toastr.success(resp.data.message, 'Mensaje!');
                                        vm.dataTableSteelSamples.ajax.reload();
                                    });
                            }));
                        }
                    },
                    columns: [
                        {data: 'date', name: 'date', orderable: false},
                        {data: 'use', name: 'use', orderable: false, searchable: true},
                        {data: 'type', name: 'type', orderable: false, searchable: true},
                        {data: 'fy_mpa', name: 'fy_mpa', orderable: false, searchable: false},
                        {data: 'fu_mpa', name: 'fu_mpa', orderable: false, searchable: false},
                        {data: 'observations', name: 'observations', orderable: false, searchable: false},
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
                    this.dataTableSteelQuantityCheckSample.ajax.reload();
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
            initQuantityCheckSampleTable() {
                let vm = this;
                vm.dataTableSteelQuantityCheckSample = $('#steel-quantity-sample-table').DataTable({
                    language: Config.langDataTable,
                    processing: true,
                    serverSide: true,
                    ajax: vm.urlDataSteelQuantitySample,
                    drawCallback() {
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    initComplete() {
                        vm.$eventHideOverlay.$emit('hide');
                    },
                    fnDrawCallback() {
                        let buttons = document.getElementsByClassName('btn-edit-steel-quantity-check-sample');
                        if (buttons) {
                            [...buttons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');
                                let tr = button.parentNode.parentElement.parentElement.parentElement;
                                let data = vm.dataTableSteelQuantityCheckSample.row(tr).data();

                                vm.quantityCheckSample.hashid = data.hashid;
                                vm.quantityCheckSample.zone = data.zone_value;
                                vm.quantityCheckSample.approx_area = data.approx_area;
                                vm.quantityCheckSample.approx_intake = data.approx_intake;
                                vm.quantityCheckSample.cant_theoretical_sample = data.cant_theoretical_sample;
                                vm.quantityCheckSample.percent_approx_advance = data.percent_approx_advance_value;
                                vm.quantityCheckSample.pending_test_validation = data.pending_test_validation;
                                vm.quantityCheckSample.test_performed = data.test_performed;

                                if (!vm.pIsAdmin)
                                    vm.editQuantityCheckSample = true;

                                vm.showFormVerify();

                            }));
                        } else {
                            vm.dataTableSteelQuantityCheckSample.column(6).visible(false);
                        }

                        let deleteButtons = document.getElementsByClassName('btn-delete-steel-quantity-check-sample');
                        if (deleteButtons) {
                            [...deleteButtons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');
                                let tr = button.parentNode.parentElement.parentElement.parentElement;
                                let data = vm.dataTableSteelQuantityCheckSample.row(tr).data();

                                axios.delete(url)
                                    .then(resp => {
                                        toastr.success(resp.data.message, 'Mensaje!');
                                        vm.dataTableSteelQuantityCheckSample.ajax.reload();
                                    });
                            }));
                        }
                    },
                    footerCallback(row, data, start, end, display) {
                        let api = this.api();

                        let intVal = function (i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        let totalTheorical = api.column(4).data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        $(api.column(4).footer()).html(
                            totalTheorical
                        );

                        let totalTestPerformed = api.column(5).data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        $(api.column(5).footer()).html(
                            totalTestPerformed
                        );

                        totalTestPerformed = api.column(6).data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        $(api.column(6).footer()).html(
                            totalTestPerformed
                        );
                    },
                    columns: [
                        {data: 'zone', name: 'zone', orderable: false, searchable: true, width: '20%'},
                        {data: 'approx_area', name: 'approx_area', orderable: false, searchable: false},
                        {data: 'approx_intake', name: 'approx_intake', orderable: false, searchable: false},
                        {
                            data: 'percent_approx_advance',
                            name: 'percent_approx_advance',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'cant_theoretical_sample',
                            name: 'cant_theoretical_sample',
                            orderable: false,
                            searchable: false,
                            width: "5%"
                        },
                        {
                            data: 'test_performed',
                            name: 'test_performed',
                            orderable: false,
                            searchable: false,
                            width: "5%"
                        },
                        {
                            data: 'pending_test_validation',
                            name: 'pending_test_validation',
                            orderable: false,
                            searchable: false,
                            width: "5%"
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            },
            saveQuantityCheckSample() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;


                if (this.quantityCheckSample.zone === '' || this.quantityCheckSample.zone === null) {
                    toastr.error('Debe digitar la Zona para poder continuar.', 'Error!');
                    this.quantityCheckSampleErrors.zone = true;
                    return false;
                } else if (this.quantityCheckSample.approx_area === '' || this.quantityCheckSample.approx_area === null) {
                    this.quantityCheckSampleErrors.approx_area = true;
                    toastr.error('Debe digitar el Area Aproximada Uso para poder continuar.', 'Error!');
                    return false;
                }

                if (this.quantityCheckSample.hashid === null) {
                    url += `/admin/project/${this.pProjectId}/quantity-check-samples`;

                    this.quantityCheckSample.quantity_check_type = 'steel';
                    axios.post(url, this.quantityCheckSample)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.verify_steel_update = resp.data.last_update;
                            this.showFormVerify();
                        });
                } else {
                    url += `/admin/quantity-check-samples/${this.quantityCheckSample.hashid}`;
                    axios.put(url, this.quantityCheckSample)
                        .then(resp => {
                            toastr.success(resp.data.message);
                            this.verify_steel_update = resp.data.last_update;
                            this.showFormVerify();
                        });
                }
            },
            loadQuantityCheckSampleObservation() {
                let url = Config.adminUrlBase() + Config.adminApiUrlBase
                    + `/admin/project/${this.pProjectId}/quantity-check-sample-observations?quantity_check_type=steel`;

                axios.get(url)
                    .then(resp => {
                        this.quantityCheckSampleObservationsData = resp.data
                    })
                    .catch(resp => {
                        console.log(resp.response);
                        if (resp.status === 500)
                            toastr.error('Pedimos disculpas ha ocurrido un error interno<br>Por favor refresque la pagina.', 'Error!');
                    });
            },
            saveQuantityCheckSampleObservation() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                if (this.quantityCheckSampleObservation.observations === null) {
                    toastr.error('El campo de observaciones no debe de estar vacío.', 'Error!!');
                    let el = $("#txt_quantity_check_sample_observations");
                    el.parent('.form-group').addClass('has-danger');
                    return false;
                }

                if (this.quantityCheckSampleObservation.hashid === null) {
                    url += `/admin/project/${this.pProjectId}/quantity-check-sample-observations`;

                    this.quantityCheckSampleObservation.quantity_check_type = 'steel';

                    axios.post(url, this.quantityCheckSampleObservation)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.quantityCheckSampleObservation = {
                                hashid: null,
                                observations: null,
                                quantity_check_type: 'steel'
                            };
                            this.loadQuantityCheckSampleObservation();
                        });
                } else {
                    url += `/admin/quantity-check-sample-observations/${this.quantityCheckSampleObservation.hashid}`;
                    axios.put(url, this.quantityCheckSampleObservation)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.quantityCheckSampleObservation = {
                                hashid: null,
                                observations: null,
                                quantity_check_type: 'steel'
                            };
                            this.loadQuantityCheckSampleObservation();
                        });
                }
            },
            editQuantitySteelSampleObservation(obj) {
                this.quantityCheckSampleObservation.hashid = obj.hashid;
                this.quantityCheckSampleObservation.observations = obj.observations;

                let el = $("#txt_quantity_check_sample_observations");
                el.focus();
                $('html, body').stop().animate({
                    scrollTop: el.offset().top
                }, 900, 'swing');
            },
            deleteQuantitySteelSampleObservation(obj) {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                url += `/admin/quantity-check-sample-observations/${obj.hashid}`;

                axios.delete(url)
                    .then(resp => {
                        toastr.success(resp.data.message, 'Mensaje!!');
                        this.quantityCheckSampleObservation = {
                            hashid: null,
                            observations: null,
                            quantity_check_type: 'steel'
                        };
                        this.loadQuantityCheckSampleObservation();
                    });
            },
        }
    }
</script>