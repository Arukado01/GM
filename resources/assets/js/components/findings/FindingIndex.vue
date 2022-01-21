<template>
    <div>
        <div class="widget">
            <div class="widget-header">
                <h5>Hallazgos por Levantar</h5>
            </div>
            <hr class="widget-separator">
            <div class="widget-body">
                <div class="row">
                    <div class="col-md-12" :class="{'text-center': findingsData.length <= 0}">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <h6>Total de Hallazgos: {{ findingsData.length }}</h6>
                                <a href="" @click.prevent="isShow = !isShow">
                                    <div v-show="!isShow">
                                        Mostrar <i class="fa fa-eye"></i>
                                    </div>
                                    <div v-show="isShow">
                                        Ocultar <i class="fa fa-eye-slash"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row" v-show="isShow">
                            <div class="col-md-12">
                                <div id="accordion-findings" role="tablist" aria-multiselectable="true"
                                     v-if="findingsData.length > 0">
                                    <div class="card mb-0" v-for="(findingData, index) in findingsData">
                                        <div class="card-header" role="tab" id="headingOne">
                                            <h5 class="mb-0 pull-left">
                                                <a data-toggle="collapse" :href="'#collapse_'+index" aria-expanded="true"
                                                   :aria-controls="'#collapse_'+index">
                                                    {{ findingData.affair }} <sub>{{ findingData.date }}</sub>
                                                </a>
                                            </h5>
                                        </div>

                                        <div :id="'collapse_'+index" class="collapse" role="tabpanel"
                                             aria-labelledby="headingOne"
                                             data-parent="#accordion-findings">
                                            <div class="card-block">
                                                <span v-html="findingData.finding"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span v-else>No se encontraron registros para mostrar.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import adminConfig from '../../admin_conf';
    import Datepicker from 'vue-datepicker';
    import {VueEditor} from 'vue2-editor';

    moment.locale('es');

    export default {
        props: ['p-project-id'],
        components: {
            'date-picker': Datepicker,
            VueEditor
        },
        mounted() {
            this.loadFindings();
        },
        data() {
            return {
                isShow: false,
                findingsData: [],
            }
        },
        methods: {
            loadFindings() {
                let url = adminConfig.adminUrlBase() + adminConfig.adminApiUrlBase +
                    `/projects/${this.pProjectId}/findings-data`;

                axios.get(url)
                    .then(resp => {
                        this.findingsData = resp.data.findings;
                        this.$eventHideOverlay.$emit('hide');
                    });
            }
        }
    }
</script>