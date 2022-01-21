<template>
    <div>
        <!--<div class="card">
            <div class="card-header" style="text-transform: uppercase;">
                <h6 style="font-weight: 500;">Resultado de ensayos a tracción de acero</h6>
            </div>
            <div class="card-block">
                <div class="row mb-2">
                    <div class="col-md-12">
                        Fecha de Actualización {{ sample_steel_update_format }}
                    </div>
                </div>
                &lt;!&ndash;<div class="row">
                    <div class="col-md-12">
                        <table id="steel-samples-table" class="table table-hover table-bordered"
                               style="width: 100% !important;"
                               cellspacing="0">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Uso</th>
                                <th>Tipo</th>
                                <th>Fy [MPa]</th>
                                <th>Fu [MPa]</th>
                                <th>Observaciones</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <h5>Observaciones</h5>
                    </div>
                </div>&ndash;&gt;&lt;!&ndash;
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
                            </blockquote>
                        </div>
                    </div>
                </div>&ndash;&gt;
            </div>
        </div>-->
        <div class="card">
            <div class="card-header" style="text-transform: uppercase;">
                <h6 style="font-weight: 500;">ENSAYOS TRACCIÓN ACERO</h6>
            </div>
            <div class="card-block">
                <div class="row mb-2">
                    <div class="col-md-12">
                        Fecha de Actualización {{ verify_steel_update_format }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="steel-quantity-sample-table"
                               class="table table-hover table-bordered"
                               style="width: 100% !important;" cellspacing="0">
                            <thead>
                            <tr>
                                <th class="text-center" style="vertical-align: middle">ZONA</th>
                                <th class="text-center" style="vertical-align: middle">
                                    Área Aprox.<br>[m<sup>2</sup>]
                                </th>
                                <th class="text-center" style="vertical-align: middle">
                                    Consumo Aprox. <br>[Ton]
                                </th>
                                <th class="text-center" style="vertical-align: middle">%Avance Aprox. Estructura</th>
                                <th class="text-center" style="vertical-align: middle">
                                    Ensayos Teóricos.<br>(c/50Tn)
                                </th>
                                <th class="text-center" style="vertical-align: middle">Ensayos Ejecutados</th>
                                <th class="text-center" style="vertical-align: middle">Ensayos <br>por Validar</th>
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
                        <h5>Observaciones</h5>
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
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Config from './../../admin_conf';

    export default {
        props: {
            pSampleSteel: String,
            pVerifySteel: String,
            urlDataSteelSamples: String,
            urlDataSteelQuantitySample: String,
            pProjectId: String,
        },
        data() {
            return {
                sample_steel_update: '',
                sample_steel_update_format: 'No se ha registrado ninguna fecha',
                verify_steel_update: '',
                verify_steel_update_format: 'No se ha registrado ninguna fecha',
                steelSampleObservationsData: [],
                dataTableSteelSamples: null,
                quantityCheckSampleObservationsData: [],
                dataTableSteelQuantityCheckSample: null,
            }
        },
        mounted() {
            this.sample_steel_update = this.pSampleSteel;
            this.verify_steel_update = this.pVerifySteel;

            this.initDataTable();
            this.loadSteelSampleObservations();

            this.initQuantityCheckSampleTable();
            this.loadQuantityCheckSampleObservation();
        },
        watch: {
            sample_steel_update(val){
                if(val !== '') {
                    let date = moment(val);
                    this.sample_steel_update_format = this.$dateStringFormat(date);
                }else{
                    this.sample_steel_update_format = 'No se ha registrado ninguna fecha';
                    this.sample_steel_update = '';
                }
            },
            verify_steel_update(val){
                if(val !== '') {
                    let date = moment(val);
                    this.verify_steel_update_format = this.$dateStringFormat(date);
                }else{
                    this.verify_steel_update_format = 'No se ha registrado ninguna fecha';
                    this.verify_steel_update = '';
                }
            }
        },
        methods: {
            initDataTable() {
                let vm = this;
                vm.dataTableSteelSamples = $('#steel-samples-table').DataTable({
                    language: Config.langDataTable,
                    processing: true,
                    serverSide: true,
                    ajax: vm.urlDataSteelSamples,
                    initComplete() {
                        vm.$eventHideOverlay.$emit('hide');
                    },
                    columns: [
                        {data: 'date', name: 'date', orderable: false},
                        {data: 'use', name: 'use', orderable: false, searchable: true},
                        {data: 'type', name: 'type', orderable: false, searchable: true},
                        {data: 'fy_mpa', name: 'fy_mpa', orderable: false, searchable: false},
                        {data: 'fu_mpa', name: 'fu_mpa', orderable: false, searchable: false},
                        {
                            data: 'observations',
                            name: 'observations',
                            orderable: false,
                            searchable: false,
                            width: '100%'
                        },
                    ]
                });
            },
            loadSteelSampleObservations() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase + `/project/${this.pProjectId}/steel-sample-observations`;

                axios.get(url)
                    .then(resp => {
                        this.steelSampleObservationsData = resp.data
                    });
            },
            initQuantityCheckSampleTable() {
                let vm = this;
                vm.dataTableSteelQuantityCheckSample = $('#steel-quantity-sample-table').DataTable({
                    language: Config.langDataTable,
                    processing: true,
                    serverSide: true,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos Los Registros"]],
                    ajax: vm.urlDataSteelQuantitySample,
                    drawCallback() {
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    initComplete() {
                        vm.$eventHideOverlay.$emit('hide');
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
                            width: "10%"
                        },
                        {data: 'test_performed', name: 'test_performed', orderable: false, searchable: false},
                        {data: 'pending_test_validation', name: 'pending_test_validation', orderable: false, searchable: false},
                    ]
                });
            },
            loadQuantityCheckSampleObservation() {
                let url = Config.adminUrlBase() + Config.adminApiUrlBase
                    + `/project/${this.pProjectId}/quantity-check-sample-observations?quantity_check_type=steel`;

                axios.get(url)
                    .then(resp => {
                        this.quantityCheckSampleObservationsData = resp.data
                    });
            },
        }
    }
</script>