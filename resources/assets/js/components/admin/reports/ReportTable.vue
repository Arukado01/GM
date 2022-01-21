<template>
    <div class="row">
        <div class="col-md-12">
            <table id="reports-table" class="table table-striped table-hover table-bordered" cellspacing="0">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Ruta Pdf</th>
                    <th>Fecha de realización</th>
                    <th>Fecha de registro</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</template>
<script>
    import Config from '../../../admin_conf';
    import {EventBus} from '../../../EventBus';

    export default {
        props: ['url-data'],
        data() {
            return {
                reportTable: null,
            }
        },
        mounted() {
            let vm = this;
            EventBus.$on('refresh-table-reports', () => {
                console.log('entro');
                vm.reportTable.ajax.reload();
            });

            this.initDataTable();
        },
        methods: {
            initDataTable() {
                let vm = this;
                vm.reportTable = $('#reports-table').DataTable({
                    processing: true,
                    serverSide: true,
                    language: Config.langDataTable,
                    ajax: vm.urlData,
                    initComplete() {
                        vm.$eventHideOverlay.$emit('hide');
                    },
                    fnDrawCallback() {
                        let deleteButtons = document.getElementsByClassName('btn-delete-report');
                        if (deleteButtons) {
                            [...deleteButtons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');

                                swal({
                                    title: "¿Esta usted seguro de eliminar el Reporte?",
                                    text: "Tenga en cuanta que al eliminar este recurso no podrá recuperarlo.",
                                    icon: "warning",
                                    closeOnClickOutside: false,
                                    buttons: {
                                        cancel: {
                                            text: "Cancelar",
                                            value: null,
                                            visible: true,
                                            closeModal: true,
                                        },
                                        confirm: {
                                            text: "Eliminar",
                                            value: true,
                                            visible: true,
                                            className: "",
                                            closeModal: true
                                        }
                                    },
                                    dangerMode: true,
                                }).then((willDelete) => {
                                    if (willDelete) {
                                        axios.delete(url)
                                            .then(resp => {
                                                swal(resp.data.message, {
                                                    icon: "success",
                                                }).then(() => {
                                                    vm.reportTable.ajax.reload();
                                                });
                                            });
                                    }
                                });

                            }));
                        }
                    },
                    columns: [
                        {data: 'title', name: 'title'},
                        {data: 'url', name: 'url'},
                        {data: 'start', name: 'start'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'action', name: 'action'},
                    ]
                });
            }
        }
    }
</script>