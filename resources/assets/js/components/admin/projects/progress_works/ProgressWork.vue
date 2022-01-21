<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Avance de Obra</h5>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" :class="{'has-danger': progressWorkErrors.zone}">
                                    <label for="txt_zone">Zona</label>
                                    <input type="text" id="txt_zone" v-model="progressWork.zone" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" :class="{'has-danger': progressWorkErrors.piloting}">
                                    <label for="txt_piloting">Pilotaje</label>
                                    <input type="number" min="0" max="100" id="txt_piloting"
                                           v-model="progressWork.piloting" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" :class="{'has-danger': progressWorkErrors.foundation}">
                                    <label for="txt_foundation">Cimentación</label>
                                    <input type="number" min="0" max="100" id="txt_foundation"
                                           v-model="progressWork.foundation" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" :class="{'has-danger': progressWorkErrors.structure}">
                                    <label for="txt_structure">Estructura</label>
                                    <input type="number" min="0" max="100" id="txt_structure"
                                           v-model="progressWork.structure" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" :class="{'has-danger': progressWorkErrors.masonry}">
                                    <label for="txt_masonry">Mampostería</label>
                                    <input type="number" min="0" max="100" id="txt_masonry"
                                           v-model="progressWork.masonry" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <a href="" @click.prevent="saveData()" class="btn btn-outline-primary" v-if="!isEdit">
                                    <i class="fa fa-save"></i> Guardar
                                </a>
                                <template v-else>
                                    <a href="" @click.prevent="cleanForm()" class="btn btn-outline-warning">
                                        <i class="fa fa-ban"></i> Cancelar
                                    </a>
                                    <a href="" @click.prevent="saveData()" class="btn btn-outline-success">
                                        <i class="fa fa-edit"></i> Editar
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Listado</h5>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <h5>
                                    Fecha de Actualización
                                </h5>
                                {{ progress_work_update_format }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
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
                                        <th>Acciones</th>
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
    import Config from './../../../../admin_conf';

    moment.locale('es');

    export default {
        props: {
            pProjectId: String,
            urlDataProgressWorks: String,
            pLastUpdate: String
        },
        data() {
            return {
                dataTableProgressWork: null,
                progress_work_update: '',
                progress_work_update_format: 'No se ha registrado ninguna fecha',
                isEdit: false,
                progressWork: {
                    zone: '',
                    piloting: 0,
                    foundation: 0,
                    structure: 0,
                    masonry: 0
                },
                progressWorkErrors: {
                    zone: false,
                    piloting: false,
                    foundation: false,
                    structure: false,
                    masonry: false
                }
            }
        },
        mounted() {
            this.progress_work_update = this.pLastUpdate;
            this.$eventHideOverlay.$emit('hide');

            this.initDataTable();
        },
        watch: {
            'progressWork.zone': function (val) {
                this.progressWorkErrors.zone = val === '';
            },
            'progressWork.piloting': function (val) {
                if (val > 100) {
                    this.progressWorkErrors.piloting = true;
                    toastr.error('El valor del campo Pilotaje no puede ser mayor a 100.');
                } else {
                    this.progressWorkErrors.piloting = false;
                }
            },
            'progressWork.foundation': function (val) {
                if (val > 100) {
                    this.progressWorkErrors.foundation = true;
                    toastr.error('El valor del campo Cimentación no puede ser mayor a 100.');
                } else {
                    this.progressWorkErrors.foundation = false;
                }
            },
            'progressWork.structure': function (val) {
                if (val > 100) {
                    this.progressWorkErrors.structure = true;
                    toastr.error('El valor del campo Estructura no puede ser mayor a 100.');
                } else {
                    this.progressWorkErrors.structure = false;
                }
            },
            'progressWork.masonry': function (val) {
                if (val > 100) {
                    this.progressWorkErrors.masonry = true;
                    toastr.error('El valor del campo Mampostería no puede ser mayor a 100.');
                } else {
                    this.progressWorkErrors.masonry = false;
                }
            },
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
        methods: {
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
                    fnDrawCallback() {
                        let buttons = document.getElementsByClassName('btn-edit-progress-work');
                        if (buttons) {
                            [...buttons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');
                                let tr = button.parentNode.parentElement.parentElement.parentElement;
                                let data = vm.dataTableProgressWork.row(tr).data();
                                console.log(data);

                                vm.progressWork.hashid = data.hashid;
                                vm.progressWork.zone = data.zone;
                                vm.progressWork.piloting = data.piloting_value;
                                vm.progressWork.foundation = data.foundation_value;
                                vm.progressWork.structure = data.structure_value;
                                vm.progressWork.masonry = data.masonry_value;

                                vm.isEdit = true;
                            }));
                        } else {
                            vm.dataTableProgressWork.column(6).visible(false);
                        }

                        let deleteButtons = document.getElementsByClassName('btn-delete-progress-work');
                        if (deleteButtons) {
                            [...deleteButtons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');

                                axios.delete(url)
                                    .then(resp => {
                                        toastr.success(resp.data.message, 'Mensaje!');
                                        vm.dataTableProgressWork.ajax.reload();
                                    });
                            }));
                        }
                    },
                    columns: [
                        {data: 'zone', name: 'zone', orderable: false},
                        {data: 'piloting', name: 'piloting', orderable: false, searchable: true},
                        {data: 'foundation', name: 'foundation', orderable: false, searchable: true},
                        {data: 'structure', name: 'structure', orderable: false, searchable: false},
                        {data: 'masonry', name: 'masonry', orderable: false, searchable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
            },
            valObjectError() {
                for (let err in this.progressWorkErrors) {
                    if (this.progressWorkErrors[err]) {
                        return false;
                    }
                }
                return true;
            },
            cleanForm() {
                this.$cleanObjectValues(this.progressWork, 0, 0);
                this.progressWork.zone = '';

                this.isEdit = false;
                this.$cleanObjectValues(this.progressWorkErrors, 0, false);
            },
            saveData() {
                let url = Config.adminUrlBase()
                    + Config.adminApiUrlBase;

                if (this.progressWork.zone !== '') {
                    if (this.valObjectError()) {
                        if (!this.isEdit) {
                            url += `/admin/projects/${this.pProjectId}/progress-works`;

                            axios.post(url, this.progressWork)
                                .then(resp => {
                                    toastr.success(resp.data.message, 'Mensaje!');
                                    this.dataTableProgressWork.ajax.reload();
                                    this.progress_work_update = resp.data.last_update;
                                    this.cleanForm();
                                });
                        } else {
                            url += `/admin/projects/progress-works/${this.progressWork.hashid}`;

                            axios.put(url, this.progressWork)
                                .then(resp => {
                                    toastr.success(resp.data.message, 'Mensaje!');
                                    this.dataTableProgressWork.ajax.reload();
                                    this.progress_work_update = resp.data.last_update;
                                    this.cleanForm();
                                });
                        }
                    } else {
                        toastr.error('No se puede almacenar la información, por favor rectifique e intente de nuevo.', 'Error!!');
                    }
                } else {
                    this.progressWorkErrors.zone = true;
                    toastr.error('El campo Zona no puede estar vacío.', 'Error!!');
                }
            }
        }
    }
</script>