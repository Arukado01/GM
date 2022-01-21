<template>
    <div>
        <div id="accordion-mesh-samples" role="tablist" aria-multiselectable="true">
            <!--<div class="card mb-0">
                <div class="card-header" role="tab" id="heading-samples">
                    <h5 class="mb-0">
                        <a data-toggle="collapse" data-parent="#accordion-mesh-samples" href="#collapse-mesh-samples"
                           aria-expanded="false"
                           aria-controls="collapseSamples">
                            Toma de muestras
                        </a>
                    </h5>
                </div>

                <div id="collapse-mesh-samples" class="collapse" role="tabpanel" aria-labelledby="heading-samples">
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
                                {{ sample_mesh_update_format }}
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
                                            <table id="mesh-samples-table" class="table table-hover table-bordered"
                                                   style="width: 100% !important;" cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Uso</th>
                                                    <th>Diámetro</th>
                                                    <th>Fy [MPa]</th>
                                                    <th>Fu [MPa]</th>
       a]                                           <th>P sold. <br>Mín. [kg]</th>
                                                    <th>P sold. <br>[kg]</th>
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
                                            <p v-if="meshSampleObservationsData.length <= 0">
                                                No hay observaciones disponibles
                                            </p>
                                            <div v-else>
                                                <blockquote class="blockquote"
                                                            v-for="meshSampleObservation in meshSampleObservationsData">
                                                    <p>{{ meshSampleObservation.observations }}</p>
                                                    <hr>
                                                    <div class="text-right">
                                                        <a href="" class="btn btn-outline-danger"
                                                           @click.prevent="deleteMeshSampleObservations(meshSampleObservation)">
                                                            <i class="fa fa-trash"></i>
                                                            Eliminar
                                                        </a>
                                                        <a href="" class="btn btn-primary"
                                                           @click.prevent="editMeshSampleObservations(meshSampleObservation)">
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
                                                <textarea id="txt_mesh_sample_observations" cols="30" rows="10"
                                                          v-model="meshSampleObservations.observations"
                                                          placeholder="Escriba aquí sus observaciones"
                                                          class="form-control">
                                                </textarea>
                                                <div class="row">
                                                    <div class="col-md-6"
                                                         v-if="meshSampleObservations.observations !== null || ''">
                                                        <a href=""
                                                           @click.prevent="meshSampleObservations = {hashid: null, observations: null}"
                                                           class="btn btn-outline-danger btn-block">
                                                            Cancelar
                                                        </a>
                                                    </div>
                                                    <div :class="[meshSampleObservations.observations === null ? 'col-md-12' : 'col-md-6']">
                                                        <a href="" @click.prevent="saveMeshSampleObservation()"
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
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"
                                                         :class="{'has-danger': meshSampleErrors.use}">
                                                        <label for="txt-use">Uso</label>
                                                        <input type="text" v-model="meshSample.use"
                                                               id="txt-use"
                                                               class="form-control" v-if="!editSample">
                                                        <p v-else>
                                                            {{ meshSample.use }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"
                                                         :class="{'has-danger': meshSampleErrors.diameter}">
                                                        <label for="txt-diameter">Diámetro</label>
                                                        <input type="text" v-if="!editSample"
                                                               v-model="meshSample.diameter"
                                                               name="txt-diameter"
                                                               id="txt-diameter" class="form-control">
                                                        <p v-else>
                                                            {{ meshSample.diameter }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt-fy_mpa">Fy [MPa]</label>
                                                <input type="number" min="0" name="txt-fy_mpa"
                                                       v-model="meshSample.fy_mpa"
                                                       id="txt-fy_mpa"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt-fu_mpa">Fu [MPa]</label>
                                                <input type="number" min="0" name="txt-fu_mpa"
                                                       v-model="meshSample.fu_mpa"
                                                       id="txt-fu_mpa"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt-p_sold_min">P sold. Mín. [kg]</label>
                                                <input type="number" v-model="meshSample.p_sold_min"
                                                       name="txt-p_sold_min" min="0"
                                                       id="txt-p_sold_min" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="txt-p_sold">P sold. [kg]</label>
                                                <input type="number" v-model="meshSample.p_sold"
                                                       min="0" name="txt-p_sold"
                                                       id="txt-p_sold" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txt-observations">Observaciones</label>
                                                <textarea name="txt-observations" id="txt-observations"
                                                          v-model="meshSample.observations"
                                                          class="form-control" cols="30"
                                                          rows="10"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <a href="" @click.prevent="saveMeshSample" class="btn btn-primary">
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
                <div class="card-header" role="tab" id="heading-mesh-quantity">
                    <h5 class="mb-0">
                        <a data-toggle="collapse" data-parent="#accordion-mesh-samples" href="#collapse-mesh-quantity"
                           aria-expanded="false"
                           aria-controls="collapseTow">
                            ENSAYOS TRACCIÓN Y CORTANTE MALLAS
                        </a>
                    </h5>
                </div>
                <div id="collapse-mesh-quantity" class="collapse show" role="tabpanel"
                     aria-labelledby="heading-mesh-quantity">
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
                                {{ verify_mesh_update_format }}
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
                                            <table id="mesh-quantity-sample-table"
                                                   class="table table-hover table-bordered"
                                                   cellspacing="0">
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
                                                           @click.prevent="editQuantityMeshSampleObservation(quantityCheckSampleObservation)"
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
                                                <textarea id="txt_quantity_check_mesh_sample_observations" cols="30"
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
                                            <div class="form-group" :class="{'has-danger': quantityCheckSampleErrors.approx_area}">
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
            pSampleMesh: String,
            pVerifyMesh: String,
            urlDataMeshSamples: String,
            urlDataMeshQuantitySample: String,
            pProjectId: String,
            pIsAdmin: {
                type: Number
            }
        },
        data() {
            return {
                sample_mesh_update: '',
                sample_mesh_update_format: 'No se ha registrado ninguna fecha',
                verify_mesh_update: '',
                verify_mesh_update_format: 'No se ha registrado ninguna fecha',
                showTableContentVerify: true,
                showFormContentVerify: false,
                editSample: false,
                editQuantityCheckSample: false,
                showTableContent: true,
                showFormContent: false,
                dataTableMeshSamples: null,
                dateSelected: '',
                dateSelectedNoFormat: '',
                meshSample: {
                    hashid: null,
                    date: null,
                    use: null,
                    diameter: null,
                    fy_mpa: 0,
                    fu_mpa: 0,
                    p_sold_min: 0,
                    p_sold: 0,
                    observations: null,
                },
                meshSampleErrors: {
                    use: false,
                    diameter: false,

                },
                meshSampleObservations: {
                    hashid: null,
                    observations: null
                },
                meshSampleObservationsData: [],
                date: {
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
                    observations: null
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
                    this.meshSample.date = val;
                    this.option.placeholder = 'Cambiar fecha';
                    this.date.time = '';
                    this.dateSelected = date.format('MMMM DD [de] YYYY').capitalize();
                }
            },
            'meshSampleObservations.observations'(val) {
                if (val === '')
                    this.meshSampleObservations.observations = null;
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
            sample_mesh_update(val){
                if(val !== '') {
                    let date = moment(val);
                    this.sample_mesh_update_format = this.$dateStringFormat(date);
                }else{
                    this.sample_mesh_update_format = 'No se ha registrado ninguna fecha';
                    this.sample_mesh_update = '';
                }
            },
            verify_mesh_update(val){
                if(val !== '') {
                    let date = moment(val);
                    this.verify_mesh_update_format = this.$dateStringFormat(date);
                }else{
                    this.verify_mesh_update_format = 'No se ha registrado ninguna fecha';
                    this.verify_mesh_update = '';
                }
            }
        },
        mounted() {
            this.sample_mesh_update = this.pSampleMesh;
            this.verify_mesh_update = this.pVerifyMesh;
            this.loadMeshSampleObservations();
            this.initDataTable();
            this.initQuantityCheckSampleTable();
            this.loadQuantityCheckSampleObservation();
        },
        methods: {
            loadMeshSampleObservations() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase + `/admin/project/${this.pProjectId}/mesh-sample-observations`;

                axios.get(url)
                    .then(resp => {
                        this.meshSampleObservationsData = resp.data
                    })
                    .catch(resp => {
                        if (resp.status === 500)
                            toastr.error(`Pedimos disculpas ha ocurrido un error interno
                                    <br>Por favor refresque la pagina.`, 'Error!');
                    });
            },
            saveMeshSampleObservation() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;
                if (this.meshSampleObservations.observations === null) {
                    toastr.error('El campo de observaciones no debe de estar vacío.', 'Error!!');
                    let el = $("#txt_mesh_sample_observations");
                    el.parent('.form-group').addClass('has-danger');
                    return false;
                }

                if (this.meshSampleObservations.hashid === null || this.meshSampleObservations.hashid === '') {
                    url += `/admin/project/${this.pProjectId}/mesh-sample-observations`;
                    axios.post(url, this.meshSampleObservations)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.meshSampleObservations = {
                                hashid: null,
                                observations: null
                            };
                            this.loadMeshSampleObservations();
                        });
                } else {
                    url += `/admin/mesh-sample-observations/${this.meshSampleObservations.hashid}`;

                    axios.put(url, this.meshSampleObservations)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.meshSampleObservations = {
                                hashid: null,
                                observations: null
                            };
                            this.loadMeshSampleObservations();
                        });
                }
            },
            editMeshSampleObservations: function (obj) {
                this.meshSampleObservations.hashid = obj.hashid;
                this.meshSampleObservations.observations = obj.observations;

                let el = $("#txt_mesh_sample_observations");

                el.focus();
                $('html, body').stop().animate({
                    scrollTop: el.offset().top
                }, 900, 'swing');
            },
            deleteMeshSampleObservations(obj) {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                url += `/admin/mesh-sample-observations/${obj.hashid}`;
                axios.delete(url)
                    .then(resp => {
                        toastr.success(resp.data.message, 'Mensaje!!');
                        this.meshSampleObservations = {
                            hashid: null,
                            observations: null
                        };
                        this.loadMeshSampleObservations();
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
                    this.resetValues(this.meshSample);
                    this.dataTableMeshSamples.ajax.reload();
                }

                switch (to) {
                    case 'sample-table':
                        this.editSample = false;
                        break;
                }
            },
            saveMeshSample() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                if (this.meshSample.date === '' || this.meshSample.date === null) {
                    toastr.error('Debe seleccionar una fecha para poder continuar.', 'Error!');
                    return false;
                } else if (this.meshSample.use === '' || this.meshSample.use === null) {
                    this.meshSampleErrors.use = true;
                    toastr.error('Debe digitar el Area Aproximada Uso para poder continuar.', 'Error!');
                    return false;
                } else if (this.meshSample.diameter === '' || this.meshSample.diameter === null) {
                    this.meshSampleErrors.diameter = true;
                    toastr.error('Debe digitar el Diametro Uso para poder continuar.', 'Error!');
                    return false;
                }

                if (this.meshSample.hashid !== null && this.meshSample.hashid !== '') {
                    url += `/admin/mesh-samples/${this.meshSample.hashid}`;
                    axios.put(url, this.meshSample)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Éxito!');
                            this.sample_mesh_update = resp.data.last_update;
                            this.showForm();
                            this.editSample = false;
                        });
                } else {
                    url += `/admin/project/${this.pProjectId}/mesh-samples`;
                    axios.post(url, this.meshSample)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Éxito!');
                            this.sample_mesh_update = resp.data.last_update;
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
                vm.dataTableMeshSamples = $('#mesh-samples-table').DataTable({
                    language: Config.langDataTable,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: vm.urlDataMeshSamples,
                        error(resp) {
                            console.log(resp);
                            if (resp.status === 500)
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
                        let buttons = document.getElementsByClassName('btn-edit-mesh-sample');
                        if (buttons) {
                            [...buttons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');
                                // console.log(url);
                                let tr = button.parentNode.parentElement.parentElement.parentElement;
                                let data = vm.dataTableMeshSamples.row(tr).data();

                                vm.meshSample.hashid = data.hashid;
                                vm.date.time = data.date;
                                vm.meshSample.date = data.date;
                                vm.meshSample.use = data.use_value;
                                vm.meshSample.diameter = data.diameter;
                                vm.meshSample.fy_mpa = data.fy_mpa;
                                vm.meshSample.fu_mpa = data.fu_mpa;
                                vm.meshSample.p_sold_min = data.p_sold_min;
                                vm.meshSample.p_sold = data.p_sold;
                                vm.meshSample.observations = data.observations_value.replace(/&quot;/g, '"');

                                if (!vm.pIsAdmin)
                                    vm.editSample = true;
                                vm.showForm();

                            }));
                        } else {
                            vm.dataTableMeshSamples.column(6).visible(false);
                        }

                        let deleteButtons = document.getElementsByClassName('btn-delete-mesh-sample');
                        if (deleteButtons) {
                            [...deleteButtons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');

                                axios.delete(url)
                                    .then(resp => {
                                        toastr.success(resp.data.message, 'Mensaje!');
                                        vm.dataTableMeshSamples.ajax.reload();
                                    });
                            }));
                        }
                    },
                    columns: [
                        {data: 'date', name: 'date', orderable: false},
                        {data: 'use', name: 'use', orderable: false, searchable: true},
                        {data: 'diameter', name: 'diameter', orderable: false, searchable: true},
                        {data: 'fy_mpa', name: 'fy_mpa', orderable: false, searchable: false},
                        {data: 'fu_mpa', name: 'fu_mpa', orderable: false, searchable: false},
                        {data: 'p_sold_min', name: 'p_sold_min', orderable: false, searchable: false},
                        {data: 'p_sold', name: 'p_sold', orderable: false, searchable: false},
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
                    this.dataTableMeshQuantityCheckSample.ajax.reload();
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
                vm.dataTableMeshQuantityCheckSample = $('#mesh-quantity-sample-table').DataTable({
                    language: Config.langDataTable,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: vm.urlDataMeshQuantitySample,
                        error(resp) {
                            console.log(resp);
                            if (resp.status === 500)
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
                        let buttons = document.getElementsByClassName('btn-edit-mesh-quantity-check-sample');
                        if (buttons) {
                            [...buttons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');
                                let tr = button.parentNode.parentElement.parentElement.parentElement;
                                let data = vm.dataTableMeshQuantityCheckSample.row(tr).data();

                                console.log(data.hashid);
                                vm.quantityCheckSample.hashid = data.hashid;
                                vm.quantityCheckSample.zone = data.zone_value;
                                vm.quantityCheckSample.approx_area = data.approx_area;
                                vm.quantityCheckSample.approx_intake = data.approx_intake;
                                vm.quantityCheckSample.cant_theoretical_sample = data.cant_theoretical_sample;
                                vm.quantityCheckSample.percent_approx_advance = data.percent_approx_advance_value;
                                vm.quantityCheckSample.test_performed = data.test_performed;
                                vm.quantityCheckSample.pending_test_validation = data.pending_test_validation;
                                vm.quantityCheckSample.quantity_check_type = data.quantity_check_type;

                                if (!vm.pIsAdmin)
                                    vm.editQuantityCheckSample = true;

                                vm.showFormVerify();

                            }));
                        } else {
                            vm.dataTableMeshQuantityCheckSample.column(6).visible(false);
                        }

                        let deleteButtons = document.getElementsByClassName('btn-delete-mesh-quantity-check-sample');
                        if (deleteButtons) {
                            [...deleteButtons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');

                                axios.delete(url)
                                    .then(resp => {
                                        toastr.success(resp.data.message, 'Mensaje!');
                                        vm.dataTableMeshQuantityCheckSample.ajax.reload();
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
                        {data: 'action', name: 'action', orderable: false, searchable: false}
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

                    this.quantityCheckSample.quantity_check_type = 'mesh';
                    axios.post(url, this.quantityCheckSample)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.verify_mesh_update = resp.data.last_update;
                            this.showFormVerify();
                        });
                } else {
                    url += `/admin/quantity-check-samples/${this.quantityCheckSample.hashid}`;
                    axios.put(url, this.quantityCheckSample)
                        .then(resp => {
                            toastr.success(resp.data.message);
                            this.verify_mesh_update = resp.data.last_update;
                            this.showFormVerify();
                        });
                }
            },
            loadQuantityCheckSampleObservation() {
                let url = Config.adminUrlBase() + Config.adminApiUrlBase
                    + `/admin/project/${this.pProjectId}/quantity-check-sample-observations?quantity_check_type=mesh`;

                axios.get(url)
                    .then(resp => {
                        this.quantityCheckSampleObservationsData = resp.data
                    })
                    .catch(resp => {
                        if (resp.status === 500)
                            toastr.error(`Pedimos disculpas ha ocurrido un error interno
                                    <br>Por favor refresque la pagina.`, 'Error!');
                    });
            },
            saveQuantityCheckSampleObservation() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                if (this.quantityCheckSampleObservation.observations === null) {
                    toastr.error('El campo de observaciones no debe de estar vacío.', 'Error!!');
                    let el = $("#txt_quantity_check_mesh_sample_observations");
                    el.parent('.form-group').addClass('has-danger');
                    return false;
                }

                if (this.quantityCheckSampleObservation.hashid === null) {
                    url += `/admin/project/${this.pProjectId}/quantity-check-sample-observations`;

                    this.quantityCheckSampleObservation.quantity_check_type = 'mesh';
                    axios.post(url, this.quantityCheckSampleObservation)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.loadQuantityCheckSampleObservation();
                        });
                } else {
                    url += `/admin/quantity-check-sample-observations/${this.quantityCheckSampleObservation.hashid}`;
                    axios.put(url, this.quantityCheckSampleObservation)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                            this.loadQuantityCheckSampleObservation();
                        });
                }
            },
            editQuantityMeshSampleObservation(obj) {
                this.quantityCheckSampleObservation.hashid = obj.hashid;
                this.quantityCheckSampleObservation.observations = obj.observations;

                let el = $("#txt_quantity_check_mesh_sample_observations");
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
                            quantity_check_type: 'mesh'
                        };
                        this.loadQuantityCheckSampleObservation();
                    });
            },
        }
    }
</script>