<template>
    <div>
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
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    import Config from './../../admin_conf';
    export default {
        props: {
            urlDataSettlementControl: String,
            pProjectId: String,
        },
        data(){
            return {
                dataTableSettlementControl: null
            }
        },
        mounted(){
          this.initDataTable();
        },
        methods: {
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
                    columns: [
                        {data: 'zone', name: 'zone', orderable: false},
                        {data: 'start_date', name: 'start_date', orderable: true, searchable: true},
                        {data: 'last_date', name: 'last_date', orderable: true, searchable: true},
                        {data: 'max_area', name: 'max_area', orderable: false, searchable: false},
                        {data: 'observations', name: 'observations', orderable: false, searchable: false},
                    ]
                });
            },
        }
    }
</script>