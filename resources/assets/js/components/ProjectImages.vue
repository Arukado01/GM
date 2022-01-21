<template>
    <div v-if="images.length > 0" id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item" :class="{'active': index === 0}" v-for="(image, index) in images">
                <img class="img-fluid" :src="image.full_url" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <p>{{ image.description }}</p>
                </div>
            </div>
        </div>
        <template v-if="images.length > 1">
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </template>
    </div>
    <div class="text-center" v-else>
        No hay imágenes para mostrar.
    </div>
</template>
<script>
    import adminConfig from '../admin_conf';

    export default {
        props: ['p-project-id'],
        data() {
            return {
                images: []
            }
        },
        mounted() {
            this.loadImages();
        },
        methods: {
            loadImages() {
                let url = adminConfig.adminUrlBase() + adminConfig.adminApiUrlBase +
                    `/projects/${this.pProjectId}/get-data-images`;

                axios.get(url)
                    .then(resp => {
                        this.images = resp.data;
                        this.$eventHideOverlayComponent.$emit('hideOverlayComponent');
                    });
            },
        }
    }
</script>