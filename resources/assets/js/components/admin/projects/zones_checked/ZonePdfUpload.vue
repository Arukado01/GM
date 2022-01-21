<template>
    <div>
        <div :id="this.zoneId" class="modal fade" data-keyboard="false" tabindex="-1" role="dialog"
             data-backdrop="static" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Archivo PDF para la zona: "{{ this.zoneName }}"
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-if="!this.zonePdf">
                        <div class="row">
                            <div class="col-md-12">
                                <div :id="'pdf-upload-'+this.zoneId" class="dropzone"></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="" class="btn btn-secondary" data-dismiss="modal">Cancelar</a>

                        <a v-if="!this.zonePdf" href="" @click.prevent="savePdf(this.zoneId)"
                           class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Guardar PDF
                        </a>

                        <template v-else>
                            <a href="" @click.prevent="deletePdf(this.zoneId)"
                               class="btn btn-danger">
                                <i class="fa fa-trash"></i>Eliminar
                                PDF
                            </a>


                            <a :href="this.pdfRoute" class="btn btn-success"
                               target="_blank">Ver PDF
                            </a>
                        </template>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import admin_conf from '../../../../admin_conf';

    export default {
        name: "zone-pdf-upload",
        props: ['zone-id', 'zone-name', 'zone-pdf', 'pdf-route'],
        data() {
            return {
                id: this.zoneId
            }
        },
        mounted() {
            this.initDropZone();
        },
        methods: {
            initDropZone() {
                let vm = this;
                let url = admin_conf.adminUrlBase() + admin_conf.adminApiUrlBase
                    + `/admin/zones/${this.zoneId}/zones-upload-pdf`;

                Dropzone.autoDiscover = false;
                if (document.getElementById(`pdf-upload-${this.zoneId}`)) {
                    this.pdfDropzone = new Dropzone(`div#pdf-upload-${this.zoneId}`, {
                        url: url,
                        maxFiles: 1,
                        timeout: 240000,
                        acceptedFiles: 'application/pdf',
                        addRemoveLinks: true,
                        dictFileTooBig: 'El archivo es demasiado grande - ({{filesize}}Mb). Maximo permitido ({{maxfilesize}}Mb)',
                        dictRemoveFile: 'Remover archivo',
                        dictMaxFilesExceeded: 'No se pueden subir mas archivos.',
                        dictInvalidFileType: 'No se pueden subir archivos de este tipo.',
                        autoProcessQueue: false,
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
                            toastr.success('Archivo Pdf almacenado exitosamente', 'Información');
                            this.pdfDropzone.removeFile(file);
                        }

                        vm.$emit('newEvent');
                        $(`#${vm.id}`).hide();
                        $(".modal-backdrop").fadeOut();
                    });

                    this.pdfDropzone.on('error', (file, response) => {
                        toastr.error(response.message, 'Error');
                        $(file.previewElement).find('.dz-error-message').text(response.message).addClass('text-center');
                    });
                }
            },
            savePdf() {
                this.pdfDropzone.processQueue();

            },
            deletePdf() {
                let url = admin_conf.adminUrlBase() + admin_conf.adminApiUrlBase
                    + `/admin/zones/${this.zoneId}/delete-pdf`;

                axios.delete(url)
                    .then(resp => {
                        toastr.success(resp.data.message, 'Información');
                        $(`#${this.id}`).hide();
                        $(".modal-backdrop").fadeOut();
                        this.$emit('newEvent');
                    });
            },
        }
    }
</script>

<style scoped>

</style>