<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Nuevo Certificado de Calibración</h5>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="pdf-upload" class="dropzone text-center"></div>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="row">
                                    <div class="col-md-12">
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="sl_sample_type">Tipo de Ensayo</label>
                                            <select id="sl_sample_type" class="form-control"
                                                    v-model="sample_type">
                                                <option value="">Seleccionar</option>
                                                <option value="concreto">Concreto</option>
                                                <option value="aceros">Aceros</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="" @click.prevent="cancelData()" class="btn btn-outline-warning">
                            <i class="fa fa-ban"></i> Cancelar
                        </a>
                        <a href="" @click.prevent="saveData()" class="btn btn-outline-primary" v-if="!isEdit">
                            <i class="fa fa-save"></i> Guardar
                        </a>
                        <template v-else>
                            <a href="" @click.prevent="editData()" class="btn btn-outline-success">
                                <i class="fa fa-edit"></i> Editar
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="certificates-table" class="table table-hover table-bordered"
                                       cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Tipo de Ensayo</th>
                                        <th>Fecha de Calibración</th>
                                        <th>Fecha de Expiración</th>
                                        <th>Chequeo</th>
                                        <th>Archivo</th>
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
    import admin_config from '../../../../admin_conf';
    import Datepicker from 'vue-datepicker';

    export default {
        props: ['p-project-hashid', 'p-url-table-data', 'p-url'],
        components: {
            'date-picker': Datepicker,
        },
        data() {
            return {
                isEdit: false,
                pdfDropzone: null,
                certificatesTable: null,
                sample_type: '',
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
                ],
                editUrl: ''
            }
        },
        mounted() {
            this.$eventHideOverlay.$emit('hide');
            Dropzone.autoDiscover = false;
            if (document.getElementById('pdf-upload')) {
                this.initDropZone();
            }
            this.initDataTable();
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
                    formData.append("sample_type", vm.sample_type);
                    formData.append("calibration_date", vm.dateSelectedNoFormat);
                });

                this.pdfDropzone.on("processing", function (file) {
                    if (vm.isEdit) {
                        this.options.url = vm.editUrl;
                    } else {
                        this.options.url = vm.pUrl;
                    }
                });

                this.pdfDropzone.on('success', (file) => {
                    let resp = JSON.parse(file.xhr.responseText);
                    if (file.xhr.status !== 200) {
                        toastr.error(resp.message, 'Error');
                        vm.pdfDropzone.options.dictResponseError = resp.message;

                    } else if (file.xhr.status === 200) {
                        let resp = JSON.parse(file.xhr.response);
                        toastr.success(resp.message, 'Información');
                        vm.certificatesTable.ajax.reload();
                        vm.cancelData();
                    }
                });

                this.pdfDropzone.on('error', (file, response) => {
                    toastr.error(response.message, 'Error');
                    $(file.previewElement).find('.dz-error-message').text(response.message).addClass('text-center');
                });

                vm.$eventHideOverlay.$emit('hide');
            },
            saveData() {
                if (this.pdfDropzone.files.length <= 0) {
                    toastr.error('Debe agregar un archivo para poder continuar.');
                    return false;
                } else if (this.dateSelected === '') {
                    toastr.error('Debe seleccionar una fecha para poder continuar.');
                    return false;
                } else if (this.sample_type === '') {
                    toastr.error('Debe seleccionar el tipo de ensayo para poder continuar.');
                    return false;
                } else {
                    this.pdfDropzone.processQueue();
                }
            },
            initDataTable() {
                let vm = this;
                vm.certificatesTable = $('#certificates-table').DataTable({
                    processing: true,
                    serverSide: true,
                    language: admin_config.langDataTable,
                    ajax: vm.pUrlTableData,
                    order: [[1, "desc"]],
                    initComplete() {
                        vm.$eventHideOverlay.$emit('hide');
                    },
                    fnDrawCallback() {
                        let buttons = document.getElementsByClassName('btn-edit-calibration-certificate');
                        if (buttons) {
                            [...buttons].forEach(button => button.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = button.getAttribute('data-url');
                                let tr = button.parentNode.parentElement.parentElement.parentElement;
                                let data = vm.certificatesTable.row(tr).data();
                                let date = moment(data.calibration_date);

                                vm.sample_type = data.sample_type.toLowerCase();
                                vm.dateSelectedNoFormat = data.calibration_date;
                                vm.option.placeholder = 'Cambiar fecha';
                                vm.date.time = '';
                                vm.dateSelected = date.format('MMMM DD [de] YYYY').capitalize();

                                vm.editUrl = url;
                                vm.isEdit = true;

                            }));
                        } else {
                            vm.dataTableMeshSamples.column(6).visible(false);
                        }

                        let deleteButtons = document.getElementsByClassName('btn-delete-calibration-certificate');
                        if (deleteButtons) {
                            [...deleteButtons].forEach(deleteButton => deleteButton.addEventListener('click', (e) => {
                                e.preventDefault();
                                let url = deleteButton.getAttribute('data-url');
                                swal({
                                    title: "¿Esta usted seguro de eliminar el Certificado de Calibración?",
                                    text: "Tenga en cuanta que al eliminar este recurso no podrá recuperarlo.",
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
                                        axios.delete(url)
                                            .then(resp => {
                                                swal(resp.data.message, {
                                                    icon: "success",
                                                }).then(() => {
                                                    vm.certificatesTable.ajax.reload();
                                                });
                                            })
                                    }
                                });
                            }));
                        }
                    },
                    columns: [
                        {data: 'sample_type', name: 'sample_type', orderable: false},
                        {data: 'calibration_date', name: 'calibration_date', orderable: true},
                        {data: 'expiration_date', name: 'expiration_date', orderable: false},
                        {data: 'check', name: 'check', orderable: false},
                        {data: 'path', name: 'path', orderable: false},
                        {data: 'action', name: 'action', orderable: false},
                    ]
                });
            },
            cancelData() {
                this.sample_type = '';
                this.dateSelectedNoFormat = '';
                this.option.placeholder = 'Presiona aquí para seleccionar una fecha';
                this.date.time = '';
                this.dateSelected = '';
                this.pdfDropzone.removeAllFiles();
                this.isEdit = false;
            },
            editData() {
                if (this.dateSelected === '') {
                    toastr.error('Debe seleccionar una fecha para poder continuar.');
                    return false;
                } else if (this.sample_type === '') {
                    toastr.error('Debe seleccionar el tipo de ensayo para poder continuar.');
                    return false;
                }

                if (this.pdfDropzone.files.length <= 0) {
                    axios.post(this.editUrl, {
                        sample_type: this.sample_type,
                        calibration_date: this.dateSelectedNoFormat
                    }).then(resp => {
                        console.log(resp.data);
                        this.certificatesTable.ajax.reload();
                        this.cancelData();
                    });
                } else if (this.pdfDropzone.files.length >= 1) {
                    this.pdfDropzone.processQueue();
                }
            }
        }
    }
</script>