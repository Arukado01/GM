<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div id="pdf-upload" class="dropzone text-center"></div>
            </div>
        </div>
        <div class="row mt-5" v-if="this.urlImage !== ''">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>
                            <a :href="urlImage" target="_blank">
                                Licencia de Construcción ({{ pProjectName }}) <i class="fa fa-external-link"></i>
                            </a>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import admin_config from '../../../admin_conf';

    export default {
        props: ['p-project-image', 'p-project-name', 'p-url'],
        data(){
            return {
                urlImage: this.pProjectImage
            }
        },
        mounted() {
            Dropzone.autoDiscover = false;
            if (document.getElementById('pdf-upload')) {
                this.initDropZone();
            }
        },
        methods: {
            initDropZone() {
                let vm = this;
                this.pdfDropzone = new Dropzone("div#pdf-upload", {
                    url: vm.pUrl,
                    maxFiles: 1,
                    timeout: 240000,
                    acceptedFiles: 'application/pdf',
                    addRemoveLinks: true,
                    dictFileTooBig: 'El archivo es demasiado grande - ({{filesize}}Mb). Maximo permitido ({{maxfilesize}}Mb)',
                    dictRemoveFile: 'Remover archivo',
                    dictMaxFilesExceeded: 'No se pueden subir mas archivos.',
                    dictInvalidFileType: 'No se pueden subir archivos de este tipo.',
                    autoProcessQueue: true,
                    dictDefaultMessage: 'Por favor arrastre su archivo o presione aquí para seleccionar uno.',
                });

                this.pdfDropzone.on('sending', (file, xhr, formData) => {
                    formData.append("_token", document.head.querySelector('meta[name="csrf-token"]').content);
                });

                this.pdfDropzone.on('success', (file) => {
                    let resp = JSON.parse(file.xhr.responseText);
                    if (file.xhr.status !== 200) {
                        toastr.error(resp.message, 'Error');
                        this.pdfDropzone.options.dictResponseError = resp.message;

                    } else if (file.xhr.status === 200) {
                        let resp = JSON.parse(file.xhr.response);
                        toastr.success(resp.message, 'Información');
                        this.urlImage = resp.path;

                        this.pdfDropzone.removeFile(file);
                    }
                });

                this.pdfDropzone.on('error', (file, response) => {
                    toastr.error(response.message, 'Error');
                    $(file.previewElement).find('.dz-error-message').text(response.message).addClass('text-center');
                });

                vm.$eventHideOverlay.$emit('hide');
            }
        }
    }
</script>