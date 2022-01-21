<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Zonas Verificadas Dimensionalmente</h5>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txt_max_floors">Cantidad Máxima de Pisos</label>
                                    <input type="text" id="txt_max_floors" class="form-control"
                                           :disabled="isDisabled"
                                           v-model="maxFloors" @blur="onBlurMaxFloors()"/>
                                    <small class="form-text text-muted">
                                        Tenga en cuenta que el valor digitado en este campo es fijo y no podrá ser
                                        cambiado
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txt_zone">Zona</label>
                                    <div class="input-group">
                                        <input type="text" id="txt_zone" class="form-control" v-model="newZone"/>
                                        <div class="input-group-append">
                                            <a href="" @click.prevent="addZone()"
                                               class="btn btn-outline-primary btn-flat">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <overlay-component></overlay-component>
                                <template v-if="zonesFloors.max_floors !== '' && zonesFloors.max_floors !== 0">
                                    <div class="form-text text-info">
                                        Para marcar un piso como revisado presione click Izquierdo sobre la celda
                                        correspondiente.
                                    </div>
                                    <div class="table-responsive">
                                        <table id="zones-table" class="table table-hover table-bordered"
                                               cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th class="w-10">Zonas</th>
                                                <th class="w-5 text-center" scope="col"
                                                    v-for="floor in parseInt(zonesFloors.max_floors)">
                                                    Piso {{ floor }}
                                                </th>
                                                <th class="w-10">PDF</th>
                                                <th class="w-20">Observaciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="zone in zonesFloors.zones">
                                                <td class="text-center">{{ zone.name }}</td>
                                                <td class="text-center" style="cursor: pointer;"
                                                    @click="checkCell(floor)"
                                                    :class="{'bg-primary': !!+floor.checked}"
                                                    v-for="(floor, index) in zone.floors">
                                                    <i :ref="floor.hashid" v-show="false"
                                                       class="fa fa-spinner fa-spin margin-bottom"></i>
                                                    <i class="fa fa-check text-white" style="font-size: 16px;"
                                                       v-if="!!+floor.checked"></i>
                                                </td>
                                                <td>
                                                    <a href="" class="btn"
                                                       :class="classObject(zone)"
                                                       data-toggle="modal" :data-target="'#'+zone.hashid">
                                                        <span v-if="zone.pdf_path && zone.pdf_path !== ''">Cambiar PDF</span>
                                                        <span v-else>Agregar PDF</span>

                                                    </a>
                                                    <zone-pdf-upload @newEvent="loadData()" :zone-id="zone.hashid"
                                                                     :zone-name="zone.name"
                                                                     :zone-pdf="zone.pdf_path"
                                                                     :pdf-route="zone.route_pdf"></zone-pdf-upload>

                                                    <input type="hidden" v-validate="'required'">
                                                </td>
                                                <td v-html="zone.observations">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="" @click.prevent="saveZones()" class="btn btn-outline-primary">
                            <template v-if="isSaving">
                                <i class="fa fa-spinner fa-spin margin-bottom"></i> Guardando
                            </template>
                            <template v-else>
                                <i class="fa fa-save"></i> Guardar
                            </template>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import admin_conf from '../../../../admin_conf';
    import ZonePdfUpload from './ZonePdfUpload';

    export default {
        props: {
            pProjectId: String,
            pRouteGetData: String
        },
        components: {
            'zone-pdf-upload': ZonePdfUpload
        },
        data() {
            return {
                isSaving: false,
                isFloorChecking: false,
                newZone: '',
                maxFloors: 0,
                isDisabled: false,
                zonesFloors: {
                    max_floors: 0,
                    zones: []
                }
            }
        },
        mounted() {
            this.loadData();
        },
        watch: {},
        methods: {
            classObject(zone) {
                return {
                    'btn-success': zone.pdf_path && zone.pdf_path !== '',
                    'btn-primary': zone.pdf_path === null
                }
            },
            loadData() {
                this.$eventShowOverlayComponent.$emit('ShowOverlayComponent');

                axios.get(this.pRouteGetData)
                    .then(resp => {
                        console.log(resp.data);

                        if (resp.data.length > 0) {
                            this.zonesFloors.zones = resp.data;
                            this.maxFloors = resp.data[0].floors.length;

                            this.onBlurMaxFloors();
                            this.$eventHideOverlay.$emit('hide');
                            this.$eventHideOverlayComponent.$emit('hideOverlayComponent');
                        }
                    });
            },
            onBlurMaxFloors() {
                if (parseInt(this.maxFloors.toString()) !== 0 && this.maxFloors !== '') {
                    this.isDisabled = true;

                    this.zonesFloors.max_floors = parseInt(this.maxFloors.toString());
                    for (let zone of this.zonesFloors.zones) {
                        for (let i = zone.floors.length; i < parseInt(this.zonesFloors.max_floors.toString()); i++) {
                            zone.floors.push({
                                number: i,
                                checked: false
                            });
                        }
                    }
                }
            },
            addZone() {
                if (parseInt(this.maxFloors) !== 0) {
                    if (this.newZone !== '') {
                        let newFloors = [];
                        for (let i = 0; i < parseInt(this.zonesFloors.max_floors); i++) {
                            newFloors.push({
                                number: i,
                                checked: false
                            });
                        }

                        let url = admin_conf.adminUrlBase() + admin_conf.adminApiUrlBase
                            + `/admin/projects/${this.pProjectId}/zones-checked`;

                        this.isSaving = true;
                        axios.post(url, {zone_name: this.newZone, floors: newFloors})
                            .then(resp => {
                                toastr.success(resp.data.message, 'Mensaje!');

                                this.zonesFloors.zones.push({
                                    name: resp.data.zone.name,
                                    floors: resp.data.zone.floors
                                });

                                this.isSaving = false;
                            });


                    } else {
                        toastr.error('Debe digitar una zona para poder continuar', 'Mensaje!');
                    }
                } else {
                    toastr.error('Debe digitar una la cantidad maxima de pisos para poder continuar', 'Mensaje!');
                }
                this.newZone = '';
            },
            saveZones() {
                /*let url = admin_conf.adminUrlBase() + admin_conf.adminApiUrlBase
                    + `/admin/projects/${this.pProjectId}/zones-checked`;

                this.isSaving = true;
                axios.post(url, this.zonesFloors)
                    .then(resp => {
                        toastr.success(resp.data.message, 'Mensaje!');
                        this.isSaving = false;
                    });*/
            },
            checkCell(floor) {
                let el = this.$refs[floor.hashid][0];

                el.style.display = 'block';
                if (floor.checked)
                    floor.checked = false;

                console.log(floor);
                let url = admin_conf.adminUrlBase() + admin_conf.adminApiUrlBase
                    + `/admin/floors/${floor.hashid}`;

                axios.post(url)
                    .then(resp => {
                        el.style.display = 'none';
                        floor.checked = resp.data.state;
                    });
            },
        }
    }
</script>