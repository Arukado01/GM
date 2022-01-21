<template>
    <div>
        <div class="card">
            <div class="card-header" style="text-transform: uppercase;">
                <h6 style="font-weight: 500;">Ensayos pendiente por validación</h6>
            </div>
            <div class="card-block">
                <div class="row mb-2">
                    <div class="col-md-12">
                        Fecha de Actualización {{ sample_concrete_update_format }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="concrete-samples-table" class="table table-hover table-bordered" cellspacing="0">
                            <thead>
                            <tr>
                                <th rowspan="2">Fecha</th>
                                <th rowspan="2">Destino</th>
                                <th rowspan="2">Tipo</th>
                                <th rowspan="2">Muestra</th>
                                <th colspan="4">Ensayos Pendientes (Días)</th>
                                <th colspan="4">Validaciones Pendientes</th>
                            </tr>
                            <tr>
                                <th>7</th>
                                <th>14</th>
                                <th>28</th>
                                <th>56</th>
                                <th>Testigos 56 Días</th>
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
                        <h5>Observaciones</h5>
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
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" style="text-transform: uppercase;">
                <h6 style="font-weight: 500;">HALLAZGOS EN CANTIDAD DE CILINDROS TOMADOS EN LOS ULTIMOS 60 DÍAS</h6>
            </div>
            <div class="card-block">
                <div class="row mb-2">
                    <div class="col-md-12">
                        Fecha de Actualización {{ verify_concrete_update_format }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="concrete-quantity-test-table"
                               class="table table-hover table-bordered"
                               cellspacing="0">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Destino</th>
                                <th>M<sup>3</sup><br>Fundida</th>
                                <th>Cant. Muestras<br>Teóricas</th>
                                <th>Cant. Muestras<br>Tomadas</th>
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
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import AdminConf from "./../../admin_conf";

    export default {
        props: {
            pSampleConcrete: String,
            pVerifyConcrete: String,
            urlDataConcreteSamples: String,
            pProjectId: String
        },
        data() {
            return {
                sample_concrete_update: '',
                sample_concrete_update_format: 'No se ha registrado ninguna fecha',
                verify_concrete_update: '',
                verify_concrete_update_format: 'No se ha registrado ninguna fecha',
                concreteSampleObservations: [],
                quantityConcreteSampleObservations: []
            }
        },
        mounted() {
            this.sample_concrete_update = this.pSampleConcrete;
            this.verify_concrete_update = this.pVerifyConcrete;

            this.initDataTable();
            let url = AdminConf.adminUrlBase()
                + AdminConf.adminApiUrlBase + `/project/${this.pProjectId}/concrete-sample-observations`;

            axios.get(url)
                .then(resp => {
                    this.concreteSampleObservations = resp.data
                });

            this.initConcreteVerifyTable();
            this.loadQuantityConcreteSampleObservation();
        },
        watch: {
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
        methods: {
            initDataTable() {
                let vm = this;
                vm.dataTableConcreteSamples = $('#concrete-samples-table').DataTable({
                    language: AdminConf.langDataTable,
                    processing: true,
                    serverSide: true,
                    ajax: vm.urlDataConcreteSamples,
                    drawCallback() {
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    initComplete() {
                        vm.$eventHideOverlay.$emit('hide');
                    },
                    columns: [
                        {data: 'date', name: 'date', orderable: false,},
                        {data: 'destination', name: 'destination', orderable: false, searchable: false},
                        {data: 'type', name: 'type', orderable: false, searchable: false},
                        {data: 'sample', name: 'sample', orderable: false, searchable: false,},
                        {
                            data: 'fc_seven_days',
                            name: 'fc_seven_days',
                            orderable: false,
                            searchable: false,
                            width: "10%"
                        },
                        {
                            data: 'fc_fourteen_days',
                            name: 'fc_fourteen_days',
                            orderable: false,
                            searchable: false,
                            width: "10%"
                        },
                        {
                            data: 'fc_twenty_eight_days',
                            name: 'fc_twenty_eight_days',
                            orderable: false,
                            searchable: false,
                            width: "10%"
                        },
                        {
                            data: 'fc_fifty_six_days',
                            name: 'fc_fifty_six_days',
                            orderable: false,
                            searchable: false,
                            width: "10%"
                        },
                        {data: 't_56_days', name: 't_56_days', orderable: false, searchable: false, width: '10%'},
                        {data: 'sclerometry', name: 'sclerometry', orderable: false, searchable: false, width: '10%'},
                        {data: 'provider', name: 'provider', orderable: false, searchable: false, width: '10%'},
                        {data: 'cores', name: 'cores', orderable: false, searchable: false, width: '10%'},
                    ]
                });
            },
            initConcreteVerifyTable() {
                let vm = this;
                let url = AdminConf.adminUrlBase()
                    + AdminConf.adminApiUrlBase + `/project/${this.pProjectId}/get-quantity-check-concrete-test-data`;

                vm.dataTableConcreteQuantityTest = $('#concrete-quantity-test-table').DataTable({
                    language: AdminConf.langDataTable,
                    processing: true,
                    serverSide: true,
                    ajax: url,
                    drawCallback() {
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    initComplete() {
                        vm.$eventHideOverlay.$emit('hide');
                    },
                    columns: [
                        {data: 'date', name: 'date', orderable: false},
                        {data: 'destination', name: 'destination', orderable: false, searchable: false},
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
                        {data: 'observation', name: 'observation', orderable: false, searchable: false}
                    ]
                });
            },
            loadQuantityConcreteSampleObservation() {
                let url = AdminConf.adminUrlBase() + AdminConf.adminApiUrlBase
                    + `/project/${this.pProjectId}/quantity-concrete-sample-observations`;

                axios.get(url)
                    .then(resp => {
                        this.quantityConcreteSampleObservations = resp.data
                    });
            },
        }
    }
</script>