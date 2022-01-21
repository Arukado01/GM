<template>
    <div>
        <div class="widget">
            <header class="widget-header">
                <h5>Proyecto&nbsp;<span class="badge badge-primary text-uppercase">{{ pProject }}</span></h5>
            </header>
            <hr class="widget-separator">
            <div class="widget-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="pdf-upload" class="dropzone"></div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 text-center">
                        <div class="form-group">
                            <label for="">Título del reporte</label>
                            <input class="form-control" id="txt_title" type="text"
                                   placeholder="Digite el título del reporte"
                                   v-model="title"/>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="form-group">
                            <div class="text-center date-select-content">
                                <i class="fa fa-calendar"></i>
                                <date-picker :date="date" :option="option"></date-picker>
                            </div>
                            <label v-if="dateSelected != ''">
                                Fecha seleccionada {{ dateSelected }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="#" class="btn btn-primary btn-flat" @click.prevent="uploadFile">
                            <i class="fa fa-cloud-upload"></i>
                            Subir reporte
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget">
            <div class="widget-body">
                <div class="row">
                    <div class="col-md-12">
                        <report-table :url-data="this.pUrlDataReports"></report-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vue-datepicker';
    import {EventBus} from '../../../EventBus';
    import ReportTable from './ReportTable.vue';

    moment.locale('es');

    export default {
        components: {
            'date-picker': Datepicker,
            'report-table': ReportTable
        },
        props: {
            pUrl: String,
            pProject: String,
            pUrlDataReports: String,
        },
        data() {
            return {
                title: '',
                btnUploadState: false,
                dateSelected: '',
                dateSelectedNoFormat: '',
                date: {
                    time: ''
                },
                option: {
                    type: 'day',
                    week: ['Lun', 'Mar', 'Míe', 'Jue', 'Vie', 'Sáb', 'Dom'],
                    month: [
                        'Enero',
                        'Febrero',
                        'Marzo',
                        'Abril',
                        'Mayo',
                        'Junio',
                        'Julio',
                        'Agosto',
                        'Septiembre',
                        'Octubre',
                        'Noviembre',
                        'Diciembre'
                    ],
                    format: 'YYYY-MM-DD',
                    placeholder: 'Presiona aquí para seleccionar una fecha',
                    color: {
                        header: '#5863cc',
                        headerText: '#fbf6ff'
                    },
                    buttons: {
                        ok: 'Ok',
                        cancel: 'Cancelar'
                    },
                    overlayOpacity: 0.5, // 0.5 as default
                    dismissible: false // as true as default
                },
                timeoption: {
                    type: 'min',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    format: 'YYYY-MM-DD HH:mm'
                },
                multiOption: {
                    type: 'multi-day',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    format: "YYYY-MM-DD HH:mm"
                },
                limit: [
                    {
                        type: 'weekday',
                        available: [1, 2, 3, 4, 5]
                    },
                    {
                        type: 'fromto',
                        from: '2016-02-01',
                        to: '2016-02-20'
                    }
                ]
            }
        },
        watch: {
            'date.time': function (val) {
                if (val !== '') {
                    let date = moment(val);
                    this.dateSelectedNoFormat = val;
                    this.option.placeholder = 'Cambiar fecha';
                    this.date.time = '';
                    this.dateSelected = date.format('MMMM DD [de] YYYY').capitalize();
                }
            }
        },
        methods: {
            uploadFile() {
                if (this.pdfDropzone.files.length <= 0) {
                    toastr.error('Debe agregar un archivo para poder continuar.');
                    return false;
                } else if (this.dateSelected === '') {
                    toastr.error('Debe seleccionar una fecha para poder continuar.');
                    return false;
                } else {
                    this.pdfDropzone.processQueue();
                }
            },
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
                    autoProcessQueue: false,
                    dictDefaultMessage: 'Por favor arrastre su archivo o presione aquí para seleccionar uno.',
                });

                this.pdfDropzone.on('sending', (file, xhr, formData) => {
                    formData.append("_token", document.head.querySelector('meta[name="csrf-token"]').content);

                    formData.append("title", this.title);
                    formData.append("date", this.dateSelectedNoFormat);
                });

                this.pdfDropzone.on('success', (file) => {
                    let resp = JSON.parse(file.xhr.responseText);
                    if (file.xhr.status !== 200) {
                        toastr.error(resp.message, 'Error');
                        this.pdfDropzone.options.dictResponseError = resp.message;

                    } else if (file.xhr.status === 200) {
                        toastr.success('Reporte subido exitosamente', 'Información');
                        this.pdfDropzone.removeFile(file);
                        vm.option.placeholder = 'Presiona aquí para seleccionar una fecha';
                        vm.title = '';
                        vm.date.time = '';
                        vm.dateSelectedNoFormat = '';
                        vm.dateSelected = '';
                        EventBus.$emit('refresh-table-reports');
                    }
                });

                this.pdfDropzone.on('error', (file, response) => {
                    toastr.error(response.message, 'Error');
                    $(file.previewElement).find('.dz-error-message').text(response.message).addClass('text-center');
                });

                vm.$eventHideOverlay.$emit('hide');
            }
        },
        mounted() {
            Dropzone.autoDiscover = false;
            if (document.getElementById('pdf-upload')) {
                this.initDropZone();
            }
        }
    }
</script>
