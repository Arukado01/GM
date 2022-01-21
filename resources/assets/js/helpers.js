//window.Vue = require('vue');
import VueClip from 'vue-clip';
import swal from 'sweetalert';
import Configs from './admin_conf';

require('chart.js');
require('hchs-vue-charts');

Vue.prototype.$str_random = function (length) {
    let result = '';
    let chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    for (let i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
};

Vue.prototype.$cleanObjectValues = function (obj, level, type = null) {
    level = level || 0;
    for (let property in obj) {
        obj[property] = type;
        if (typeof obj[property] === 'object') {
            Vue.prototype.$cleanObjectValues(obj[property], ++level);
        }
    }
};

Vue.prototype.$dateStringFormat = function (date) {
    //
    return date.format('YYYY-MM-DD').capitalize();
};

Vue.prototype.$scrollTo = function (el) {
    if (el.length) {
        let top = el.offset().top - 10;
        $('html,body').animate({scrollTop: top}, 1000);
    }
};

Vue.filter("filterById", function (value, keyValue) {
    if (keyValue !== 0)
        return value.filter(item => item.hashid === keyValue);
    return value;
});

String.prototype.capitalize = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
};

Chart.pluginService.register({
    beforeRender: function (chart) {
        if (chart.config.options.showAllTooltips) {
            // create an array of tooltips
            // we can't use the chart tooltip because there is only one tooltip per chart
            chart.pluginTooltips = [];
            chart.config.data.datasets.forEach(function (dataset, i) {
                chart.getDatasetMeta(i).data.forEach(function (sector, j) {
                    if (parseInt(dataset.data[j]) > 0) {
                        chart.pluginTooltips.push(new Chart.Tooltip({
                            _chart: chart.chart,
                            _chartInstance: chart,
                            _data: chart.data,
                            _options: chart.options.tooltips,
                            _active: [sector]
                        }, chart));
                    }
                });
            });

            // turn off normal tooltips
            chart.options.tooltips.enabled = false;
        }
    },
    afterDraw: function (chart, easing) {
        if (chart.config.options.showAllTooltips) {
            // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
            if (!chart.allTooltipsOnce) {
                if (easing !== 1)
                    return;
                chart.allTooltipsOnce = true;
            }

            // turn on tooltips
            chart.options.tooltips.enabled = true;
            Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
                tooltip.initialize();
                tooltip.update();
                // we don't actually need this since we are not animating tooltips
                tooltip.pivot();
                tooltip.transition(easing).draw();
            });
            chart.options.tooltips.enabled = false;
        }
    }
});

Vue.use(VueClip);
Vue.use(Configs);
Vue.use(VueCharts);

Vue.component('upload-avatar', require('./components/UploadAvatar.vue'));
Vue.component('overlay-component', require('./components/OverlayComponent.vue'));

Vue.prototype.$eventHideOverlay = new Vue();
Vue.prototype.$eventShowOverlay = new Vue();

Vue.prototype.$eventHideOverlayComponent = new Vue();
Vue.prototype.$eventShowOverlayComponent = new Vue();
