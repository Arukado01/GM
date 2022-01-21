<template>
    <div>
        <!--<div class="card">
            <div class="card-header" style="text-transform: uppercase;">
                <h6 style="font-weight: 500;">Resultados de ensayos a tracción y cortante de mallas</h6>
            </div>
            <div class="card-block">
                <div class="row mb-2">
                    <div class="col-md-12">
                        Fecha de Actualización {{ sample_mesh_update_format }}
                    </div>
                </div>
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
                                <th>P sold. <br>Mín. [kg]</th>
                                <th>P sold. <br>[kg]</th>
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
                        <p v-if="meshSampleObservationsData.length <= 0">
                            No hay observaciones disponibles
                        </p>
                        <div v-else>
                            <blockquote class="blockquote"
                                        v-for="meshSampleObservation in meshSampleObservationsData">
                                <p>{{ meshSampleObservation.observations }}</p>
                                <hr>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <div class="card">
            <div class="card-header" style="text-transform: uppercase;">
                <h6 style="font-weight: 500;">ENSAYOS TRACCIÓN Y CORTANTE MALLAS</h6>
            </div>
            <div class="card-block">
                <div class="row mb-2">
                    <div class="col-md-12">
                        Fecha de Actualización {{ verify_mesh_update_format }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="mesh-quantity-sample-table"
                               class="table table-hover table-bordered"
                               style="width: 100% !important;" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ZONA</th>
                                <th>Área Aprox.<br>[m<sup>2</sup>]</th>
                                <th>Consumo Aprox. <br>[Ton]</th>
                                <th>%Avance Aprox. Estructura</th>
                                <th>Ensayos Teóricos.<br>(c/50Tn)</th>
                                <th>Ensayos Ejecutados</th>
                                <th>Ensayos <br>por Validar</th>
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
            pSampleMesh: String,
            pVerifyMesh: String,
            urlDataMeshSamples: String,
            urlDataMeshQuantitySample: String,
            pProjectId: String,
        },
        data() {
            return {
                sample_mesh_update: '',
                sample_mesh_update_format: 'No se ha registrado ninguna fecha',
                verify_mesh_update: '',
                verify_mesh_update_format: 'No se ha registrado ninguna fecha',
                meshSampleObservationsData: [],
                quantityCheckSampleObservationsData: [],
            }
        },
        watch: {
            sample_mesh_update(val) {
                if (val !== '') {
                    let date = moment(val);
                    this.sample_mesh_update_format = this.$dateStringFormat(date);
                } else {
                    this.sample_mesh_update_format = 'No se ha registrado ninguna fecha';
                    this.sample_mesh_update = '';
                }
            },
            verify_mesh_update(val) {
                if (val !== '') {
                    let date = moment(val);
                    this.verify_mesh_update_format = this.$dateStringFormat(date);
                } else {
                    this.verify_mesh_update_format = 'No se ha registrado ninguna fecha';
                    this.verify_mesh_update = '';
                }
            }
        },
        mounted() {
            this.sample_mesh_update = this.pSampleMesh;
            this.verify_mesh_update = this.pVerifyMesh;

            this.initDataTable();
            this.loadMeshSampleObservations();
            this.initQuantityCheckSampleTable();
            this.loadQuantityCheckSampleObservation();
        },
        methods: {
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
                    columns: [
                        {data: 'date', name: 'date', orderable: false},
                        {data: 'use', name: 'use', orderable: false, searchable: true},
                        {data: 'diameter', name: 'diameter', orderable: false, searchable: true},
                        {data: 'fy_mpa', name: 'fy_mpa', orderable: false, searchable: false},
                        {data: 'fu_mpa', name: 'fu_mpa', orderable: false, searchable: false},
                        {data: 'p_sold_min', name: 'p_sold_min', orderable: false, searchable: false},
                        {data: 'p_sold', name: 'p_sold', orderable: false, searchable: false},
                        {data: 'observations', name: 'observations', orderable: false, searchable: false}
                    ]
                });
            },
            loadMeshSampleObservations() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase + `/project/${this.pProjectId}/mesh-sample-observations`;

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
            initQuantityCheckSampleTable() {
                let vm = this;
                vm.dataTableMeshQuantityCheckSample = $('#mesh-quantity-sample-table').DataTable({
                    language: Config.langDataTable,
                    processing: true,
                    serverSide: true,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos Los Registros"]],
                    ajax: {
                        url: vm.urlDataMeshQuantitySample,
                        error(resp) {
                            if (resp.status === 500)
                                toastr.error('Pedimos disculpas ha ocurrido un error interno<br>Por favor refresque la pagina.', 'Error!');
                        }
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
                        {
                            data: 'pending_test_validation',
                            name: 'pending_test_validation',
                            orderable: false,
                            searchable: false,
                            width: "5%"
                        },
                    ]
                });
            },
            loadQuantityCheckSampleObservation() {
                let url = Config.adminUrlBase() + Config.adminApiUrlBase
                    + `/project/${this.pProjectId}/quantity-check-sample-observations?quantity_check_type=mesh`;

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
        }
    }
</script>