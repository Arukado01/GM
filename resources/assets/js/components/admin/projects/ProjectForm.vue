<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group" :class="{'has-danger': errors.has('txt_name')}">
                    <label for="txt_name">Nombre</label>
                    <input type="text" id="txt_name" name="txt_name" data-vv-as="Nombres"
                           v-validate="'required'" class="form-control" v-model="project.name"
                           :class="{'form-control-danger': errors.has('txt_name')}">
                    <div class="form-control-feedback" v-show="errors.has('txt_name')">
                        {{ errors.first('txt_name') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group" :class="{'has-danger': errors.has('txt_name')}">
                    <label for="slc_supervisor">Ing. Supervisor</label>
                    <select id="slc_supervisor" v-model="superVisorSelected" class="form-control">
                        <option v-for="user in users" :value="user.hashid">
                            {{ user.full_name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" :class="{'has-danger': errors.has('txt_location')}">
                    <label for="txt_location">Ubicación</label>
                    <input type="text" id="txt_location" name="txt_location" data-vv-as="Nombres"
                           v-validate="'required'" class="form-control" v-model="project.location"
                           :class="{'form-control-danger': errors.has('txt_location')}">
                    <div class="form-control-feedback" v-show="errors.has('txt_location')">
                        {{ errors.first('txt_location') }}
                    </div>
                </div>
            </div>
        </div>
        <div v-if="this.pAction === 'edit'">
            <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" :class="{'has-danger': errors.has('txt_name')}">
                        <label for="slc_supervisor"><strong>Asignar al Cliente:</strong></label>
                        <input type="text" id="slc_supervisor" v-model="queryString" class="form-control"
                               @keyup="getUsers"
                               placeholder="Digite el nombre del cliente">
                        <div class="panel-footer" v-if="usersClients.length">
                            <div class="list-group">
                                <a href="" class="list-group-item list-group-item-action"
                                   @click.prevent="addClient(userClient.hashid)"
                                   v-for="userClient in usersClients">
                                    {{ userClient.full_name }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="dt-clients" class="table table-hover table-bordered" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo Electrónico</th>
                            <th>Fecha de registro</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="" @click.prevent="goBack()" class="btn btn-outline-danger ml-auto">
                    <i class="fa fa-chevron-left"></i> Atrás
                </a>
                <a href="" @click.prevent="saveData()" class="btn btn-outline-primary ml-auto">
                    <i class="fa fa-save"></i> Guardar
                </a>
            </div>
        </div>
    </div>
</template>
<script>
    import AdminConf from './../../../admin_conf';

    export default {
        props: {
            pProject: {
                type: [Object, String],
                default() {
                    return {
                        name: '',
                        location: '',
                    }
                }
            },
            pUrlData: String,
            pAction: String,
        },
        data() {
            return {
                project: {},
                users: {},
                usersClients: {},
                queryString: '',
                superVisorSelected: null,
                clientSelected: null,
                dtClientes: null,
            }
        },
        mounted() {
            if (typeof this.pProject === 'string') {
                this.project = JSON.parse(this.pProject);
            } else {
                this.project = this.pProject;
            }

            let url = AdminConf.adminUrlBase() + AdminConf.adminApiUrlBase + '/admin/users/supervisor';

            axios.get(url)
                .then(resp => {
                    this.users = resp.data.users;
                    if(this.project.users) {
                        this.users.map(el => {
                            if (el.hashid === this.project.users[0].hashid) {
                                this.superVisorSelected = el.hashid;
                            }
                        });
                    }else{
                        this.$eventHideOverlay.$emit('hide');
                    }
                });

            if (this.pAction === 'edit')
                this.initDataTable();
        },
        methods: {
            goBack() {
                window.history.back();
            },
            getUsers() {
                let url = AdminConf.adminUrlBase() + AdminConf.adminApiUrlBase + '/admin/users/clients';
                this.usersClients = {};
                if (this.queryString) {
                    axios.get(url, {params: {queryString: this.queryString}})
                        .then(resp => {
                            if (resp.data.clients.length) {
                                this.usersClients = resp.data.clients;
                                /*this.clientSelected = this.usersClients[0].hashid;*/
                            }
                        });
                }
            },
            addClient(hashid) {
                this.queryString = '';
                this.clientSelected = hashid;
                this.usersClients = {};

                let url = AdminConf.adminUrlBase() + AdminConf.adminApiUrlBase +
                    `/admin/projects/${this.project.hashid}/clients/${this.clientSelected}`;

                axios.post(url)
                    .then(resp => {
                        toastr.success(resp.data.message, 'Mensaje!!');
                        this.dtClientes.ajax.reload();
                    })
                    .catch(resp => {
                        if(resp.response)
                            toastr.error(resp.response.data.message, 'Error!!');
                    });
            },
            saveData() {
                let url = AdminConf.adminUrlBase() + AdminConf.adminApiUrlBase +
                    `/admin/supervisor/${this.superVisorSelected}/projects`;
                if (this.project.hashid)
                    url += `/${this.project.hashid}`;

                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post(url, this.project)
                            .then(resp => {
                                toastr.options.onHidden = function () {
                                    window.location = resp.data.redirectTo;
                                };
                                toastr.success(resp.data.message, 'Mensaje!!');
                            });
                    }
                });
            },
            initDataTable() {
                let vm = this;

                vm.dtClientes = $('#dt-clients').DataTable({
                    language: AdminConf.langDataTable,
                    processing: true,
                    serverSide: true,
                    ajax: vm.pUrlData,
                    initComplete() {
                        vm.$eventHideOverlay.$emit('hide');
                    },
                    fnDrawCallback() {
                        let buttons = document.getElementsByClassName('btn-remove-relation');
                        if (buttons) {
                            [...buttons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('href');
                                axios.delete(url)
                                    .then(resp => {
                                        toastr.success(resp.data.message, 'Mensaje!');
                                        vm.dtClientes.ajax.reload();
                                    });
                            }));
                        }
                    },
                    order: [[2, 'desc']],
                    columns: [
                        {data: 'full_name', name: 'full_name'},
                        {data: 'email', name: 'email'},
                        {data: 'created_at', name: 'created_at', width: "18%"},
                        {data: 'action', name: 'action', orderable: false, searchable: false, width: "15%"}
                    ]
                });
            }
        }
    }
</script>