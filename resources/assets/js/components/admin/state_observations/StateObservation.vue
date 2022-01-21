<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <div class="form-group">
                                    <div class="text-center date-select-content">
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
                                    <label for="txt_total_pending" class="text-success font-weight-bold">
                                        Total Pendientes
                                    </label>
                                    <p class="text-success font-weight-bold">
                                        <strong>{{ stateObservation.total_pending }}</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="txt_previous_open">
                                        Abiertas Anteriores
                                    </label>
                                    <input type="number" min="0" v-model="stateObservation.previous_open"
                                           @blur="stateObservation.previous_open === '' ? stateObservation.previous_open = 0 : ''"
                                           id="txt_previous_open" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-center">
                                    <label for="txt_total_in_period" class="text-success font-weight-bold">
                                        Total en Periodo
                                    </label>
                                    <p class="text-success font-weight-bold"><strong>{{ stateObservation.total_in_period
                                        }}</strong></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-right">
                                    <label for="txt_closed_in_period">
                                        Cerradas en Periodo
                                    </label>
                                    <input type="number" min="0" v-model="stateObservation.closed_in_period"
                                           @blur="stateObservation.closed_in_period === '' ? stateObservation.closed_in_period = 0 : ''"
                                           id="txt_closed_in_period" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txt_planning">
                                        (A) Planeación
                                    </label>
                                    <input type="number" min="0" v-model="stateObservation.planning"
                                           @blur="stateObservation.planning === '' ? stateObservation.planning = 0 : ''"
                                           id="txt_planning" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txt_plans">
                                        (B) Planos
                                    </label>
                                    <input type="number" min="0" v-model="stateObservation.plans"
                                           @blur="stateObservation.plans === '' ? stateObservation.plans = 0 : ''"
                                           id="txt_plans" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txt_specifications">
                                        (C) Especificaciones
                                    </label>
                                    <input type="number" min="0" v-model="stateObservation.specifications"
                                           @blur="stateObservation.specifications === '' ? stateObservation.specifications = 0 : ''"
                                           id="txt_specifications" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txt_materials">
                                        (D) Materiales
                                    </label>
                                    <input type="number" min="0" v-model="stateObservation.materials"
                                           @blur="stateObservation.materials === '' ? stateObservation.materials = 0 : ''"
                                           id="txt_materials" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txt_foundation">
                                        (E) Cimentación
                                    </label>
                                    <input type="number" min="0" v-model="stateObservation.foundation"
                                           @blur="stateObservation.foundation === '' ? stateObservation.foundation = 0 : ''"
                                           id="txt_foundation" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txt_vertical_elem">
                                        (F) Elem. Verticales
                                    </label>
                                    <input type="number" min="0" v-model="stateObservation.vertical_elem"
                                           @blur="stateObservation.vertical_elem === '' ? stateObservation.vertical_elem = 0 : ''"
                                           id="txt_vertical_elem" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txt_mezzanines">
                                        (G) Entrepisos
                                    </label>
                                    <input type="number" min="0" v-model="stateObservation.mezzanines"
                                           @blur="stateObservation.mezzanines === '' ? stateObservation.mezzanines = 0 : ''"
                                           id="txt_mezzanines" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txt_tank_pool">
                                        (H) Tanque/Piscina
                                    </label>
                                    <input type="number" min="0" v-model="stateObservation.tank_pool"
                                           @blur="stateObservation.tank_pool === '' ? stateObservation.tank_pool = 0 : ''"
                                           id="txt_tank_pool" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txt_metallic">
                                        (I) Metálicas
                                    </label>
                                    <input type="number" min="0" v-model="stateObservation.metallic"
                                           @blur="stateObservation.metallic === '' ? stateObservation.metallic = 0 : ''"
                                           id="txt_metallic" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txt_non_structural">
                                        (J) No estructurales
                                    </label>
                                    <input type="number" min="0" v-model="stateObservation.non_structural"
                                           @blur="stateObservation.non_structural === '' ? stateObservation.non_structural = 0 : ''"
                                           id="txt_non_structural" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Observaciones Atención Inmediata en Periodo</h5>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="txt_previous_open">
                                        Atendidas
                                    </label>
                                    <input type="number" min="0" v-model="stateObservation.catered"
                                           @blur="stateObservation.catered === '' ? stateObservation.catered = 0 : ''"
                                           id="txt_previous_open" class="form-control">
                                
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="txt_previous_open">
                                        Sin Atender
                                    </label>
                                    <input type="number" min="0" v-model="stateObservation.unattended"
                                           @blur="stateObservation.unattended === '' ? stateObservation.unattended = 0 : ''"
                                           id="txt_previous_open" class="form-control">
                                
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-center">
                                    <label for="txt_total_in_period" class="text-success font-weight-bold">
                                        Total
                                    </label>
                                    <p class="text-success font-weight-bold"><strong>{{ stateObservation.total_attended }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Fecha de actualización: {{ stateObservation.date }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <chartjs-bar :labels="chart_labels" :data="dataChart" :bind="true"
                                             :option="optionsChart">
                                </chartjs-bar>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center pb-2">
                                <h6>Observaciones Atención Inmediata en Periodo</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 grafic-bar">
                                <div class="row">
                                    <div class="col-6 grafic-bar-left">
                                        <div v-bind:style="{ width: graficBar.graficBarLeft + '%'}"  v-bind:class="{inactive: graficBar.inActiveLeft}" data-toggle="tooltip" data-placement="top" v-bind:data-original-title="'Atendidas ' + stateObservation.catered "></div>
                                    </div>
                                    <div class="col-6 grafic-bar-right">
                                        <div v-bind:style="{ width: graficBar.graficBarRight + '%'}"  v-bind:class="{inactive: graficBar.inActiveRight}" data-toggle="tooltip" data-placement="top" v-bind:data-original-title="'Sin Atender ' + stateObservation.unattended"></div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6 pr-1 text-right font-weight-bold">Atendidos: {{stateObservation.catered}}   |</div>
                                    <div class="col-6 pl-1 text-left font-weight-bold">|  Sin Atender: {{stateObservation.unattended}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center font-weight-bold">Total: {{stateObservation.total_attended}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-right">
                <a href="" @click.prevent="saveData" class="btn btn-outline-primary">
                    <i class="fa fa-save"></i> Guardar
                </a>
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
        props: ['pProjectId'],
        data() {
            return {
                dateSelected: '',
                dateSelectedNoFormat: '',
                stateObservation: {
                    hashid: '',
                    date: '',
                    total_pending: 0,
                    previous_open: 0,
                    total_in_period: 0,
                    closed_in_period: 0,
                    planning: 0,
                    plans: 0,
                    specifications: 0,
                    materials: 0,
                    foundation: 0,
                    vertical_elem: 0,
                    mezzanines: 0,
                    tank_pool: 0,
                    metallic: 0,
                    non_structural: 0,
                    catered: 0,
                    unattended: 0,
                    total_attended: 0
                },
                chart_labels: [
                    'Total Pendientes',
                    ' ',
                    'Abiertas Anteriores',
                    'Total en Periodo',
                    'Cerradas en Periodo',
                    ' ',
                    '(A) Planeación',
                    '(B) Planos',
                    '(C) Especificaciones',
                    '(D) Materiales',
                    '(E) Cimentación',
                    '(F) Elem. Verticales',
                    '(G) Entrepisos',
                    '(H) Tanque/Piscina',
                    '(I) Metálicas',
                    '(J) No estructurales'
                ],
                graficBar: {
                    graficBarLeft: 0,
                    graficBarRight: 0,
                    inActiveLeft: true,
                    inActiveRight: true,
                },
                dataChart: [],
                optionsChart: {
                    showAllTooltips: true,
                    legend: {
                        display: false,
                    },
                    responsive: true,
                    maintainAspectRatio: true,
                    title: {
                        display: true,
                        position: 'top',
                        text: 'ESTADO DE OBSERVACIONES'
                    },
                    tooltips: {
                        displayColors: false,
                        yAlign: 'bottom',
                        xAlign: 'center',
                        custom(tooltip) {
                            if (!tooltip) return;
                            // disable displaying the color box;
                        },
                        callbacks: {
                            // use label callback to return the desired label
                            label: function (tooltipItem, data) {
                                return tooltipItem.yLabel;
                            },
                            // remove title
                            title: function (tooltipItem, data) {
                                return false;
                            }
                        }
                    },
                    scales: {
                        xAxes: [{
                            stacked: true,
                            ticks: {
                                autoSkip: false
                            }
                        }],
                        yAxes: [{
                            stacked: true,
                            ticks: {
                                autoSkip: false
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'CANTIDAD'
                            }
                        }]
                    }
                },
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
            }
        },
        watch: {
            'date.time'(val) {
                if (val !== '') {
                    let date = moment(val);
                    this.dateSelectedNoFormat = val;
                    this.stateObservation.date = val;
                    this.option.placeholder = 'Cambiar fecha';
                    this.date.time = '';
                    this.dateSelected = date.format('MMMM DD [de] YYYY').capitalize();
                }
            },
            'stateObservation.previous_open'() {
                this.calcTotalPending();
                this.getDataChart();
            },
            'stateObservation.total_in_period'() {
                this.calcTotalPending();
                this.getDataChart();
            },
            'stateObservation.closed_in_period'() {
                this.calcTotalPending();
                this.getDataChart();
            },
            'stateObservation.planning'() {
                this.calcTotalInPeriod();
                this.getDataChart();
            },
            'stateObservation.plans'() {
                this.calcTotalInPeriod();
                this.getDataChart();
            },
            'stateObservation.specifications'() {
                this.calcTotalInPeriod();
                this.getDataChart();
            },
            'stateObservation.materials'() {
                this.calcTotalInPeriod();
                this.getDataChart();
            },
            'stateObservation.foundation'() {
                this.calcTotalInPeriod();
                this.getDataChart();
            },
            'stateObservation.vertical_elem'() {
                this.calcTotalInPeriod();
                this.getDataChart();
            },
            'stateObservation.mezzanines'() {
                this.calcTotalInPeriod();
                this.getDataChart();
            },
            'stateObservation.tank_pool'() {
                this.calcTotalInPeriod();
                this.getDataChart();
            },
            'stateObservation.metallic'() {
                this.calcTotalInPeriod();
                this.getDataChart();
            },
            'stateObservation.non_structural'() {
                this.calcTotalInPeriod();
                this.getDataChart();
            },
            'stateObservation.catered'() {
                this.calcTotalAttended();
                this.calGraficBar();
            },
            'stateObservation.unattended'() {
                this.calcTotalAttended();
                this.calGraficBar();
            },

        },
        mounted() {
            this.loadStateObservation();
        },
        methods: {
            loadStateObservation() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                url += `/admin/project/${this.pProjectId}/state-observations`;

                axios.get(url)
                    .then(resp => {
                        if (resp.data.length > 0)
                            this.stateObservation = resp.data[0];
                    });
            },
            calcTotalPending() {
                this.stateObservation.total_pending =
                    parseInt(this.stateObservation.previous_open) +
                    parseInt(this.stateObservation.total_in_period) -
                    parseInt(this.stateObservation.closed_in_period);
            },
            calcTotalAttended() {
                this.stateObservation.total_attended =
                    parseInt(this.stateObservation.catered) +
                    parseInt(this.stateObservation.unattended);
            },

            calGraficBar() {
                let NaN = 0;
                let graficBarPlus =
                    parseInt(this.stateObservation.catered) +
                    parseInt(this.stateObservation.unattended);
                this.graficBar.graficBarLeft =
                    parseInt(this.stateObservation.catered) /
                    parseInt(graficBarPlus) * 100;
                this.graficBar.graficBarRight =
                    parseInt(this.stateObservation.unattended) /
                    parseInt(graficBarPlus) * 100;
                if (this.graficBar.graficBarLeft !== 0) {
                    this.graficBar.inActiveLeft = false;
                } 
                if (isNaN(this.graficBar.graficBarLeft)) {
                    this.graficBar.inActiveLeft = true;
                }
                if (this.graficBar.graficBarRight !== 0) {
                    this.graficBar.inActiveRight = false;
                } 
                if (isNaN(this.graficBar.graficBarRight)) {
                    this.graficBar.inActiveRight = true;
                }
            },
            calcTotalInPeriod() {
                this.stateObservation.total_in_period =
                    parseInt(this.stateObservation.planning) +
                    parseInt(this.stateObservation.plans) +
                    parseInt(this.stateObservation.specifications) +
                    parseInt(this.stateObservation.materials) +
                    parseInt(this.stateObservation.foundation) +
                    parseInt(this.stateObservation.vertical_elem) +
                    parseInt(this.stateObservation.mezzanines) +
                    parseInt(this.stateObservation.tank_pool) +
                    parseInt(this.stateObservation.metallic) +
                    parseInt(this.stateObservation.non_structural);
            },
            getDataChart() {
                this.dataChart = [
                    this.stateObservation.total_pending,
                    '0',
                    this.stateObservation.previous_open,
                    this.stateObservation.total_in_period,
                    this.stateObservation.closed_in_period,
                    '0',
                    this.stateObservation.planning,
                    this.stateObservation.plans,
                    this.stateObservation.specifications,
                    this.stateObservation.materials,
                    this.stateObservation.foundation,
                    this.stateObservation.vertical_elem,
                    this.stateObservation.mezzanines,
                    this.stateObservation.tank_pool,
                    this.stateObservation.metallic,
                    this.stateObservation.non_structural,

                ]
            },
            saveData() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                if (this.stateObservation.hashid === '') {
                    url += `/admin/project/${this.pProjectId}/state-observations`;

                    if (this.stateObservation.date === '') {
                        toastr.error('Debe seleccionar la fecha de actualización para poder continuar', 'Error!');
                        return false;
                    }

                    axios.post(url, this.stateObservation)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!');
                            this.loadStateObservation();
                        });
                } else {
                    url += `/admin/state-observations/${this.stateObservation.hashid}`;

                    if (this.stateObservation.date === '') {
                        toastr.error('Debe seleccionar la fecha de actualización para poder continuar', 'Error!');
                        return false;
                    }

                    axios.put(url, this.stateObservation)
                        .then(resp => {
                            toastr.success(resp.data.message, 'Mensaje!');
                            this.loadStateObservation();
                        });
                }
            }
        }
    }
</script>