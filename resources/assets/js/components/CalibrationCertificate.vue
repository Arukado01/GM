<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="widget">
                    <div class="widget-header">
                        <h5>
                            Certificados de Calibración
                        </h5>
                    </div>
                    <hr class="widget-separator">
                    <div class="widget-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="certificates-table" class="table table-hover table-bordered"
                                       cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Tipo de Ensayo</th>
                                        <th>Fecha de Calibración</th>
                                        <th>Fecha de Expiración</th>
                                        <th>Chequeo</th>
                                        <th>Archivo</th>
                                    </tr>
                                    </thead>
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
    import admin_config from '../admin_conf';
    export default {
        props: ['p-url-table-data'],
        data() {
            return {
                certificatesTable: null,
            }
        },
        mounted() {
            this.initDataTable();
        },
        methods: {
            initDataTable() {
                let vm = this;
                vm.certificatesTable = $('#certificates-table').DataTable({
                    processing: true,
                    serverSide: true,
                    language: admin_config.langDataTable,
                    ajax: vm.pUrlTableData,
                    order: [[ 1, "asc" ]],
                    initComplete() {
                        vm.$eventHideOverlay.$emit('hide');
                    },
                    columns: [
                        {data: 'sample_type', name: 'sample_type', orderable: false},
                        {data: 'calibration_date', name: 'calibration_date', orderable: true},
                        {data: 'expiration_date', name: 'expiration_date', orderable: false},
                        {data: 'check', name: 'check', orderable: false},
                        {data: 'path', name: 'path', orderable: false},
                    ]
                });
            }
        }
    }
</script>