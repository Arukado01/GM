<template>
    <div class="row">
        <div class="col-md-12">
            <div class="widget">
                <div class="widget-header">
                    <h5>Avances de Obra</h5>
                </div>
                <hr class="widget-separator">
                <div class="card-block">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            Fecha de Actualización {{ progress_work_update_format }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="progress-work-table" class="table table-hover table-bordered"
                                   style="width: 100% !important;" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Zona</th>
                                    <th>Pilotaje</th>
                                    <th>Cimentación</th>
                                    <th>Estructura</th>
                                    <th>Mampostería</th>
                                </tr>
                                </thead>
                            </table>
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
        props: {
            urlDataProgressWorks: String,
            pLastUpdate: String
        },
        data(){
            return {
                dataTableProgressWork: null,
                progress_work_update: '',
                progress_work_update_format: 'No se ha registrado ninguna fecha',
            }
        },
        mounted(){
            this.progress_work_update = this.pLastUpdate;
            this.initDataTable();
        },
        watch: {
            progress_work_update(val) {
                if (val !== '') {
                    let date = moment(val);
                    this.progress_work_update_format = this.$dateStringFormat(date);
                } else {
                    this.progress_work_update_format = 'No se ha registrado ninguna fecha';
                    this.progress_work_update = '';
                }
            }
        },
        methods:{
            initDataTable() {
                let vm = this;
                vm.dataTableProgressWork = $('#progress-work-table').DataTable({
                    language: Config.langDataTable,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: vm.urlDataProgressWorks,
                        error(resp) {
                            console.log(resp);
                            if (resp.status === 500)
                                toastr.error('Pedimos disculpas ha ocurrido un error interno<br>Por favor refresque la pagina.', 'Error!');
                        }
                    },
                    initComplete() {
                        vm.$eventHideOverlay.$emit('hide');
                    },
                    columns: [
                        {data: 'zone', name: 'zone', orderable: false},
                        {data: 'piloting', name: 'piloting', orderable: false, searchable: true, width: '20%'},
                        {data: 'foundation', name: 'foundation', orderable: false, searchable: true, width: '20%'},
                        {data: 'structure', name: 'structure', orderable: false, searchable: false, width: '20%'},
                        {data: 'masonry', name: 'masonry', orderable: false, searchable: false, width: '20%'},
                    ]
                });
            },
        }
    }
</script>