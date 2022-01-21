<template>
    <div>
        <div :id="'obs-'+this.zoneId" class="modal fade" data-keyboard="false" tabindex="-1" role="dialog"
             data-backdrop="static" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Observaciones para la zona: "{{ this.zoneName }}"
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <vue-editor :id="'edt-'+this.zoneId" v-model="observations"></vue-editor>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="" class="btn btn-secondary" data-dismiss="modal">Cancelar</a>

                        <a href="" @click="saveObservations()"
                           class="btn btn-primary" data-dismiss="modal">
                            <i class="fa fa-save"></i>
                            Guardar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import admin_conf from '../../../../admin_conf';
    import {VueEditor} from 'vue2-editor';

    moment.locale('es');

    export default {
        name: "zone-observations",
        components: {
            VueEditor
        },
        props: ['zone-id', 'zone-name', 'zone-observations'],
        data() {
            return {
                observations: ''
            }
        },
        mounted() {
            if (this.zoneObservations || this.zoneObservations !== '') {
                this.observations = this.zoneObservations;
            }
        },
        methods: {
            saveObservations() {
                let url = admin_conf.adminUrlBase() + admin_conf.adminApiUrlBase
                    + `/admin/zones/${this.zoneId}/update-observations`;

                axios.post(url, {observations: this.observations})
                    .then(resp => {
                        toastr.success(resp.data.message, 'Información');
                        this.$emit('refreshData');
                    });
            }
        }
    }
</script>