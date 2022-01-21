<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <table id="reports-table" class="table table-hover table-bordered" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Proyecto</th>
                        <th>Ubicación</th>
                        <th>Ing. Supervisor</th>
                        <th>Fecha de registro</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    import Config from './../../../admin_conf';
    export default {
        props: ['url-data'],
        mounted() {
            this.initDataTable();
        },
        methods: {
            initDataTable() {
                let vm = this;
                $('#reports-table').DataTable({
                    language: Config.langDataTable,
                    processing: true,
                    serverSide: true,
                    ajax: vm.urlData,
                    drawCallback(){
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    initComplete() {
                        vm.$eventHideOverlay.$emit('hide');
                    },
                    order: [[ 3, "desc" ]],
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'location', name: 'location'},
                        {data: 'full_name', name: 'users.full_name', orderable: false, searchable: false},
                        {data: 'created_at', name: 'created_at', width: "18%"},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
            }
        }
    }
</script>