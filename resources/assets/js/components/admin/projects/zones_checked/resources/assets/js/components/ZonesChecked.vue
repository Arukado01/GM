<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="widget">
                    <div class="widget-header">
                        <h5>Zonas Verificadas Dimensionalmente</h5>
                    </div>
                    <hr class="widget-separator">
                    <div class="widget-body">
                        <div class="row">
                            <div class="col-md-12">
                                <template v-if="zonesFloors.max_floors !== '' && zonesFloors.max_floors !== 0">
                                    <div class="table-responsive">
                                        <table id="certificates-table" class="table table-hover table-bordered"
                                               cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th>Zonas</th>
                                                <th class="text-center" scope="col"
                                                    v-for="floor in parseInt(zonesFloors.max_floors)">
                                                    Piso {{ floor }}
                                                </th>
                                                <th class="text-center">Archivo Pdf</th>
                                                <th class="text-center">Observaciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="zone in zonesFloors.zones">
                                                <th>{{ zone.name }}</th>
                                                <th class="text-center" style="cursor: pointer;"
                                                    :class="{'bg-primary': !!+floor.checked}"
                                                    v-for="floor in zone.floors">
                                                    <i class="fa fa-check text-white" style="font-size: 16px;"
                                                       v-if="!!+floor.checked"></i>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <h6>No se encontraron datos.</h6>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import admin_conf from '../admin_conf'

    export default {
        props: {
            pProjectId: String,
            pRouteGetData: String
        },
        data() {
            return {
                isSaving: false,
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
            this.$eventHideOverlay.$emit('hide');
            this.loadData();
        },
        watch: {},
        methods: {
            loadData() {
                axios.get(this.pRouteGetData)
                    .then(resp => {
                        console.log(resp.data);

                        if (resp.data.length > 0) {
                            this.zonesFloors.zones = resp.data;
                            this.maxFloors = resp.data[0].floors.length;

                            this.onBlurMaxFloors();
                        }
                    });
            },
            onBlurMaxFloors() {
                if (parseInt(this.maxFloors) !== 0 && this.maxFloors !== '') {
                    this.isDisabled = true;

                    this.zonesFloors.max_floors = parseInt(this.maxFloors);
                    for (let zone of this.zonesFloors.zones) {
                        for (let i = zone.floors.length; i < parseInt(this.zonesFloors.max_floors); i++) {
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

                        this.zonesFloors.zones.push({
                            name: this.newZone,
                            floors: newFloors
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
                let url = admin_conf.adminUrlBase() + admin_conf.adminApiUrlBase
                    + `/admin/projects/${this.pProjectId}/zones-checked`;

                this.isSaving = true;
                axios.post(url, this.zonesFloors)
                    .then(resp => {
                        toastr.success(resp.data.message, 'Mensaje!');
                        this.isSaving = false;
                    });
            }
        }
    }
</script>