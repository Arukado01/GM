<template>
    <div class="avatar-image-wrapper avatar-image-upload">
        <transition enter-active-class="animated fadeIn"
                    leave-active-class="animated fadeOut">
            <div class="overlay overlay-absoulte" id="overlay-upload" v-if="showOverlay">
                <div class="progress">
                    <div class="progress-bar" :style="{'width': progressValue+'%'}" role="progressbar" aria-valuemin="0"
                         aria-valuemax="100">
                        {{ progressValue }}%
                    </div>
                </div>
                <div class="overlay-text">
                    <div id="floatingCirclesG">
                        <div class="f_circleG" id="frotateG_01"></div>
                        <div class="f_circleG" id="frotateG_02"></div>
                        <div class="f_circleG" id="frotateG_03"></div>
                        <div class="f_circleG" id="frotateG_04"></div>
                        <div class="f_circleG" id="frotateG_05"></div>
                        <div class="f_circleG" id="frotateG_06"></div>
                        <div class="f_circleG" id="frotateG_07"></div>
                        <div class="f_circleG" id="frotateG_08"></div>
                    </div>
                </div>
            </div>
        </transition>
        <div class="row">
            <div class="col-md-12">
                <div id="avatar-cropp"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="upload-wrapper text-center">

                    <div class="row upload-file-content" v-if="modalVisible" @dragenter="hovering = true"
                         @dragleave="hovering = false" @drop="hovering = false">
                        <div class="col-md-12">
                            <div>
                                <div class="input-file" :class="{'hovered': hovering}">
                                    <div class="md-message">
                                        Presiona aquí para seleccionar una imagen
                                    </div>
                                    <input type="file" class="input-file-control" id="btn-upload-img"
                                           @change="setUpFileUploader">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center" :class="{'col-md-6': modalVisible, 'col-md-12': !modalVisible}">
                            <a href="#" @click.prevent="toggleModal" :class="{'btn btn-danger btn-flat': modalVisible}">
                                <span v-if="!modalVisible">
                                    <i class="fa fa-camera"></i> Cambiar Imagen
                                </span>
                                <span v-else-if="modalVisible">
                                    <i class="fa fa-ban"></i> Cancelar
                                </span>
                            </a>
                        </div>
                        <div class="col-md-6 text-center" v-if="modalVisible">
                            <a href="#" @click.prevent="uploadFile" class="btn btn-primary btn-flat">
                                <i class="fa fa-upload"></i> Subir Archivo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { Croppie } from 'croppie/croppie';
    import AdminConf from './../admin_conf';

    export default {
        props: ['imgUrl', 'userId', 'pContext'],
        data() {
            return {
                image: null,
                currentImg: null,
                croppie: null,
                modalVisible: false,
                hovering: false,
                showOverlay: false,
                progressValue: 0
            }
        },
        mounted() {
            this.$on('imageUploaded', (imageData) => {
                this.image = imageData;
                this.croppie.destroy();
                this.setUpCroppie();
            });
            this.image = this.imgUrl;
            this.currentImg = this.imgUrl;
            this.setUpCroppie();
            this.$eventHideOverlay.$emit('hide');
        },
        methods: {
            toggleModal() {
                this.modalVisible = !this.modalVisible;
                if (!this.modalVisible) {
                    this.image = this.currentImg;
                    this.croppie.destroy();
                    this.setUpCroppie();
                }
            },
            setUpCroppie() {
                let el = document.getElementById('avatar-cropp');
                this.croppie = new Croppie(el, {
                    viewport: {width: 200, height: 200, type: 'circle'},
                    boundary: {width: 220, height: 220},
                    showZoomer: true,
                    enableOrientation: true
                });

                this.croppie.bind({
                    url: this.image
                }).then(() => {
                    this.croppie.setZoom(0);
                });

            },
            setUpFileUploader(e) {
                let files = e.target.files || e.dataTransfer.files;

                if (!files.length)
                    return false;

                this.createImage(files[0]);
            },
            createImage(file) {
                let image = new Image();
                let reader = new FileReader();
                let vm = this;

                reader.readAsDataURL(file);
                reader.onload = (e) => {
                    vm.image = e.target.result;
                    vm.$emit('imageUploaded', e.target.result);
                };
            },
            uploadFile() {
                this.showOverlay = true;
                this.croppie.result({
                    type: 'canvas',
                    size: 'viewport'
                }).then(response => {
                    let url = AdminConf.adminUrlBase()
                        + AdminConf.adminApiUrlBase;

                    if(this.pContext !== 'admin') {
                        url += `/profile/${this.userId}/update/avatar`;
                    }else if(this.pContext === 'admin'){
                        url += `/admin/users/profile/${this.userId}/update/avatar`
                    }

                    axios.post(url, {img_profile: response}, {
                        onUploadProgress: progressEvent => {
                            this.progressValue = Math.floor((progressEvent.loaded / progressEvent.total) * 100);
                        }
                    }).then(resp => {
                        this.modalVisible = false;
                        this.currentImg = resp.data.fileUrl;
                        this.image = this.currentImg;
                        this.croppie.destroy();
                        this.setUpCroppie();

                        let $avatarSidebar = document.getElementById('avatar-sidebar');
                        $avatarSidebar.src = this.image;
                        toastr.success(resp.data.message, 'Éxito!');
                        this.showOverlay = false;
                    });
                });
            }
        }
    }
</script>