require('./bootstrap');
window.moment = require('moment');
window.Vue = require('vue');
require('./helpers');
import Vue from 'vue';
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
require('./components/admin/admin_components');
//endregion

const admin_app = new Vue({
    el: '#admin-app',
    created() {
        this.$eventHideOverlay.$on('hide', this.hidePreloader);
        this.$eventShowOverlay.$on('show', this.showPreloader);

        this.$eventShowOverlayComponent.$on('ShowOverlayComponent', this.ShowOverlayComponent);
        this.$eventHideOverlayComponent.$on('hideOverlayComponent', this.hideOverlayComponent);
    },
    methods: {
        hidePreloader() {
            document.getElementById("overlay").style.display = "none";
        },
        showPreloader() {
            document.getElementById('overlay').style.display = "block";
        },

        hideOverlayComponent() {
            $("#overlay_component").fadeOut('slow');
        },

        ShowOverlayComponent(){
            $("#overlay_component").fadeIn('slow');
        }
    }
});
