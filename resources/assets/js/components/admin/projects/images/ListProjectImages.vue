<template>
    <div>
        <div class="images-content">
            <div class="row" v-for="i in Math.ceil(projectImages.length / 3)">
                <div class="col-md-4" v-for="image in projectImages.slice((i - 1) * 3, i * 3)">
                    <div class="card">
                        <div class="card-img-top">
                            <div class="card-img-top-wrapper" v-if="image.deleted_at">
                                <i class="fa fa-ban"></i>
                            </div>
                            <img class="card-img-top" :src="image.full_url" alt="">
                        </div>
                        <div class="card-body p-4">
                            <h6 class="card-subtitle mb-2 text-muted">{{ image.date }}</h6>
                            <p class="card-text text-justify">
                                {{ image.description }}
                            </p>
                            <a v-if="image.deleted_at" href="" @click.prevent="restoreImage(image)"
                               class="btn btn-outline-warning btn-flat btn-sm">
                                <i class="fa fa-refresh"></i> Restaurar
                            </a>
                            <a href="" v-if="!image.deleted_at" @click.prevent="disableImage(image)"
                               class="btn btn-outline-warning btn-flat btn-sm">
                                <i class="fa fa-window-close-o"></i> Deshabilitar
                            </a>
                            <a href="" @click.prevent="deleteImage(image)"
                               class="btn btn-outline-danger btn-flat btn-sm">
                                <i class="fa fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import admin_conf from "../../../../admin_conf";

    export default {
        props: ['project-images'],
        mounted() {
            console.log('entro');
        },
        methods: {
            deleteImage(image) {
                let vm = this;
                swal({
                    title: "¿Esta usted seguro de eliminar esta imagen?",
                    text: "Tenga en cuanta que al eliminar esta imagen no podrá recuperarla, en caso de querer hacerlo presione el boton \"Deshabilitar\"",
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
                        let url = admin_conf.adminUrlBase() + admin_conf.adminApiUrlBase +
                            `/admin/projects-images/${image.hashid}`;

                        axios.delete(url)
                            .then(resp => {
                                swal(resp.data.message, {
                                    icon: "success",
                                }).then(() => {
                                    vm.$emit('refreshImages');
                                });
                            });
                    }
                });
            },
            restoreImage(image) {
                let url = admin_conf.adminUrlBase() + admin_conf.adminApiUrlBase +
                    `/admin/projects-images/${image.hashid}/restore`;

                axios.post(url)
                    .then(resp => {
                        swal(resp.data.message, {
                            icon: "success",
                        }).then(() => {
                            this.$emit('refreshImages');
                        });
                    });
            },
            disableImage(image) {
                let vm = this;
                swal({
                    title: "¿Esta usted seguro de Deshabilitar esta imagen?",
                    text: "Tenga en cuanta que al deshabilitar esta imagen solo sera visible por el administrador ó el Supervisor, mas no para el cliente.",
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
                            text: "Deshabilitar",
                            value: true,
                            visible: true,
                            className: "btn-warning",
                            closeModal: true
                        }
                    },
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        let url = admin_conf.adminUrlBase() + admin_conf.adminApiUrlBase +
                            `/admin/projects-images/${image.hashid}`;

                        axios.delete(url, {params: {sof_delete: true}})
                            .then(resp => {
                                swal(resp.data.message, {
                                    icon: "success",
                                }).then(() => {
                                    vm.$emit('refreshImages');
                                });
                            });
                    }
                });
            }
        }
    }
</script>