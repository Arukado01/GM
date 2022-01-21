<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="widget">
                    <div class="widget-header">
                        <h5>estado de observaciones</h5>
                    </div>
                    <hr class="widget-separator">
                    <div class="widget-body">
                        <overlay-component></overlay-component>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                Fecha de actualización: {{ stateObservation.date }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <chartjs-bar :labels="chart_labels" :data="dataChart" :bind="true"
                                             :option="optionsChart" :backgroundcolor="'#3f51b5'"
                                             :bordercolor="'#3f51b5'">
                                </chartjs-bar>
                                <div class="row">
                                    <div class="col-md-12 text-center pb-2 mt-5">
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
                                                <div v-bind:style="{ width: graficBar.graficBarRight + '%'}" v-bind:class="{inactive: graficBar.inActiveRight}" data-toggle="tooltip" data-placement="top" v-bind:data-original-title="'Sin Atender ' + stateObservation.unattended"></div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6 pr-1 text-right ">Atendidos: {{stateObservation.catered}}   |</div>
                                            <div class="col-6 pl-1 text-left ">|  Sin Atender: {{stateObservation.unattended}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-center ">Total: {{stateObservation.total_attended}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <table class="table graphic-table-cliente">
                                    <tbody>
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <strong>RESUMEN</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Pendientes</td>
                                        <td class="text-right">{{ stateObservation.total_pending }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2" style="width: 100%"></td>
                                        <td class="p-2" style="width: 100%"></td>
                                    </tr>
                                    <tr>
                                        <td>Abiertas Anteriores</td>
                                        <td class="text-right text-info">{{ stateObservation.previous_open }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total en Periodo</td>
                                        <td class="text-right text-info">{{ stateObservation.total_in_period }}</td>
                                    </tr>
                                    <tr>
                                        <td>Cerradas en Periodo</td>
                                        <td class="text-right text-info">{{ stateObservation.closed_in_period }}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2" style="width: 100%"></td>
                                        <td class="p-2" style="width: 100%"></td>
                                    </tr>
                                    <tr>
                                        <td>(A) Planeación</td>
                                        <td class="text-right text-info">{{ stateObservation.planning }}</td>
                                    </tr>
                                    <tr>
                                        <td>(B) Planos</td>
                                        <td class="text-right text-info">{{ stateObservation.plans }}</td>
                                    </tr>
                                    <tr>
                                        <td>(C) Especificaciones</td>
                                        <td class="text-right text-info">{{ stateObservation.specifications }}</td>
                                    </tr>
                                    <tr>
                                        <td>(D) Materiales</td>
                                        <td class="text-right text-info">{{ stateObservation.materials }}</td>
                                    </tr>
                                    <tr>
                                        <td>(E) Cimentación</td>
                                        <td class="text-right text-info">{{ stateObservation.foundation }}</td>
                                    </tr>
                                    <tr>
                                        <td>(F) Elem. Verticales</td>
                                        <td class="text-right text-info">{{ stateObservation.vertical_elem }}</td>
                                    </tr>
                                    <tr>
                                        <td>(G) Entrepisos</td>
                                        <td class="text-right text-info">{{ stateObservation.mezzanines }}</td>
                                    </tr>
                                    <tr>
                                        <td>(H) Tanque/Piscina</td>
                                        <td class="text-right text-info">{{ stateObservation.tank_pool }}</td>
                                    </tr>
                                    <tr>
                                        <td>(I) Metálicas</td>
                                        <td class="text-right text-info">{{ stateObservation.metallic }}</td>
                                    </tr>
                                    <tr>
                                        <td>(J) No estructurales</td>
                                        <td class="text-right text-info">{{ stateObservation.non_structural }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Config from './../admin_conf';

    moment.locale('es');
    export default {
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
                    total_attended: 0,
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
                        text: ''
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
        mounted() {
            this.loadStateObservation();
        },
        methods: {
            loadStateObservation() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                url += `/project/${this.pProjectId}/state-observations`;

                axios.get(url)
                    .then(resp => {
                        if (resp.data.length > 0) {
                            this.stateObservation = resp.data[0];
                            this.getDataChart();
                            this.getDataGraficBar();
                            this.$eventHideOverlayComponent.$emit('hideOverlayComponent');
                        }
                    });
            },
            getDataGraficBar() {
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
            }
        }
    }
</script>