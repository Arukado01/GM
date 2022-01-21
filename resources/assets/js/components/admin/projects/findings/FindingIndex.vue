<template>
    <div>
        <div class="widget" id="card-form">
            <div class="widget-header">
                <h5>Agregar Hallazgo</h5>
            </div>
            <div class="widget-body">
                <div class="row mt-3">
                    <div class="col-md-6 text-center">
                        <div class="form-group">
                            <div class="text-center date-select-content">
                                <i class="fa fa-calendar"></i>
                                <date-picker :date="date" :option="option"></date-picker>
                            </div>
                            <label v-if="dateSelected != ''">
                                Fecha seleccionada {{ dateSelected }}
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="form-group" :class="{'has-danger': findingErrors.affair}">
                            <label for="txt_affair">Asunto</label>
                            <input type="text" id="txt_affair" class="form-control" v-model="finding.affair">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" :class="{'has-danger': findingErrors.finding}">
                            <vue-editor v-model="finding.finding"
                                        placeholder="Escriba aquí la redacción completa del hallazgo."></vue-editor>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <div class="btn-group" v-if="isEdit">
                    <a href="" @click.prevent="cancelEditing()" class="btn btn-outline-warning">
                        <i class="fa fa-ban"></i> Cancelar
                    </a>
                    <a href="" @click.prevent="saveEditFinding()" class="btn btn-outline-success">
                        <i class="fa fa-edit"></i> Editar
                    </a>
                </div>
                <a href="" @click.prevent="saveFinding()" class="btn btn-outline-primary" v-else>
                    <i class="fa fa-save"></i> Guardar
                </a>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Listado de Hallazgos</h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12" :class="{'text-center': findingsData.length <= 0}">
                        <div id="accordion-findings" role="tablist" aria-multiselectable="true"
                             v-if="findingsData.length > 0">
                            <div class="card mb-0" v-for="(findingData, index) in findingsData">
                                <div class="card-header" role="tab" id="headingOne">
                                    <h5 class="mb-0 pull-left">
                                        <a data-toggle="collapse" :href="'#collapse_'+index" aria-expanded="true"
                                           :aria-controls="'#collapse_'+index">
                                            {{ findingData.affair }} <sub>{{ findingData.date }}</sub>
                                        </a>
                                    </h5>
                                    <div class="btn-group btn-group-sm pull-right">
                                        <a href="" @click.prevent="findingEdit(findingData)"
                                           class="btn btn-outline-primary">
                                            <i class="fa fa-edit"></i>Editar
                                        </a>
                                        <a href="" @click.prevent="deleteFinding(findingData)"
                                           class="btn btn-outline-danger">
                                            <i class="fa fa-trash"></i>Eliminar
                                        </a>
                                    </div>
                                </div>

                                <div :id="'collapse_'+index" class="collapse" role="tabpanel"
                                     aria-labelledby="headingOne"
                                     data-parent="#accordion-findings">
                                    <div class="card-block">
                                        <span v-html="findingData.finding"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span v-else>No se encontraron registros para mostrar.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import adminConfig from '../../../../admin_conf';
    import Datepicker from 'vue-datepicker';
    import {VueEditor} from 'vue2-editor';

    moment.locale('es');

    export default {
        props: ['p-project-id'],
        components: {
            'date-picker': Datepicker,
            VueEditor
        },
        mounted() {
            this.loadFindings();
        },
        data() {
            return {
                finding: {
                    date: '',
                    affair: '',
                    finding: '',
                },
                findingErrors: {
                    affair: false,
                    finding: false
                },
                findingsData: [],
                dateSelected: '',
                dateSelectedNoFormat: '',
                date: {
                    time: ''
                },
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
                timeoption: {
                    type: 'min',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    format: 'YYYY-MM-DD HH:mm'
                },
                multiOption: {
                    type: 'multi-day',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    format: "YYYY-MM-DD HH:mm"
                },
                limit: [
                    {
                        type: 'weekday',
                        available: [1, 2, 3, 4, 5]
                    },
                    {
                        type: 'fromto',
                        from: '2016-02-01',
                        to: '2016-02-20'
                    }
                ],
                isEdit: false
            }
        },
        watch: {
            'date.time': function (val) {
                if (val !== '') {
                    let date = moment(val);
                    this.dateSelectedNoFormat = val;
                    this.finding.date = val;
                    this.option.placeholder = 'Cambiar fecha';
                    this.date.time = '';
                    this.dateSelected = date.format('MMMM DD [de] YYYY').capitalize();
                }
            },
            'finding.finding'(val) {
                if (val === '<p><br></p>')
                    this.finding.finding = '';
            }
        },
        methods: {
            loadFindings() {
                let url = adminConfig.adminUrlBase() + adminConfig.adminApiUrlBase +
                    `/admin/projects/${this.pProjectId}/findings-data`;

                axios.get(url)
                    .then(resp => {
                        this.findingsData = resp.data.findings;
                        this.$eventHideOverlay.$emit('hide');
                    });
            },
            valForm() {
                let band = true;
                if (this.dateSelected === '') {
                    toastr.error('Debe seleccionar una "fecha" para poder continuar.', 'Error!');
                    band = false;
                } else if (this.finding.affair === '') {
                    toastr.error('Debe escribir el "asunto" para poder continuar.', 'Error!');
                    this.findingErrors.affair = true;
                    band = false;
                } else if (this.finding.finding === '') {
                    toastr.error('Debe escribir el "hallazgo" para poder continuar.', 'Error!');
                    this.findingErrors.finding = true;
                    band = false;
                }

                return band;
            },
            saveFinding() {
                let url = adminConfig.adminUrlBase() + adminConfig.adminApiUrlBase +
                    `/admin/projects/${this.pProjectId}/findings`;

                if (this.valForm()) {
                    axios.post(url, this.finding)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!');
                            this.cancelEditing();
                            this.loadFindings();
                        });
                }
            },
            findingEdit(findingData) {
                this.finding.hashid = findingData.hashid;
                this.finding.date = findingData.date;
                this.finding.affair = findingData.affair;
                this.finding.finding = findingData.finding;

                this.isEdit = true;
                this.$scrollTo($('#card-form'));
                let date = moment(this.finding.date);
                this.dateSelectedNoFormat = this.finding.date;
                this.option.placeholder = 'Cambiar fecha';
                this.date.time = '';
                this.dateSelected = date.format('MMMM DD [de] YYYY').capitalize();

            },
            cancelEditing() {
                delete this.finding.hashid;
                this.finding = {
                    date: '',
                    affair: '',
                    finding: '',
                };

                this.date.time = '';
                this.dateSelected = '';
                this.dateSelectedNoFormat = '';
                this.option.placeholder = 'Presiona aquí para seleccionar una fecha';

                this.isEdit = false;
            },
            saveEditFinding() {
                let url = adminConfig.adminUrlBase() + adminConfig.adminApiUrlBase +
                    `/admin/findings/${this.finding.hashid}`;

                if (this.valForm()) {
                    axios.put(url, this.finding)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!');
                            this.loadFindings();
                            this.cancelEditing();
                        });
                }
            },
            deleteFinding(findingData) {
                let url = adminConfig.adminUrlBase() + adminConfig.adminApiUrlBase +
                    `/admin/findings/${findingData.hashid}`;

                axios.delete(url)
                    .then(resp => {
                        toastr.success(resp.data.message, 'Mensaje!');
                        this.cancelEditing();
                        this.loadFindings();
                    });

            }
        }
    }
</script>