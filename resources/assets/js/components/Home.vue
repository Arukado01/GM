<template>
    <div>
        <div class="widget">
            <header class="widget-header">
                <h5>Calendario de reportes</h5>
            </header>
            <hr class="widget-separator">
            <div class="widget-body">
                <div class="row">
                    <!--<div class="col-md-offset-8">&nbsp;</div>-->
                    <!--<div class="col-md-4">
                        &lt;!&ndash;Listado de reportes
                        <div class="lst_reports" id="lst_reports_content">
                            <ul>
                                <li v-for="event in events" :id="'_id_'+event.hashid"
                                    @click="selectEventCalendar(event)">
                                    <i class="fa fa-calendar-check-o"></i>
                                    {{ event.start }}
                                    <br>
                                    <span>{{ event.title }}</span>
                                </li>
                            </ul>
                        </div>&ndash;&gt;
                    </div>-->
                    <div class="col-md-4 offset-md-4 pb-3">
                        <div id="calendar-pdf"></div>
                    </div>
                    <!--<div class="col-md-2">&nbsp;</div>-->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import AdminConf from "./../admin_conf";
    import fullcalendar from 'fullcalendar';

    require('fullcalendar/dist/locale/es');

    export default {
        props: ['p-project-id'],
        data() {
            return {
                events: [],
                elCalendar: null
            }
        },
        mounted() {
            if (document.getElementById('calendar-pdf'))
                this.loadData();
        },
        methods: {
            loadData() {

                if (this.pProjectId === '0') {
                    this.initCalendar();
                    this.$eventHideOverlay.$emit('hide');
                } else {
                    let url = AdminConf.adminUrlBase() + AdminConf.adminApiUrlBase + `/get-calendar-data/${this.pProjectId}`;
                    axios.get(url)
                        .then((resp) => {
                            this.events = resp.data;
                            this.initCalendar();
                            this.$eventHideOverlay.$emit('hide');
                        });
                }
            },
            initCalendar() {
                this.elCalendar = $('#calendar-pdf').fullCalendar({
                    themeSystem: 'bootstrap3',
                    defaultView: 'month',
                    header: {
                        left: '',
                        center: 'title',
                        right: 'prev,next'
                    },
                    events: this.events,
                    eventRender: function (event, element) {
                        event._id = event.hashid;
                    },
                    select: function (start, end) {
                        $(".fc-highlight").css("background", "rgba(201, 45, 45, 0.49)");
                    },
                    eventClick: function (event) {
                        if (event.url) {
                            window.open(event.url);
                            return false;
                        }
                    }
                });

                $(".fc-prevYear-button").html(`<i class="fa fa-fast-backward"></i>`);
                $(".fc-nextYear-button").html(`<i class="fa fa-fast-forward"></i>`);
                $(".fc-prev-button").html(`<i class="fa fa-chevron-left"></i>`);
                $(".fc-next-button").html(`<i class="fa fa-chevron-right"></i>`);

                $(".fc-today-button").click(function () {
                    $("#lst_reports_content").find("ul li").removeClass('selected');
                });
            },
            selectEventCalendar(obj) {
                this.elCalendar.fullCalendar('gotoDate', obj.start);
                this.elCalendar.fullCalendar('select', obj.start);

                let el = $(`#_id_${obj.hashid}`);
                let elParent = el.parent('ul');
                elParent.find('li').removeClass('selected');

                el.addClass('selected');
            }
        }
    }
</script>