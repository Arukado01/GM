<template>
    <div>
        <div class="card mb-0">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <a href="" @click.prevent="showForm('sample-table')" class="btn"
                           :class="{'btn-outline-primary': showTableContent, 'btn-outline-danger': showFormContent} ">
                                    <span v-if="showTableContent">
                                        <i class="fa fa-plus"></i> Agregar Control
                                    </span>
                            <span v-else-if="showFormContent">
                                        <i class="fa fa-arrow-left"></i> Atrás
                                    </span>
                        </a>
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
                                    <table id="settlement-control-table" class="table table-hover table-bordered"
                                           style="width: 100% !important;" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th>Zona</th>
                                            <th>Fecha Inicial</th>
                                            <th>Fecha de actualización</th>
                                            <th>&Delta; Máxima (mm)</th>
                                            <th>Observaciones</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                    </table>
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
                                <div class="col-md-6 text-center">
                                    <div class="form-group">
                                        <div class="text-center date-select-content" v-if="!editSample">
                                            <i class="fa fa-calendar"></i>
                                            <date-picker :date="lastDate" :option="optionLastUpdate"></date-picker>
                                        </div>
                                        <label v-if="dateLastUpdateSelected != ''">
                                            Fecha seleccionada: {{ dateLastUpdateSelected }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-danger': zoneError}">
                                        <label for="txt-zone">Zona</label>
                                        <input type="text" v-model="settlementControl.zone"
                                               id="txt-zone"
                                               class="form-control" v-if="!editSample">
                                        <p v-else>
                                            {{ settlementControl.zone }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txt-max_area">&Delta; Máxima (mm)</label>
                                        <input type="number" v-if="!editSample"
                                               v-model="settlementControl.max_area"
                                               name="txt-max_area" min="0"
                                               id="txt-max_area" class="form-control">
                                        <p v-else>
                                            {{ settlementControl.max_area }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txt-observations">Observaciones</label>
                                        <textarea name="txt-observations" id="txt-observations"
                                                  v-model="settlementControl.observations"
                                                  class="form-control" cols="30"
                                                  rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="" @click.prevent="saveSettlementControl" class="btn btn-primary">
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
            urlDataSettlementControl: String,
            pProjectId: String,
            pIsAdmin: {
                type: Number
            }
        },
        data() {
            return {
                editSample: false,
                showTableContent: true,
                showFormContent: false,
                dataTableSettlementControl: null,
                dateSelected: '',
                dateSelectedNoFormat: '',
                settlementControl: {
                    hashid: null,
                    zone: null,
                    start_date: null,
                    last_date: null,
                    max_area: null,
                    observations: null,
                },
                zoneError: false,
                date: {
                    time: ''
                },
                lastDate: {
                    time: ''
                },
                dateLastUpdateSelected: '',
                dateLastUpdateSelectedNoFormat: '',
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
                    placeholder: 'Presiona aquí para seleccionar una fecha Inicial',
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
                optionLastUpdate: {
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
                    placeholder: 'Presiona aquí para seleccionar la ultima fecha de actualización',
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
                    this.settlementControl.start_date = val;
                    this.option.placeholder = 'Cambiar fecha';
                    this.date.time = '';
                    this.dateSelected = date.format('MMMM DD [de] YYYY').capitalize();
                }
            },
            'lastDate.time'(val) {
                if (val !== '') {
                    let date = moment(val);
                    this.dateLastUpdateSelectedNoFormat = val;
                    this.settlementControl.last_date = val;
                    this.optionLastUpdate.placeholder = 'Cambiar fecha';
                    this.lastDate.time = '';
                    this.dateLastUpdateSelected = date.format('MMMM DD [de] YYYY').capitalize();

                }
            },
            'settlementControl.approx_intake'(val) {
                if (val === '')
                    this.settlementControl.approx_intake = 0;
                this.settlementControl.cant_theoretical_sample = Math.ceil(val / 50);
            },
            'settlementControl.percent_approx_advance'(val) {
                if (val === '')
                    this.settlementControl.percent_approx_advance = 0;
            }
        },
        mounted() {
            this.initDataTable();
        },
        methods: {
            showForm(to) {
                this.$eventShowOverlay.$emit('show');
                if (this.showTableContent) {
                    this.showTableContent = false;
                } else if (this.showFormContent) {
                    this.showFormContent = false;
                    this.dateSelected = '';
                    this.option.placeholder = 'Presiona aquí para seleccionar una fecha Inicial';
                    this.dateSelectedNoFormat = '';

                    this.dateLastUpdateSelected = '';
                    this.optionLastUpdate.placeholder = 'Presiona aquí para seleccionar la ultima fecha de actualización';
                    this.dateLastUpdateSelectedNoFormat = '';

                    this.resetValues(this.settlementControl);
                    this.dataTableSettlementControl.ajax.reload();
                }

                switch (to) {
                    case 'sample-table':
                        this.editSample = false;
                        break;
                }
            },
            saveSettlementControl() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                if(this.settlementControl.zone === '' || this.settlementControl.zone === null){
                    this.zoneError = true;
                    toastr.error('Por favor digite la zona.');
                    return false;
                }else if(this.settlementControl.last_date === '' || this.settlementControl.last_date === null){
                    toastr.error('Debe seleccionar la ultima fecha de actualización para poder continuar.');
                    return false;
                }else if(this.settlementControl.start_date === '' || this.settlementControl.start_date === null){
                    toastr.error('Debe seleccionar la fecha inicial para poder continuar.');
                    return false;
                }

                if (this.settlementControl.hashid !== null && this.settlementControl.hashid !== '') {
                    url += `/admin/settlement-control/${this.settlementControl.hashid}`;
                    axios.put(url, this.settlementControl)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Éxito!');
                            this.showForm();
                            this.editSample = false;
                        });
                } else {
                    url += `/admin/project/${this.pProjectId}/settlement-control`;
                    axios.post(url, this.settlementControl)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Éxito!');
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
                vm.dataTableSettlementControl = $('#settlement-control-table').DataTable({
                    language: Config.langDataTable,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: vm.urlDataSettlementControl,
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
                        let buttons = document.getElementsByClassName('btn-edit-settlement-sample');
                        if (buttons) {
                            [...buttons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');
                                // console.log(url);
                                let tr = button.parentNode.parentElement.parentElement.parentElement;
                                let data = vm.dataTableSettlementControl.row(tr).data();

                                vm.settlementControl.hashid = data.hashid;
                                vm.date.time = data.start_date;
                                vm.lastDate.time = data.last_date;
                                vm.settlementControl.start_date = data.start_date;
                                vm.settlementControl.last_date = data.last_date;
                                vm.settlementControl.zone = data.zone;
                                vm.settlementControl.max_area = data.max_area;
                                vm.settlementControl.observations = data.observations_value.replace(/&quot;/g, '"');

                                if (!vm.pIsAdmin)
                                    vm.editSample = true;
                                vm.showForm();

                            }));
                        } else {
                            vm.dataTableSettlementControl.column(6).visible(false);
                        }

                        let deleteButtons = document.getElementsByClassName('btn-delete-settlement-sample');
                        if (deleteButtons) {
                            [...deleteButtons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');

                                axios.delete(url)
                                    .then(resp => {
                                        toastr.success(resp.data.message, 'Mensaje!');
                                        vm.dataTableSettlementControl.ajax.reload();
                                    });
                            }));
                        }
                    },
                    columns: [
                        {data: 'zone', name: 'zone', orderable: false},
                        {data: 'start_date', name: 'start_date', orderable: true, searchable: true},
                        {data: 'last_date', name: 'last_date', orderable: true, searchable: true},
                        {data: 'max_area', name: 'max_area', orderable: false, searchable: false},
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
        }
    }
</script>