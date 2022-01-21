<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group" :class="{'has-danger': errors.has('txt_first_name')}">
                    <label for="txt_first_name">Nombres</label>
                    <input type="text" id="txt_first_name" name="txt_first_name" data-vv-as="Nombres"
                           v-validate="'required'" class="form-control" v-model="user.first_name"
                           :class="{'form-control-danger': errors.has('txt_first_name')}">
                    <div class="form-control-feedback" v-show="errors.has('txt_first_name')">
                        {{ errors.first('txt_first_name') }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" :class="{'has-danger': errors.has('txt_last_name')}">
                    <label for="txt_last_name">Apellidos</label>
                    <input type="text" id="txt_last_name" name="txt_last_name" data-vv-as="Apellidos"
                           v-validate="'required'" class="form-control" v-model="user.last_name"
                           :class="{'form-control-danger': errors.has('txt_last_name')}">
                    <div class="form-control-feedback" v-show="errors.has('txt_last_name')">
                        {{ errors.first('txt_last_name') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group" :class="{'has-danger': errors.has('txt_email')}">
                    <label for="txt_email">Email</label>
                    <input type="text" id="txt_email" name="txt_email" data-vv-as="Correo Electrónico"
                           v-validate="'required|email'" class="form-control" v-model="user.email"
                           :class="{'form-control-danger': errors.has('txt_email')}">
                    <div class="form-control-feedback" v-show="errors.has('txt_email')">
                        {{ errors.first('txt_email') }}
                    </div>
                </div>
            </div>
            <div class="col-md-6" v-if="this.pIsAdmin == 1">
                <div class="form-group">
                    <label for="slt_roles">
                        Perfil
                    </label>
                    <select id="slt_roles" v-model="roleSelected" class="form-control">
                        <option v-for="role in roles" :value="role.hashid">
                            {{ role.name }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group" :class="{'has-danger': psw_error}">
                        <label for="txt_psw">Generar Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-btn" @mouseover="showPswInfo = true"
                                  @mouseleave="showPswInfo = false">
                                <a href="#" @click.prevent="togglePassword()" class="btn btn-secondary">
                                    <i class="fa" :class="[pswType == 'password' ? 'fa-eye' : 'fa-eye-slash']"></i>
                                </a>
                            </span>
                            <input id="txt_psw" disabled="disabled" class="form-control" ref="inputPassword" v-model="user.password"
                                   type="password">
                            <span class="input-group-btn" @mouseover="showGenPswInfo=true"
                                  @mouseleave="showGenPswInfo=false">
                                <a href="#" @click="genPassword()" class="btn btn-secondary">
                                    <i class="fa fa-refresh"></i> Generar
                                </a>
                            </span>
                        </div>
                        <div class="text-primary text-helper-tooltip">
                            <span v-show="showPswInfo">
                                Presione para {{ pswType == 'password' ? 'ver' : 'ocultar'}} la contraseña
                            </span>
                            <span v-show="showGenPswInfo">
                                Presione para generar una contraseña aleatoria.
                            </span>
                        </div>
                        <div class="form-control-feedback text-helper-tooltip" v-show="showError">
                            {{ psw_error_message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="" @click.prevent="goBack()" class="btn btn-outline-danger ml-auto">
                    <i class="fa fa-chevron-left"></i> Atrás
                </a>

                <a href="#" @click.prevent="saveOrUpdate()" class="btn btn-outline-primary ml-auto">
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
            pUser: {
                type: [Object, String],
                default() {
                    return {
                        first_name: '',
                        last_name: '',
                        email: '',
                        password: '',
                        hashid: '',
                        role: {},
                    }
                }
            },
            pIsAdmin: Number,
            pAction: String
        },
        computed: {
          showError(){
              if(this.showPswInfo || this.showGenPswInfo) {
                  return false;
              }else if((!this.showPswInfo && !this.showGenPswInfo) && this.psw_error){
                  return true;
              }
          }
        },
        data() {
            return {
                user: {},
                roles: {},
                roleSelected: '',
                pswType: 'password',
                psw_error: false,
                psw_error_message: 'El campo Contraseña es obligatorio',
                showPswInfo: false,
                showGenPswInfo: false,
            }
        },
        mounted() {
            if (typeof this.pUser === 'string') {
                this.user = JSON.parse(this.pUser);
            } else {
                this.user = this.pUser;
            }

            let urlBase = AdminConf.adminUrlBase();
            let url = urlBase + AdminConf.adminApiUrlBase + '/admin/roles';

            axios.get(url)
                .then((resp) => {
                    this.roles = resp.data;
                    if (typeof this.pUser === 'string') {
                        this.roleSelected = this.user.role.hashid;
                    } else {
                        this.roleSelected = this.roles[0].hashid;
                    }

                    this.$eventHideOverlay.$emit('hide');
                });
        },
        methods: {
            goBack(){
                window.history.back();
            },
            saveOrUpdate() {
                let url = AdminConf.adminUrlBase() + AdminConf.adminApiUrlBase + '/admin/users';
                switch (this.pAction) {
                    case 'edit':
                        url += '/' + this.user.hashid + '/roles/' + this.roleSelected;
                        this.$validator.validateAll().then((result) => {
                            if (result) {
                                axios.put(url, this.user)
                                    .then((resp) => {
                                        toastr.options.onHidden = function () {
                                            window.location = resp.data.redirectTo;
                                        };
                                        toastr.success(resp.data.message, 'Mensaje!!');
                                    });
                            } else {
                                toastr.error('Debe llenar todos los campos marcados con asterisco', 'Error!!');
                            }
                        });
                        break;
                    case 'create':
                        url += '/roles/' + this.roleSelected;
                        this.$validator.validateAll().then((result) => {
                            if (result) {
                                if (this.user.password !== '') {
                                    axios.post(url, this.user)
                                        .then((resp) => {
                                            toastr.options.onHidden = function () {
                                                window.location = resp.data.redirectTo;
                                            };
                                            toastr.success(resp.data.message, 'Mensaje!!');
                                        });
                                } else {
                                    this.psw_error = true;
                                    toastr.error(this.psw_error_message, 'Error!!');
                                }
                            } else {
                                toastr.error('Debe llenar todos los campos marcados con asterisco', 'Error!!');
                            }
                        });
                        break;
                }
            },
            togglePassword() {
                this.pswType = this.pswType === 'password' ? 'text' : 'password';
                this.$refs.inputPassword.setAttribute('type', this.pswType)
            },
            genPassword() {
                this.user.password = this.$str_random(10);
            }
        }
    }
</script>