!function (e, t, n) {
    "use strict";
    n.extend(e.site, {
        init: function () {
            void 0 !== site.menubar && (site.menubar.init(), n(t).on("click", ".hamburger", function (e) {
                n(this).toggleClass("is-active")
            }), n(t).on("click", '[data-toggle="menubar-fold"]', function (e) {
                site.menubar.toggleFold(), e.preventDefault()
            }), n(t).on("click", '[data-toggle="menubar"]', function (e) {
                site.menubar.toggle(), e.preventDefault()
            }), n(e).on("resize orientationchange", function () {
                site.menubar.scroll.update()
            }), n(t).on("click", ".submenu-toggle", function (e) {
                site.menubar.menu.toggleOnClick(n(this)), e.preventDefault()
            }), n(t).on("mouseenter mouseleave", "body.menubar-fold .site-menu > li", function (e) {
                site.menubar.menu.toggleOnHover(n(this)), e.preventDefault()
            }), n(t).on("click", '[data-toggle="collapse"]', function (e) {
                var t = n(e.target);
                t.is('[data-toggle="collapse"]') || (t = t.parents('[data-toggle="collapse"]')), "site-navbar-collapse" === n(t.attr("data-target")).attr("id") && n("body").toggleClass("navbar-collapse-in"), e.preventDefault()
            }), Breakpoints.on("change", function () {
                site.menubar.change(), n('[data-toggle="menubar"]').toggleClass("is-active", site.menubar.opened), n('[data-toggle="menubar-fold"]').toggleClass("is-active", !site.menubar.folded)
            })), !/xs|sm/.test(Breakpoints.current().name) && n(".scroll-container").perfectScrollbar(), this.initPlugins()
        }
    })
}(window, document, jQuery), $(function () {
    site.init()
});