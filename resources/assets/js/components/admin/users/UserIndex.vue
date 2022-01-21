<template>
    <div class="row">
        <div class="col-md-12">
            <table id="users-table" class="table table-striped table-hover table-bordered" cellspacing="0">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Perfil</th>
                    <th>Creado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['url-data'],
        mounted() {
            this.initDataTable();
        },
        methods: {
            initDataTable() {
                let vm = this;
                $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: vm.urlData,
                    initComplete() {
                        vm.$eventHideOverlay.$emit('hide');
                    },
                    columns: [
                        {data: 'full_name', name: 'full_name'},
                        {data: 'email', name: 'email'},
                        {data: 'role.name', name: 'role.name'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
            }
        }
    }
</script>