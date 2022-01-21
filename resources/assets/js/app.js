require('./bootstrap');

window.moment = require('moment');
window.Vue = require('vue');
require('./helpers');
import es from 'vee-validate/dist/locale/es'
import VeeValidate, {Validator} from 'vee-validate';

//region Configurations
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

Validator.localize('es', es);
//endregion


//region Uses
Vue.use(VeeValidate, {
    locale: 'es'
});
//endregion
//region Components
Vue.component('home', require('./components/Home.vue'));
Vue.component('profile', require('./components/Profile.vue'));
Vue.component('concrete-sample', require('./components/Samples/ConcreteSample.vue'));
Vue.component('steel-samples', require('./components/Samples/SteelSamples.vue'));
Vue.component('mesh-samples', require('./components/Samples/MeshSamples.vue'));
Vue.component('unload-overlay', require('./components/admin/UnloadOverlay.vue'));
Vue.component('settlement-control', require('./components/Samples/SettlementControls.vue'));
Vue.component('state-observation', require('./components/StateObservation.vue'));
Vue.component('project-images', require('./components/ProjectImages.vue'));
Vue.component('finding-index', require('./components/findings/FindingIndex.vue'));
Vue.component('calibration-certificates', require('./components/CalibrationCertificate.vue'));
Vue.component('progress-works', require('./components/ProgressWorks.vue'));
Vue.component('zones-checked', require('./components/ZonesChecked.vue'));
//endregion

const app = new Vue({
    el: '#app',
    created() {
        this.$eventHideOverlay.$on('hide', this.hidePreloader);
        this.$eventHideOverlayComponent.$on('hideOverlayComponent', this.hideOverlayComponent);
    },
    methods: {
        hidePreloader() {
            document.getElementById("overlay").style.display = "none";
        },
        hideOverlayComponent(){
            $("#overlay_component").fadeOut('slow');
            console.log('aca entro');
        }
    }
});
