<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h5>Editar Información</h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.has('txt_first_name')}">
                            <label for="txt_first_name">Nombres</label>
                            <input type="text" name="txt_first_name" id="txt_first_name" class="form-control"
                                   v-model="user.first_name">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txt_psw">Generar Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button @click.prevent="togglePassword()" class="btn btn-secondary" type="button"
                                            @mouseover="showPswInfo = true" @mouseleave="showPswInfo = false">
                                        <i class="fa" :class="[pswType == 'password' ? 'fa-eye' : 'fa-eye-slash']"></i>
                                    </button>
                                </span>
                                <input id="txt_psw" class="form-control" ref="inputPassword" v-model="user.password"
                                       type="password">
                                <span class="input-group-btn" @mouseover="showGenPswInfo=true"
                                      @mouseleave="showGenPswInfo=false">
                                    <button @click="genPassword()" class="btn btn-secondary" type="button">
                                        <i class="fa fa-refresh"></i> Generar
                                    </button>
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="#" @click.prevent="saveData()" class="btn btn-outline-primary ml-auto">Guardar</a>
            </div>
        </div>
    </div>
</template>
<script>
    import AdminConf from "./../admin_conf";

    export default {
        props: ['pHash'],
        data() {
            return {
                user: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    hashid: '',
                    password: '',
                },
                pswType: 'password',
                showPswInfo: false,
                showGenPswInfo: false
            }
        },
        mounted() {
            let url = AdminConf.adminUrlBase() + AdminConf.adminApiUrlBase + `/profile/${this.pHash}`;
            console.log(url);

            axios.get(url)
                .then((resp) => {
                    this.user = resp.data;
                });
        },
        methods: {
            saveData() {
                let url = AdminConf.adminUrlBase() + AdminConf.adminApiUrlBase + `/profile/${this.pHash}`;
                console.log(url);

                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.put(url, this.user).then((resp) => {
                            toastr.success(resp.data.message, 'Mensaje!!');
                        });
                    } else {
                        toastr.error('Debe llenar todos los campos marcados con asterisco', 'Error!!');
                    }
                });
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