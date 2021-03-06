/* ===========================================================
 * bootstrap-tooltip.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#tooltips
 * Inspired by the original jQuery.tipsy by Jason Frame
 * ===========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


!function ($) {

    "use strict"; // jshint ;_;


    /* TOOLTIP PUBLIC CLASS DEFINITION
     * =============================== */

    var Tooltip = function (element, options) {
        this.init('tooltip', element, options)
    }

    Tooltip.prototype = {

        constructor: Tooltip

        , init: function (type, element, options) {
            var eventIn
                , eventOut

            this.type = type
            this.$element = $(element)
            this.options = this.getOptions(options)
            this.enabled = true

            if (this.options.trigger != 'manual') {
                eventIn  = this.options.trigger == 'hover' ? 'mouseenter' : 'focus'
                eventOut = this.options.trigger == 'hover' ? 'mouseleave' : 'blur'
                this.$element.on(eventIn, this.options.selector, $.proxy(this.enter, this))
                this.$element.on(eventOut, this.options.selector, $.proxy(this.leave, this))
            }

            this.options.selector ?
                (this._options = $.extend({}, this.options, { trigger: 'manual', selector: '' })) :
                this.fixTitle()
        }

        , getOptions: function (options) {
            options = $.extend({}, $.fn[this.type].defaults, options, this.$element.data())

            if (options.delay && typeof options.delay == 'number') {
                options.delay = {
                    show: options.delay
                    , hide: options.delay
                }
            }

            return options
        }

        , enter: function (e) {
            var self = $(e.currentTarget)[this.type](this._options).data(this.type)

            if (!self.options.delay || !self.options.delay.show) return self.show()

            clearTimeout(this.timeout)
            self.hoverState = 'in'
            this.timeout = setTimeout(function() {
                if (self.hoverState == 'in') self.show()
            }, self.options.delay.show)
        }

        , leave: function (e) {
            var self = $(e.currentTarget)[this.type](this._options).data(this.type)

            if (this.timeout) clearTimeout(this.timeout)
            if (!self.options.delay || !self.options.delay.hide) return self.hide()

            self.hoverState = 'out'
            this.timeout = setTimeout(function() {
                if (self.hoverState == 'out') self.hide()
            }, self.options.delay.hide)
        }

        , show: function () {
            var $tip
                , inside
                , pos
                , actualWidth
                , actualHeight
                , placement
                , tp

            if (this.hasContent() && this.enabled) {
                $tip = this.tip()
                this.setContent()

                if (this.options.animation) {
                    $tip.addClass('fade')
                }

                placement = typeof this.options.placement == 'function' ?
                    this.options.placement.call(this, $tip[0], this.$element[0]) :
                    this.options.placement

                inside = /in/.test(placement)

                $tip
                    .remove()
                    .css({ top: 0, left: 0, display: 'block' })
                    .appendTo(inside ? this.$element : document.body)

                pos = this.getPosition(inside)

                actualWidth = $tip[0].offsetWidth
                actualHeight = $tip[0].offsetHeight

                switch (inside ? placement.split(' ')[1] : placement) {
                    case 'bottom':
                        tp = {top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2}
                        break
                    case 'top':
                        tp = {top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2}
                        break
                    case 'left':
                        tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth}
                        break
                    case 'right':
                        tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width}
                        break
                }

                $tip
                    .css(tp)
                    .addClass(placement)
                    .addClass('in')
            }
        }

        , isHTML: function(text) {
            // html string detection logic adapted from jQuery
            return typeof text != 'string'
                || ( text.charAt(0) === "<"
                    && text.charAt( text.length - 1 ) === ">"
                    && text.length >= 3
                ) || /^(?:[^<]*<[\w\W]+>[^>]*$)/.exec(text)
        }

        , setContent: function () {
            var $tip = this.tip()
                , title = this.getTitle()

            $tip.find('.tooltip-inner')[this.isHTML(title) ? 'html' : 'text'](title)
            $tip.removeClass('fade in top bottom left right')
        }

        , hide: function () {
            var that = this
                , $tip = this.tip()

            $tip.removeClass('in')

            function removeWithAnimation() {
                var timeout = setTimeout(function () {
                    $tip.off($.support.transition.end).remove()
                }, 500)

                $tip.one($.support.transition.end, function () {
                    clearTimeout(timeout)
                    $tip.remove()
                })
            }

            $.support.transition && this.$tip.hasClass('fade') ?
                removeWithAnimation() :
                $tip.remove()
        }

        , fixTitle: function () {
            var $e = this.$element
            if ($e.attr('title') || typeof($e.attr('data-original-title')) != 'string') {
                $e.attr('data-original-title', $e.attr('title') || '').removeAttr('title')
            }
        }

        , hasContent: function () {
            return this.getTitle()
        }

        , getPosition: function (inside) {
            return $.extend({}, (inside ? {top: 0, left: 0} : this.$element.offset()), {
                width: this.$element[0].offsetWidth
                , height: this.$element[0].offsetHeight
            })
        }

        , getTitle: function () {
            var title
                , $e = this.$element
                , o = this.options

            title = $e.attr('data-original-title')
                || (typeof o.title == 'function' ? o.title.call($e[0]) :  o.title)

            return title
        }

        , tip: function () {
            return this.$tip = this.$tip || $(this.options.template)
        }

        , validate: function () {
            if (!this.$element[0].parentNode) {
                this.hide()
                this.$element = null
                this.options = null
            }
        }

        , enable: function () {
            this.enabled = true
        }

        , disable: function () {
            this.enabled = false
        }

        , toggleEnabled: function () {
            this.enabled = !this.enabled
        }

        , toggle: function () {
            this[this.tip().hasClass('in') ? 'hide' : 'show']()
        }

    }


    /* TOOLTIP PLUGIN DEFINITION
     * ========================= */

    $.fn.tooltip = function ( option ) {
        return this.each(function () {
            var $this = $(this)
                , data = $this.data('tooltip')
                , options = typeof option == 'object' && option
            if (!data) $this.data('tooltip', (data = new Tooltip(this, options)))
            if (typeof option == 'string') data[option]()
        })
    }

    $.fn.tooltip.Constructor = Tooltip

    $.fn.tooltip.defaults = {
        animation: true
        , placement: 'top'
        , selector: false
        , template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
        , trigger: 'hover'
        , title: ''
        , delay: 0
    }

}(window.jQuery);
/*
if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript.");+function(t){var e=jQuery.fn.jquery.split(" ")[0].split(".");if(e[0]<2&&e[1]<9||1==e[0]&&9==e[1]&&e[2]<1||e[0]>=4)throw new Error("Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0")}(),function(){function t(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e}function e(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}function n(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}var i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},o=function(){function t(t,e){for(var n=0;n<e.length;n++){var i=e[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(t,i.key,i)}}return function(e,n,i){return n&&t(e.prototype,n),i&&t(e,i),e}}(),r=function(t){function e(t){return{}.toString.call(t).match(/\s([a-zA-Z]+)/)[1].toLowerCase()}function n(t){return(t[0]||t).nodeType}function i(){return{bindType:s.end,delegateType:s.end,handle:function(e){if(t(e.target).is(this))return e.handleObj.handler.apply(this,arguments)}}}function o(){if(window.QUnit)return!1;var t=document.createElement("bootstrap");for(var e in a)if(void 0!==t.style[e])return{end:a[e]};return!1}function r(e){var n=this,i=!1;return t(this).one(l.TRANSITION_END,function(){i=!0}),setTimeout(function(){i||l.triggerTransitionEnd(n)},e),this}var s=!1,a={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"},l={TRANSITION_END:"bsTransitionEnd",getUID:function(t){do{t+=~~(1e6*Math.random())}while(document.getElementById(t));return t},getSelectorFromElement:function(t){var e=t.getAttribute("data-target");return e||(e=t.getAttribute("href")||"",e=/^#[a-z]/i.test(e)?e:null),e},reflow:function(t){return t.offsetHeight},triggerTransitionEnd:function(e){t(e).trigger(s.end)},supportsTransitionEnd:function(){return Boolean(s)},typeCheckConfig:function(t,i,o){for(var r in o)if(o.hasOwnProperty(r)){var s=o[r],a=i[r],l=a&&n(a)?"element":e(a);if(!new RegExp(s).test(l))throw new Error(t.toUpperCase()+': Option "'+r+'" provided type "'+l+'" but expected type "'+s+'".')}}};return s=o(),t.fn.emulateTransitionEnd=r,l.supportsTransitionEnd()&&(t.event.special[l.TRANSITION_END]=i()),l}(jQuery),s=(function(t){var e="alert",i="bs.alert",s="."+i,a=t.fn[e],l={DISMISS:'[data-dismiss="alert"]'},h={CLOSE:"close"+s,CLOSED:"closed"+s,CLICK_DATA_API:"click"+s+".data-api"},c={ALERT:"alert",FADE:"fade",SHOW:"show"},u=function(){function e(t){n(this,e),this._element=t}return e.prototype.close=function(t){t=t||this._element;var e=this._getRootElement(t);this._triggerCloseEvent(e).isDefaultPrevented()||this._removeElement(e)},e.prototype.dispose=function(){t.removeData(this._element,i),this._element=null},e.prototype._getRootElement=function(e){var n=r.getSelectorFromElement(e),i=!1;return n&&(i=t(n)[0]),i||(i=t(e).closest("."+c.ALERT)[0]),i},e.prototype._triggerCloseEvent=function(e){var n=t.Event(h.CLOSE);return t(e).trigger(n),n},e.prototype._removeElement=function(e){var n=this;return t(e).removeClass(c.SHOW),r.supportsTransitionEnd()&&t(e).hasClass(c.FADE)?void t(e).one(r.TRANSITION_END,function(t){return n._destroyElement(e,t)}).emulateTransitionEnd(150):void this._destroyElement(e)},e.prototype._destroyElement=function(e){t(e).detach().trigger(h.CLOSED).remove()},e._jQueryInterface=function(n){return this.each(function(){var o=t(this),r=o.data(i);r||(r=new e(this),o.data(i,r)),"close"===n&&r[n](this)})},e._handleDismiss=function(t){return function(e){e&&e.preventDefault(),t.close(this)}},o(e,null,[{key:"VERSION",get:function(){return"4.0.0-alpha.6"}}]),e}();t(document).on(h.CLICK_DATA_API,l.DISMISS,u._handleDismiss(new u)),t.fn[e]=u._jQueryInterface,t.fn[e].Constructor=u,t.fn[e].noConflict=function(){return t.fn[e]=a,u._jQueryInterface}}(jQuery),function(t){var e="button",i="bs.button",r="."+i,s=".data-api",a=t.fn[e],l={ACTIVE:"active",BUTTON:"btn",FOCUS:"focus"},h={DATA_TOGGLE_CARROT:'[data-toggle^="button"]',DATA_TOGGLE:'[data-toggle="buttons"]',INPUT:"input",ACTIVE:".active",BUTTON:".btn"},c={CLICK_DATA_API:"click"+r+s,FOCUS_BLUR_DATA_API:"focus"+r+s+" blur"+r+s},u=function(){function e(t){n(this,e),this._element=t}return e.prototype.toggle=function(){var e=!0,n=t(this._element).closest(h.DATA_TOGGLE)[0];if(n){var i=t(this._element).find(h.INPUT)[0];if(i){if("radio"===i.type)if(i.checked&&t(this._element).hasClass(l.ACTIVE))e=!1;else{var o=t(n).find(h.ACTIVE)[0];o&&t(o).removeClass(l.ACTIVE)}e&&(i.checked=!t(this._element).hasClass(l.ACTIVE),t(i).trigger("change")),i.focus()}}this._element.setAttribute("aria-pressed",!t(this._element).hasClass(l.ACTIVE)),e&&t(this._element).toggleClass(l.ACTIVE)},e.prototype.dispose=function(){t.removeData(this._element,i),this._element=null},e._jQueryInterface=function(n){return this.each(function(){var o=t(this).data(i);o||(o=new e(this),t(this).data(i,o)),"toggle"===n&&o[n]()})},o(e,null,[{key:"VERSION",get:function(){return"4.0.0-alpha.6"}}]),e}();t(document).on(c.CLICK_DATA_API,h.DATA_TOGGLE_CARROT,function(e){e.preventDefault();var n=e.target;t(n).hasClass(l.BUTTON)||(n=t(n).closest(h.BUTTON)),u._jQueryInterface.call(t(n),"toggle")}).on(c.FOCUS_BLUR_DATA_API,h.DATA_TOGGLE_CARROT,function(e){var n=t(e.target).closest(h.BUTTON)[0];t(n).toggleClass(l.FOCUS,/^focus(in)?$/.test(e.type))}),t.fn[e]=u._jQueryInterface,t.fn[e].Constructor=u,t.fn[e].noConflict=function(){return t.fn[e]=a,u._jQueryInterface}}(jQuery),function(t){var e="carousel",s="bs.carousel",a="."+s,l=".data-api",h=t.fn[e],c={interval:5e3,keyboard:!0,slide:!1,pause:"hover",wrap:!0},u={interval:"(number|boolean)",keyboard:"boolean",slide:"(boolean|string)",pause:"(string|boolean)",wrap:"boolean"},d={NEXT:"next",PREV:"prev",LEFT:"left",RIGHT:"right"},f={SLIDE:"slide"+a,SLID:"slid"+a,KEYDOWN:"keydown"+a,MOUSEENTER:"mouseenter"+a,MOUSELEAVE:"mouseleave"+a,LOAD_DATA_API:"load"+a+l,CLICK_DATA_API:"click"+a+l},_={CAROUSEL:"carousel",ACTIVE:"active",SLIDE:"slide",RIGHT:"carousel-item-right",LEFT:"carousel-item-left",NEXT:"carousel-item-next",PREV:"carousel-item-prev",ITEM:"carousel-item"},g={ACTIVE:".active",ACTIVE_ITEM:".active.carousel-item",ITEM:".carousel-item",NEXT_PREV:".carousel-item-next, .carousel-item-prev",INDICATORS:".carousel-indicators",DATA_SLIDE:"[data-slide], [data-slide-to]",DATA_RIDE:'[data-ride="carousel"]'},p=function(){function l(e,i){n(this,l),this._items=null,this._interval=null,this._activeElement=null,this._isPaused=!1,this._isSliding=!1,this._config=this._getConfig(i),this._element=t(e)[0],this._indicatorsElement=t(this._element).find(g.INDICATORS)[0],this._addEventListeners()}return l.prototype.next=function(){if(this._isSliding)throw new Error("Carousel is sliding");this._slide(d.NEXT)},l.prototype.nextWhenVisible=function(){document.hidden||this.next()},l.prototype.prev=function(){if(this._isSliding)throw new Error("Carousel is sliding");this._slide(d.PREVIOUS)},l.prototype.pause=function(e){e||(this._isPaused=!0),t(this._element).find(g.NEXT_PREV)[0]&&r.supportsTransitionEnd()&&(r.triggerTransitionEnd(this._element),this.cycle(!0)),clearInterval(this._interval),this._interval=null},l.prototype.cycle=function(t){t||(this._isPaused=!1),this._interval&&(clearInterval(this._interval),this._interval=null),this._config.interval&&!this._isPaused&&(this._interval=setInterval((document.visibilityState?this.nextWhenVisible:this.next).bind(this),this._config.interval))},l.prototype.to=function(e){var n=this;this._activeElement=t(this._element).find(g.ACTIVE_ITEM)[0];var i=this._getItemIndex(this._activeElement);if(!(e>this._items.length-1||e<0)){if(this._isSliding)return void t(this._element).one(f.SLID,function(){return n.to(e)});if(i===e)return this.pause(),void this.cycle();var o=e>i?d.NEXT:d.PREVIOUS;this._slide(o,this._items[e])}},l.prototype.dispose=function(){t(this._element).off(a),t.removeData(this._element,s),this._items=null,this._config=null,this._element=null,this._interval=null,this._isPaused=null,this._isSliding=null,this._activeElement=null,this._indicatorsElement=null},l.prototype._getConfig=function(n){return n=t.extend({},c,n),r.typeCheckConfig(e,n,u),n},l.prototype._addEventListeners=function(){var e=this;this._config.keyboard&&t(this._element).on(f.KEYDOWN,function(t){return e._keydown(t)}),"hover"!==this._config.pause||"ontouchstart"in document.documentElement||t(this._element).on(f.MOUSEENTER,function(t){return e.pause(t)}).on(f.MOUSELEAVE,function(t){return e.cycle(t)})},l.prototype._keydown=function(t){if(!/input|textarea/i.test(t.target.tagName))switch(t.which){case 37:t.preventDefault(),this.prev();break;case 39:t.preventDefault(),this.next();break;default:return}},l.prototype._getItemIndex=function(e){return this._items=t.makeArray(t(e).parent().find(g.ITEM)),this._items.indexOf(e)},l.prototype._getItemByDirection=function(t,e){var n=t===d.NEXT,i=t===d.PREVIOUS,o=this._getItemIndex(e),r=this._items.length-1;if((i&&0===o||n&&o===r)&&!this._config.wrap)return e;var s=(o+(t===d.PREVIOUS?-1:1))%this._items.length;return-1===s?this._items[this._items.length-1]:this._items[s]},l.prototype._triggerSlideEvent=function(e,n){var i=t.Event(f.SLIDE,{relatedTarget:e,direction:n});return t(this._element).trigger(i),i},l.prototype._setActiveIndicatorElement=function(e){if(this._indicatorsElement){t(this._indicatorsElement).find(g.ACTIVE).removeClass(_.ACTIVE);var n=this._indicatorsElement.children[this._getItemIndex(e)];n&&t(n).addClass(_.ACTIVE)}},l.prototype._slide=function(e,n){var i=this,o=t(this._element).find(g.ACTIVE_ITEM)[0],s=n||o&&this._getItemByDirection(e,o),a=Boolean(this._interval),l=void 0,h=void 0,c=void 0;if(e===d.NEXT?(l=_.LEFT,h=_.NEXT,c=d.LEFT):(l=_.RIGHT,h=_.PREV,c=d.RIGHT),s&&t(s).hasClass(_.ACTIVE))this._isSliding=!1;else if(!this._triggerSlideEvent(s,c).isDefaultPrevented()&&o&&s){this._isSliding=!0,a&&this.pause(),this._setActiveIndicatorElement(s);var u=t.Event(f.SLID,{relatedTarget:s,direction:c});r.supportsTransitionEnd()&&t(this._element).hasClass(_.SLIDE)?(t(s).addClass(h),r.reflow(s),t(o).addClass(l),t(s).addClass(l),t(o).one(r.TRANSITION_END,function(){t(s).removeClass(l+" "+h).addClass(_.ACTIVE),t(o).removeClass(_.ACTIVE+" "+h+" "+l),i._isSliding=!1,setTimeout(function(){return t(i._element).trigger(u)},0)}).emulateTransitionEnd(600)):(t(o).removeClass(_.ACTIVE),t(s).addClass(_.ACTIVE),this._isSliding=!1,t(this._element).trigger(u)),a&&this.cycle()}},l._jQueryInterface=function(e){return this.each(function(){var n=t(this).data(s),o=t.extend({},c,t(this).data());"object"===(void 0===e?"undefined":i(e))&&t.extend(o,e);var r="string"==typeof e?e:o.slide;if(n||(n=new l(this,o),t(this).data(s,n)),"number"==typeof e)n.to(e);else if("string"==typeof r){if(void 0===n[r])throw new Error('No method named "'+r+'"');n[r]()}else o.interval&&(n.pause(),n.cycle())})},l._dataApiClickHandler=function(e){var n=r.getSelectorFromElement(this);if(n){var i=t(n)[0];if(i&&t(i).hasClass(_.CAROUSEL)){var o=t.extend({},t(i).data(),t(this).data()),a=this.getAttribute("data-slide-to");a&&(o.interval=!1),l._jQueryInterface.call(t(i),o),a&&t(i).data(s).to(a),e.preventDefault()}}},o(l,null,[{key:"VERSION",get:function(){return"4.0.0-alpha.6"}},{key:"Default",get:function(){return c}}]),l}();t(document).on(f.CLICK_DATA_API,g.DATA_SLIDE,p._dataApiClickHandler),t(window).on(f.LOAD_DATA_API,function(){t(g.DATA_RIDE).each(function(){var e=t(this);p._jQueryInterface.call(e,e.data())})}),t.fn[e]=p._jQueryInterface,t.fn[e].Constructor=p,t.fn[e].noConflict=function(){return t.fn[e]=h,p._jQueryInterface}}(jQuery),function(t){var e="collapse",s="bs.collapse",a="."+s,l=t.fn[e],h={toggle:!0,parent:""},c={toggle:"boolean",parent:"string"},u={SHOW:"show"+a,SHOWN:"shown"+a,HIDE:"hide"+a,HIDDEN:"hidden"+a,CLICK_DATA_API:"click"+a+".data-api"},d={SHOW:"show",COLLAPSE:"collapse",COLLAPSING:"collapsing",COLLAPSED:"collapsed"},f={WIDTH:"width",HEIGHT:"height"},_={ACTIVES:".card > .show, .card > .collapsing",DATA_TOGGLE:'[data-toggle="collapse"]'},g=function(){function a(e,i){n(this,a),this._isTransitioning=!1,this._element=e,this._config=this._getConfig(i),this._triggerArray=t.makeArray(t('[data-toggle="collapse"][href="#'+e.id+'"],[data-toggle="collapse"][data-target="#'+e.id+'"]')),this._parent=this._config.parent?this._getParent():null,this._config.parent||this._addAriaAndCollapsedClass(this._element,this._triggerArray),this._config.toggle&&this.toggle()}return a.prototype.toggle=function(){t(this._element).hasClass(d.SHOW)?this.hide():this.show()},a.prototype.show=function(){var e=this;if(this._isTransitioning)throw new Error("Collapse is transitioning");if(!t(this._element).hasClass(d.SHOW)){var n=void 0,i=void 0;if(this._parent&&((n=t.makeArray(t(this._parent).find(_.ACTIVES))).length||(n=null)),!(n&&(i=t(n).data(s))&&i._isTransitioning)){var o=t.Event(u.SHOW);if(t(this._element).trigger(o),!o.isDefaultPrevented()){n&&(a._jQueryInterface.call(t(n),"hide"),i||t(n).data(s,null));var l=this._getDimension();t(this._element).removeClass(d.COLLAPSE).addClass(d.COLLAPSING),this._element.style[l]=0,this._element.setAttribute("aria-expanded",!0),this._triggerArray.length&&t(this._triggerArray).removeClass(d.COLLAPSED).attr("aria-expanded",!0),this.setTransitioning(!0);var h=function(){t(e._element).removeClass(d.COLLAPSING).addClass(d.COLLAPSE).addClass(d.SHOW),e._element.style[l]="",e.setTransitioning(!1),t(e._element).trigger(u.SHOWN)};if(!r.supportsTransitionEnd())return void h();var c="scroll"+(l[0].toUpperCase()+l.slice(1));t(this._element).one(r.TRANSITION_END,h).emulateTransitionEnd(600),this._element.style[l]=this._element[c]+"px"}}}},a.prototype.hide=function(){var e=this;if(this._isTransitioning)throw new Error("Collapse is transitioning");if(t(this._element).hasClass(d.SHOW)){var n=t.Event(u.HIDE);if(t(this._element).trigger(n),!n.isDefaultPrevented()){var i=this._getDimension(),o=i===f.WIDTH?"offsetWidth":"offsetHeight";this._element.style[i]=this._element[o]+"px",r.reflow(this._element),t(this._element).addClass(d.COLLAPSING).removeClass(d.COLLAPSE).removeClass(d.SHOW),this._element.setAttribute("aria-expanded",!1),this._triggerArray.length&&t(this._triggerArray).addClass(d.COLLAPSED).attr("aria-expanded",!1),this.setTransitioning(!0);var s=function(){e.setTransitioning(!1),t(e._element).removeClass(d.COLLAPSING).addClass(d.COLLAPSE).trigger(u.HIDDEN)};return this._element.style[i]="",r.supportsTransitionEnd()?void t(this._element).one(r.TRANSITION_END,s).emulateTransitionEnd(600):void s()}}},a.prototype.setTransitioning=function(t){this._isTransitioning=t},a.prototype.dispose=function(){t.removeData(this._element,s),this._config=null,this._parent=null,this._element=null,this._triggerArray=null,this._isTransitioning=null},a.prototype._getConfig=function(n){return n=t.extend({},h,n),n.toggle=Boolean(n.toggle),r.typeCheckConfig(e,n,c),n},a.prototype._getDimension=function(){return t(this._element).hasClass(f.WIDTH)?f.WIDTH:f.HEIGHT},a.prototype._getParent=function(){var e=this,n=t(this._config.parent)[0],i='[data-toggle="collapse"][data-parent="'+this._config.parent+'"]';return t(n).find(i).each(function(t,n){e._addAriaAndCollapsedClass(a._getTargetFromElement(n),[n])}),n},a.prototype._addAriaAndCollapsedClass=function(e,n){if(e){var i=t(e).hasClass(d.SHOW);e.setAttribute("aria-expanded",i),n.length&&t(n).toggleClass(d.COLLAPSED,!i).attr("aria-expanded",i)}},a._getTargetFromElement=function(e){var n=r.getSelectorFromElement(e);return n?t(n)[0]:null},a._jQueryInterface=function(e){return this.each(function(){var n=t(this),o=n.data(s),r=t.extend({},h,n.data(),"object"===(void 0===e?"undefined":i(e))&&e);if(!o&&r.toggle&&/show|hide/.test(e)&&(r.toggle=!1),o||(o=new a(this,r),n.data(s,o)),"string"==typeof e){if(void 0===o[e])throw new Error('No method named "'+e+'"');o[e]()}})},o(a,null,[{key:"VERSION",get:function(){return"4.0.0-alpha.6"}},{key:"Default",get:function(){return h}}]),a}();t(document).on(u.CLICK_DATA_API,_.DATA_TOGGLE,function(e){e.preventDefault();var n=g._getTargetFromElement(this),i=t(n).data(s)?"toggle":t(this).data();g._jQueryInterface.call(t(n),i)}),t.fn[e]=g._jQueryInterface,t.fn[e].Constructor=g,t.fn[e].noConflict=function(){return t.fn[e]=l,g._jQueryInterface}}(jQuery),function(t){var e="dropdown",i="bs.dropdown",s="."+i,a=".data-api",l=t.fn[e],h={HIDE:"hide"+s,HIDDEN:"hidden"+s,SHOW:"show"+s,SHOWN:"shown"+s,CLICK:"click"+s,CLICK_DATA_API:"click"+s+a,FOCUSIN_DATA_API:"focusin"+s+a,KEYDOWN_DATA_API:"keydown"+s+a},c={BACKDROP:"dropdown-backdrop",DISABLED:"disabled",SHOW:"show"},u={BACKDROP:".dropdown-backdrop",DATA_TOGGLE:'[data-toggle="dropdown"]',FORM_CHILD:".dropdown form",ROLE_MENU:'[role="menu"]',ROLE_LISTBOX:'[role="listbox"]',NAVBAR_NAV:".navbar-nav",VISIBLE_ITEMS:'[role="menu"] li:not(.disabled) a, [role="listbox"] li:not(.disabled) a'},d=function(){function e(t){n(this,e),this._element=t,this._addEventListeners()}return e.prototype.toggle=function(){if(this.disabled||t(this).hasClass(c.DISABLED))return!1;var n=e._getParentFromElement(this),i=t(n).hasClass(c.SHOW);if(e._clearMenus(),i)return!1;if("ontouchstart"in document.documentElement&&!t(n).closest(u.NAVBAR_NAV).length){var o=document.createElement("div");o.className=c.BACKDROP,t(o).insertBefore(this),t(o).on("click",e._clearMenus)}var r={relatedTarget:this},s=t.Event(h.SHOW,r);return t(n).trigger(s),!s.isDefaultPrevented()&&(this.focus(),this.setAttribute("aria-expanded",!0),t(n).toggleClass(c.SHOW),t(n).trigger(t.Event(h.SHOWN,r)),!1)},e.prototype.dispose=function(){t.removeData(this._element,i),t(this._element).off(s),this._element=null},e.prototype._addEventListeners=function(){t(this._element).on(h.CLICK,this.toggle)},e._jQueryInterface=function(n){return this.each(function(){var o=t(this).data(i);if(o||(o=new e(this),t(this).data(i,o)),"string"==typeof n){if(void 0===o[n])throw new Error('No method named "'+n+'"');o[n].call(this)}})},e._clearMenus=function(n){if(!n||3!==n.which){var i=t(u.BACKDROP)[0];i&&i.parentNode.removeChild(i);for(var o=t.makeArray(t(u.DATA_TOGGLE)),r=0;r<o.length;r++){var s=e._getParentFromElement(o[r]),a={relatedTarget:o[r]};if(t(s).hasClass(c.SHOW)&&!(n&&("click"===n.type&&/input|textarea/i.test(n.target.tagName)||"focusin"===n.type)&&t.contains(s,n.target))){var l=t.Event(h.HIDE,a);t(s).trigger(l),l.isDefaultPrevented()||(o[r].setAttribute("aria-expanded","false"),t(s).removeClass(c.SHOW).trigger(t.Event(h.HIDDEN,a)))}}}},e._getParentFromElement=function(e){var n=void 0,i=r.getSelectorFromElement(e);return i&&(n=t(i)[0]),n||e.parentNode},e._dataApiKeydownHandler=function(n){if(/(38|40|27|32)/.test(n.which)&&!/input|textarea/i.test(n.target.tagName)&&(n.preventDefault(),n.stopPropagation(),!this.disabled&&!t(this).hasClass(c.DISABLED))){var i=e._getParentFromElement(this),o=t(i).hasClass(c.SHOW);if(!o&&27!==n.which||o&&27===n.which){if(27===n.which){var r=t(i).find(u.DATA_TOGGLE)[0];t(r).trigger("focus")}return void t(this).trigger("click")}var s=t(i).find(u.VISIBLE_ITEMS).get();if(s.length){var a=s.indexOf(n.target);38===n.which&&a>0&&a--,40===n.which&&a<s.length-1&&a++,a<0&&(a=0),s[a].focus()}}},o(e,null,[{key:"VERSION",get:function(){return"4.0.0-alpha.6"}}]),e}();t(document).on(h.KEYDOWN_DATA_API,u.DATA_TOGGLE,d._dataApiKeydownHandler).on(h.KEYDOWN_DATA_API,u.ROLE_MENU,d._dataApiKeydownHandler).on(h.KEYDOWN_DATA_API,u.ROLE_LISTBOX,d._dataApiKeydownHandler).on(h.CLICK_DATA_API+" "+h.FOCUSIN_DATA_API,d._clearMenus).on(h.CLICK_DATA_API,u.DATA_TOGGLE,d.prototype.toggle).on(h.CLICK_DATA_API,u.FORM_CHILD,function(t){t.stopPropagation()}),t.fn[e]=d._jQueryInterface,t.fn[e].Constructor=d,t.fn[e].noConflict=function(){return t.fn[e]=l,d._jQueryInterface}}(jQuery),function(t){var e="modal",s="bs.modal",a="."+s,l=t.fn[e],h={backdrop:!0,keyboard:!0,focus:!0,show:!0},c={backdrop:"(boolean|string)",keyboard:"boolean",focus:"boolean",show:"boolean"},u={HIDE:"hide"+a,HIDDEN:"hidden"+a,SHOW:"show"+a,SHOWN:"shown"+a,FOCUSIN:"focusin"+a,RESIZE:"resize"+a,CLICK_DISMISS:"click.dismiss"+a,KEYDOWN_DISMISS:"keydown.dismiss"+a,MOUSEUP_DISMISS:"mouseup.dismiss"+a,MOUSEDOWN_DISMISS:"mousedown.dismiss"+a,CLICK_DATA_API:"click"+a+".data-api"},d={SCROLLBAR_MEASURER:"modal-scrollbar-measure",BACKDROP:"modal-backdrop",OPEN:"modal-open",FADE:"fade",SHOW:"show"},f={DIALOG:".modal-dialog",DATA_TOGGLE:'[data-toggle="modal"]',DATA_DISMISS:'[data-dismiss="modal"]',FIXED_CONTENT:".fixed-top, .fixed-bottom, .is-fixed, .sticky-top"},_=function(){function l(e,i){n(this,l),this._config=this._getConfig(i),this._element=e,this._dialog=t(e).find(f.DIALOG)[0],this._backdrop=null,this._isShown=!1,this._isBodyOverflowing=!1,this._ignoreBackdropClick=!1,this._isTransitioning=!1,this._originalBodyPadding=0,this._scrollbarWidth=0}return l.prototype.toggle=function(t){return this._isShown?this.hide():this.show(t)},l.prototype.show=function(e){var n=this;if(this._isTransitioning)throw new Error("Modal is transitioning");r.supportsTransitionEnd()&&t(this._element).hasClass(d.FADE)&&(this._isTransitioning=!0);var i=t.Event(u.SHOW,{relatedTarget:e});t(this._element).trigger(i),this._isShown||i.isDefaultPrevented()||(this._isShown=!0,this._checkScrollbar(),this._setScrollbar(),t(document.body).addClass(d.OPEN),this._setEscapeEvent(),this._setResizeEvent(),t(this._element).on(u.CLICK_DISMISS,f.DATA_DISMISS,function(t){return n.hide(t)}),t(this._dialog).on(u.MOUSEDOWN_DISMISS,function(){t(n._element).one(u.MOUSEUP_DISMISS,function(e){t(e.target).is(n._element)&&(n._ignoreBackdropClick=!0)})}),this._showBackdrop(function(){return n._showElement(e)}))},l.prototype.hide=function(e){var n=this;if(e&&e.preventDefault(),this._isTransitioning)throw new Error("Modal is transitioning");var i=r.supportsTransitionEnd()&&t(this._element).hasClass(d.FADE);i&&(this._isTransitioning=!0);var o=t.Event(u.HIDE);t(this._element).trigger(o),this._isShown&&!o.isDefaultPrevented()&&(this._isShown=!1,this._setEscapeEvent(),this._setResizeEvent(),t(document).off(u.FOCUSIN),t(this._element).removeClass(d.SHOW),t(this._element).off(u.CLICK_DISMISS),t(this._dialog).off(u.MOUSEDOWN_DISMISS),i?t(this._element).one(r.TRANSITION_END,function(t){return n._hideModal(t)}).emulateTransitionEnd(300):this._hideModal())},l.prototype.dispose=function(){t.removeData(this._element,s),t(window,document,this._element,this._backdrop).off(a),this._config=null,this._element=null,this._dialog=null,this._backdrop=null,this._isShown=null,this._isBodyOverflowing=null,this._ignoreBackdropClick=null,this._originalBodyPadding=null,this._scrollbarWidth=null},l.prototype._getConfig=function(n){return n=t.extend({},h,n),r.typeCheckConfig(e,n,c),n},l.prototype._showElement=function(e){var n=this,i=r.supportsTransitionEnd()&&t(this._element).hasClass(d.FADE);this._element.parentNode&&this._element.parentNode.nodeType===Node.ELEMENT_NODE||document.body.appendChild(this._element),this._element.style.display="block",this._element.removeAttribute("aria-hidden"),this._element.scrollTop=0,i&&r.reflow(this._element),t(this._element).addClass(d.SHOW),this._config.focus&&this._enforceFocus();var o=t.Event(u.SHOWN,{relatedTarget:e}),s=function(){n._config.focus&&n._element.focus(),n._isTransitioning=!1,t(n._element).trigger(o)};i?t(this._dialog).one(r.TRANSITION_END,s).emulateTransitionEnd(300):s()},l.prototype._enforceFocus=function(){var e=this;t(document).off(u.FOCUSIN).on(u.FOCUSIN,function(n){document===n.target||e._element===n.target||t(e._element).has(n.target).length||e._element.focus()})},l.prototype._setEscapeEvent=function(){var e=this;this._isShown&&this._config.keyboard?t(this._element).on(u.KEYDOWN_DISMISS,function(t){27===t.which&&e.hide()}):this._isShown||t(this._element).off(u.KEYDOWN_DISMISS)},l.prototype._setResizeEvent=function(){var e=this;this._isShown?t(window).on(u.RESIZE,function(t){return e._handleUpdate(t)}):t(window).off(u.RESIZE)},l.prototype._hideModal=function(){var e=this;this._element.style.display="none",this._element.setAttribute("aria-hidden","true"),this._isTransitioning=!1,this._showBackdrop(function(){t(document.body).removeClass(d.OPEN),e._resetAdjustments(),e._resetScrollbar(),t(e._element).trigger(u.HIDDEN)})},l.prototype._removeBackdrop=function(){this._backdrop&&(t(this._backdrop).remove(),this._backdrop=null)},l.prototype._showBackdrop=function(e){var n=this,i=t(this._element).hasClass(d.FADE)?d.FADE:"";if(this._isShown&&this._config.backdrop){var o=r.supportsTransitionEnd()&&i;if(this._backdrop=document.createElement("div"),this._backdrop.className=d.BACKDROP,i&&t(this._backdrop).addClass(i),t(this._backdrop).appendTo(document.body),t(this._element).on(u.CLICK_DISMISS,function(t){return n._ignoreBackdropClick?void(n._ignoreBackdropClick=!1):void(t.target===t.currentTarget&&("static"===n._config.backdrop?n._element.focus():n.hide()))}),o&&r.reflow(this._backdrop),t(this._backdrop).addClass(d.SHOW),!e)return;if(!o)return void e();t(this._backdrop).one(r.TRANSITION_END,e).emulateTransitionEnd(150)}else if(!this._isShown&&this._backdrop){t(this._backdrop).removeClass(d.SHOW);var s=function(){n._removeBackdrop(),e&&e()};r.supportsTransitionEnd()&&t(this._element).hasClass(d.FADE)?t(this._backdrop).one(r.TRANSITION_END,s).emulateTransitionEnd(150):s()}else e&&e()},l.prototype._handleUpdate=function(){this._adjustDialog()},l.prototype._adjustDialog=function(){var t=this._element.scrollHeight>document.documentElement.clientHeight;!this._isBodyOverflowing&&t&&(this._element.style.paddingLeft=this._scrollbarWidth+"px"),this._isBodyOverflowing&&!t&&(this._element.style.paddingRight=this._scrollbarWidth+"px")},l.prototype._resetAdjustments=function(){this._element.style.paddingLeft="",this._element.style.paddingRight=""},l.prototype._checkScrollbar=function(){this._isBodyOverflowing=document.body.clientWidth<window.innerWidth,this._scrollbarWidth=this._getScrollbarWidth()},l.prototype._setScrollbar=function(){var e=parseInt(t(f.FIXED_CONTENT).css("padding-right")||0,10);this._originalBodyPadding=document.body.style.paddingRight||"",this._isBodyOverflowing&&(document.body.style.paddingRight=e+this._scrollbarWidth+"px")},l.prototype._resetScrollbar=function(){document.body.style.paddingRight=this._originalBodyPadding},l.prototype._getScrollbarWidth=function(){var t=document.createElement("div");t.className=d.SCROLLBAR_MEASURER,document.body.appendChild(t);var e=t.offsetWidth-t.clientWidth;return document.body.removeChild(t),e},l._jQueryInterface=function(e,n){return this.each(function(){var o=t(this).data(s),r=t.extend({},l.Default,t(this).data(),"object"===(void 0===e?"undefined":i(e))&&e);if(o||(o=new l(this,r),t(this).data(s,o)),"string"==typeof e){if(void 0===o[e])throw new Error('No method named "'+e+'"');o[e](n)}else r.show&&o.show(n)})},o(l,null,[{key:"VERSION",get:function(){return"4.0.0-alpha.6"}},{key:"Default",get:function(){return h}}]),l}();t(document).on(u.CLICK_DATA_API,f.DATA_TOGGLE,function(e){var n=this,i=void 0,o=r.getSelectorFromElement(this);o&&(i=t(o)[0]);var a=t(i).data(s)?"toggle":t.extend({},t(i).data(),t(this).data());"A"!==this.tagName&&"AREA"!==this.tagName||e.preventDefault();var l=t(i).one(u.SHOW,function(e){e.isDefaultPrevented()||l.one(u.HIDDEN,function(){t(n).is(":visible")&&n.focus()})});_._jQueryInterface.call(t(i),a,this)}),t.fn[e]=_._jQueryInterface,t.fn[e].Constructor=_,t.fn[e].noConflict=function(){return t.fn[e]=l,_._jQueryInterface}}(jQuery),function(t){var e="scrollspy",s="bs.scrollspy",a="."+s,l=t.fn[e],h={offset:10,method:"auto",target:""},c={offset:"number",method:"string",target:"(string|element)"},u={ACTIVATE:"activate"+a,SCROLL:"scroll"+a,LOAD_DATA_API:"load"+a+".data-api"},d={DROPDOWN_ITEM:"dropdown-item",DROPDOWN_MENU:"dropdown-menu",NAV_LINK:"nav-link",NAV:"nav",ACTIVE:"active"},f={DATA_SPY:'[data-spy="scroll"]',ACTIVE:".active",LIST_ITEM:".list-item",LI:"li",LI_DROPDOWN:"li.dropdown",NAV_LINKS:".nav-link",DROPDOWN:".dropdown",DROPDOWN_ITEMS:".dropdown-item",DROPDOWN_TOGGLE:".dropdown-toggle"},_={OFFSET:"offset",POSITION:"position"},g=function(){function l(e,i){var o=this;n(this,l),this._element=e,this._scrollElement="BODY"===e.tagName?window:e,this._config=this._getConfig(i),this._selector=this._config.target+" "+f.NAV_LINKS+","+this._config.target+" "+f.DROPDOWN_ITEMS,this._offsets=[],this._targets=[],this._activeTarget=null,this._scrollHeight=0,t(this._scrollElement).on(u.SCROLL,function(t){return o._process(t)}),this.refresh(),this._process()}return l.prototype.refresh=function(){var e=this,n=this._scrollElement!==this._scrollElement.window?_.POSITION:_.OFFSET,i="auto"===this._config.method?n:this._config.method,o=i===_.POSITION?this._getScrollTop():0;this._offsets=[],this._targets=[],this._scrollHeight=this._getScrollHeight(),t.makeArray(t(this._selector)).map(function(e){var n=void 0,s=r.getSelectorFromElement(e);return s&&(n=t(s)[0]),n&&(n.offsetWidth||n.offsetHeight)?[t(n)[i]().top+o,s]:null}).filter(function(t){return t}).sort(function(t,e){return t[0]-e[0]}).forEach(function(t){e._offsets.push(t[0]),e._targets.push(t[1])})},l.prototype.dispose=function(){t.removeData(this._element,s),t(this._scrollElement).off(a),this._element=null,this._scrollElement=null,this._config=null,this._selector=null,this._offsets=null,this._targets=null,this._activeTarget=null,this._scrollHeight=null},l.prototype._getConfig=function(n){if("string"!=typeof(n=t.extend({},h,n)).target){var i=t(n.target).attr("id");i||(i=r.getUID(e),t(n.target).attr("id",i)),n.target="#"+i}return r.typeCheckConfig(e,n,c),n},l.prototype._getScrollTop=function(){return this._scrollElement===window?this._scrollElement.pageYOffset:this._scrollElement.scrollTop},l.prototype._getScrollHeight=function(){return this._scrollElement.scrollHeight||Math.max(document.body.scrollHeight,document.documentElement.scrollHeight)},l.prototype._getOffsetHeight=function(){return this._scrollElement===window?window.innerHeight:this._scrollElement.offsetHeight},l.prototype._process=function(){var t=this._getScrollTop()+this._config.offset,e=this._getScrollHeight(),n=this._config.offset+e-this._getOffsetHeight();if(this._scrollHeight!==e&&this.refresh(),t>=n){var i=this._targets[this._targets.length-1];this._activeTarget!==i&&this._activate(i)}else{if(this._activeTarget&&t<this._offsets[0]&&this._offsets[0]>0)return this._activeTarget=null,void this._clear();for(var o=this._offsets.length;o--;)this._activeTarget!==this._targets[o]&&t>=this._offsets[o]&&(void 0===this._offsets[o+1]||t<this._offsets[o+1])&&this._activate(this._targets[o])}},l.prototype._activate=function(e){this._activeTarget=e,this._clear();var n=this._selector.split(",");n=n.map(function(t){return t+'[data-target="'+e+'"],'+t+'[href="'+e+'"]'});var i=t(n.join(","));i.hasClass(d.DROPDOWN_ITEM)?(i.closest(f.DROPDOWN).find(f.DROPDOWN_TOGGLE).addClass(d.ACTIVE),i.addClass(d.ACTIVE)):i.parents(f.LI).find("> "+f.NAV_LINKS).addClass(d.ACTIVE),t(this._scrollElement).trigger(u.ACTIVATE,{relatedTarget:e})},l.prototype._clear=function(){t(this._selector).filter(f.ACTIVE).removeClass(d.ACTIVE)},l._jQueryInterface=function(e){return this.each(function(){var n=t(this).data(s),o="object"===(void 0===e?"undefined":i(e))&&e;if(n||(n=new l(this,o),t(this).data(s,n)),"string"==typeof e){if(void 0===n[e])throw new Error('No method named "'+e+'"');n[e]()}})},o(l,null,[{key:"VERSION",get:function(){return"4.0.0-alpha.6"}},{key:"Default",get:function(){return h}}]),l}();t(window).on(u.LOAD_DATA_API,function(){for(var e=t.makeArray(t(f.DATA_SPY)),n=e.length;n--;){var i=t(e[n]);g._jQueryInterface.call(i,i.data())}}),t.fn[e]=g._jQueryInterface,t.fn[e].Constructor=g,t.fn[e].noConflict=function(){return t.fn[e]=l,g._jQueryInterface}}(jQuery),function(t){var e="tab",i="bs.tab",s="."+i,a=t.fn[e],l={HIDE:"hide"+s,HIDDEN:"hidden"+s,SHOW:"show"+s,SHOWN:"shown"+s,CLICK_DATA_API:"click"+s+".data-api"},h={DROPDOWN_MENU:"dropdown-menu",ACTIVE:"active",DISABLED:"disabled",FADE:"fade",SHOW:"show"},c={A:"a",LI:"li",DROPDOWN:".dropdown",LIST:"ul:not(.dropdown-menu), ol:not(.dropdown-menu), nav:not(.dropdown-menu)",FADE_CHILD:"> .nav-item .fade, > .fade",ACTIVE:".active",ACTIVE_CHILD:"> .nav-item > .active, > .active",DATA_TOGGLE:'[data-toggle="tab"], [data-toggle="pill"]',DROPDOWN_TOGGLE:".dropdown-toggle",DROPDOWN_ACTIVE_CHILD:"> .dropdown-menu .active"},u=function(){function e(t){n(this,e),this._element=t}return e.prototype.show=function(){var e=this;if(!(this._element.parentNode&&this._element.parentNode.nodeType===Node.ELEMENT_NODE&&t(this._element).hasClass(h.ACTIVE)||t(this._element).hasClass(h.DISABLED))){var n=void 0,i=void 0,o=t(this._element).closest(c.LIST)[0],s=r.getSelectorFromElement(this._element);o&&(i=t.makeArray(t(o).find(c.ACTIVE)),i=i[i.length-1]);var a=t.Event(l.HIDE,{relatedTarget:this._element}),u=t.Event(l.SHOW,{relatedTarget:i});if(i&&t(i).trigger(a),t(this._element).trigger(u),!u.isDefaultPrevented()&&!a.isDefaultPrevented()){s&&(n=t(s)[0]),this._activate(this._element,o);var d=function(){var n=t.Event(l.HIDDEN,{relatedTarget:e._element}),o=t.Event(l.SHOWN,{relatedTarget:i});t(i).trigger(n),t(e._element).trigger(o)};n?this._activate(n,n.parentNode,d):d()}}},e.prototype.dispose=function(){t.removeClass(this._element,i),this._element=null},e.prototype._activate=function(e,n,i){var o=this,s=t(n).find(c.ACTIVE_CHILD)[0],a=i&&r.supportsTransitionEnd()&&(s&&t(s).hasClass(h.FADE)||Boolean(t(n).find(c.FADE_CHILD)[0])),l=function(){return o._transitionComplete(e,s,a,i)};s&&a?t(s).one(r.TRANSITION_END,l).emulateTransitionEnd(150):l(),s&&t(s).removeClass(h.SHOW)},e.prototype._transitionComplete=function(e,n,i,o){if(n){t(n).removeClass(h.ACTIVE);var s=t(n.parentNode).find(c.DROPDOWN_ACTIVE_CHILD)[0];s&&t(s).removeClass(h.ACTIVE),n.setAttribute("aria-expanded",!1)}if(t(e).addClass(h.ACTIVE),e.setAttribute("aria-expanded",!0),i?(r.reflow(e),t(e).addClass(h.SHOW)):t(e).removeClass(h.FADE),e.parentNode&&t(e.parentNode).hasClass(h.DROPDOWN_MENU)){var a=t(e).closest(c.DROPDOWN)[0];a&&t(a).find(c.DROPDOWN_TOGGLE).addClass(h.ACTIVE),e.setAttribute("aria-expanded",!0)}o&&o()},e._jQueryInterface=function(n){return this.each(function(){var o=t(this),r=o.data(i);if(r||(r=new e(this),o.data(i,r)),"string"==typeof n){if(void 0===r[n])throw new Error('No method named "'+n+'"');r[n]()}})},o(e,null,[{key:"VERSION",get:function(){return"4.0.0-alpha.6"}}]),e}();t(document).on(l.CLICK_DATA_API,c.DATA_TOGGLE,function(e){e.preventDefault(),u._jQueryInterface.call(t(this),"show")}),t.fn[e]=u._jQueryInterface,t.fn[e].Constructor=u,t.fn[e].noConflict=function(){return t.fn[e]=a,u._jQueryInterface}}(jQuery),function(t){if("undefined"==typeof Tether)throw new Error("Bootstrap tooltips require Tether (http://tether.io/)");var e="tooltip",s="bs.tooltip",a="."+s,l=t.fn[e],h={animation:!0,template:'<div class="tooltip" role="tooltip"><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,selector:!1,placement:"top",offset:"0 0",constraints:[],container:!1},c={animation:"boolean",template:"string",title:"(string|element|function)",trigger:"string",delay:"(number|object)",html:"boolean",selector:"(string|boolean)",placement:"(string|function)",offset:"string",constraints:"array",container:"(string|element|boolean)"},u={TOP:"bottom center",RIGHT:"middle left",BOTTOM:"top center",LEFT:"middle right"},d={SHOW:"show",OUT:"out"},f={HIDE:"hide"+a,HIDDEN:"hidden"+a,SHOW:"show"+a,SHOWN:"shown"+a,INSERTED:"inserted"+a,CLICK:"click"+a,FOCUSIN:"focusin"+a,FOCUSOUT:"focusout"+a,MOUSEENTER:"mouseenter"+a,MOUSELEAVE:"mouseleave"+a},_={FADE:"fade",SHOW:"show"},g={TOOLTIP:".tooltip",TOOLTIP_INNER:".tooltip-inner"},p={element:!1,enabled:!1},m={HOVER:"hover",FOCUS:"focus",CLICK:"click",MANUAL:"manual"},E=function(){function l(t,e){n(this,l),this._isEnabled=!0,this._timeout=0,this._hoverState="",this._activeTrigger={},this._isTransitioning=!1,this._tether=null,this.element=t,this.config=this._getConfig(e),this.tip=null,this._setListeners()}return l.prototype.enable=function(){this._isEnabled=!0},l.prototype.disable=function(){this._isEnabled=!1},l.prototype.toggleEnabled=function(){this._isEnabled=!this._isEnabled},l.prototype.toggle=function(e){if(e){var n=this.constructor.DATA_KEY,i=t(e.currentTarget).data(n);i||(i=new this.constructor(e.currentTarget,this._getDelegateConfig()),t(e.currentTarget).data(n,i)),i._activeTrigger.click=!i._activeTrigger.click,i._isWithActiveTrigger()?i._enter(null,i):i._leave(null,i)}else{if(t(this.getTipElement()).hasClass(_.SHOW))return void this._leave(null,this);this._enter(null,this)}},l.prototype.dispose=function(){clearTimeout(this._timeout),this.cleanupTether(),t.removeData(this.element,this.constructor.DATA_KEY),t(this.element).off(this.constructor.EVENT_KEY),t(this.element).closest(".modal").off("hide.bs.modal"),this.tip&&t(this.tip).remove(),this._isEnabled=null,this._timeout=null,this._hoverState=null,this._activeTrigger=null,this._tether=null,this.element=null,this.config=null,this.tip=null},l.prototype.show=function(){var e=this;if("none"===t(this.element).css("display"))throw new Error("Please use show on visible elements");var n=t.Event(this.constructor.Event.SHOW);if(this.isWithContent()&&this._isEnabled){if(this._isTransitioning)throw new Error("Tooltip is transitioning");t(this.element).trigger(n);var i=t.contains(this.element.ownerDocument.documentElement,this.element);if(n.isDefaultPrevented()||!i)return;var o=this.getTipElement(),s=r.getUID(this.constructor.NAME);o.setAttribute("id",s),this.element.setAttribute("aria-describedby",s),this.setContent(),this.config.animation&&t(o).addClass(_.FADE);var a="function"==typeof this.config.placement?this.config.placement.call(this,o,this.element):this.config.placement,h=this._getAttachment(a),c=!1===this.config.container?document.body:t(this.config.container);t(o).data(this.constructor.DATA_KEY,this).appendTo(c),t(this.element).trigger(this.constructor.Event.INSERTED),this._tether=new Tether({attachment:h,element:o,target:this.element,classes:p,classPrefix:"bs-tether",offset:this.config.offset,constraints:this.config.constraints,addTargetClasses:!1}),r.reflow(o),this._tether.position(),t(o).addClass(_.SHOW);var u=function(){var n=e._hoverState;e._hoverState=null,e._isTransitioning=!1,t(e.element).trigger(e.constructor.Event.SHOWN),n===d.OUT&&e._leave(null,e)};if(r.supportsTransitionEnd()&&t(this.tip).hasClass(_.FADE))return this._isTransitioning=!0,void t(this.tip).one(r.TRANSITION_END,u).emulateTransitionEnd(l._TRANSITION_DURATION);u()}},l.prototype.hide=function(e){var n=this,i=this.getTipElement(),o=t.Event(this.constructor.Event.HIDE);if(this._isTransitioning)throw new Error("Tooltip is transitioning");var s=function(){n._hoverState!==d.SHOW&&i.parentNode&&i.parentNode.removeChild(i),n.element.removeAttribute("aria-describedby"),t(n.element).trigger(n.constructor.Event.HIDDEN),n._isTransitioning=!1,n.cleanupTether(),e&&e()};t(this.element).trigger(o),o.isDefaultPrevented()||(t(i).removeClass(_.SHOW),this._activeTrigger[m.CLICK]=!1,this._activeTrigger[m.FOCUS]=!1,this._activeTrigger[m.HOVER]=!1,r.supportsTransitionEnd()&&t(this.tip).hasClass(_.FADE)?(this._isTransitioning=!0,t(i).one(r.TRANSITION_END,s).emulateTransitionEnd(150)):s(),this._hoverState="")},l.prototype.isWithContent=function(){return Boolean(this.getTitle())},l.prototype.getTipElement=function(){return this.tip=this.tip||t(this.config.template)[0]},l.prototype.setContent=function(){var e=t(this.getTipElement());this.setElementContent(e.find(g.TOOLTIP_INNER),this.getTitle()),e.removeClass(_.FADE+" "+_.SHOW),this.cleanupTether()},l.prototype.setElementContent=function(e,n){var o=this.config.html;"object"===(void 0===n?"undefined":i(n))&&(n.nodeType||n.jquery)?o?t(n).parent().is(e)||e.empty().append(n):e.text(t(n).text()):e[o?"html":"text"](n)},l.prototype.getTitle=function(){var t=this.element.getAttribute("data-original-title");return t||(t="function"==typeof this.config.title?this.config.title.call(this.element):this.config.title),t},l.prototype.cleanupTether=function(){this._tether&&this._tether.destroy()},l.prototype._getAttachment=function(t){return u[t.toUpperCase()]},l.prototype._setListeners=function(){var e=this;this.config.trigger.split(" ").forEach(function(n){if("click"===n)t(e.element).on(e.constructor.Event.CLICK,e.config.selector,function(t){return e.toggle(t)});else if(n!==m.MANUAL){var i=n===m.HOVER?e.constructor.Event.MOUSEENTER:e.constructor.Event.FOCUSIN,o=n===m.HOVER?e.constructor.Event.MOUSELEAVE:e.constructor.Event.FOCUSOUT;t(e.element).on(i,e.config.selector,function(t){return e._enter(t)}).on(o,e.config.selector,function(t){return e._leave(t)})}t(e.element).closest(".modal").on("hide.bs.modal",function(){return e.hide()})}),this.config.selector?this.config=t.extend({},this.config,{trigger:"manual",selector:""}):this._fixTitle()},l.prototype._fixTitle=function(){var t=i(this.element.getAttribute("data-original-title"));(this.element.getAttribute("title")||"string"!==t)&&(this.element.setAttribute("data-original-title",this.element.getAttribute("title")||""),this.element.setAttribute("title",""))},l.prototype._enter=function(e,n){var i=this.constructor.DATA_KEY;return(n=n||t(e.currentTarget).data(i))||(n=new this.constructor(e.currentTarget,this._getDelegateConfig()),t(e.currentTarget).data(i,n)),e&&(n._activeTrigger["focusin"===e.type?m.FOCUS:m.HOVER]=!0),t(n.getTipElement()).hasClass(_.SHOW)||n._hoverState===d.SHOW?void(n._hoverState=d.SHOW):(clearTimeout(n._timeout),n._hoverState=d.SHOW,n.config.delay&&n.config.delay.show?void(n._timeout=setTimeout(function(){n._hoverState===d.SHOW&&n.show()},n.config.delay.show)):void n.show())},l.prototype._leave=function(e,n){var i=this.constructor.DATA_KEY;if((n=n||t(e.currentTarget).data(i))||(n=new this.constructor(e.currentTarget,this._getDelegateConfig()),t(e.currentTarget).data(i,n)),e&&(n._activeTrigger["focusout"===e.type?m.FOCUS:m.HOVER]=!1),!n._isWithActiveTrigger())return clearTimeout(n._timeout),n._hoverState=d.OUT,n.config.delay&&n.config.delay.hide?void(n._timeout=setTimeout(function(){n._hoverState===d.OUT&&n.hide()},n.config.delay.hide)):void n.hide()},l.prototype._isWithActiveTrigger=function(){for(var t in this._activeTrigger)if(this._activeTrigger[t])return!0;return!1},l.prototype._getConfig=function(n){return(n=t.extend({},this.constructor.Default,t(this.element).data(),n)).delay&&"number"==typeof n.delay&&(n.delay={show:n.delay,hide:n.delay}),r.typeCheckConfig(e,n,this.constructor.DefaultType),n},l.prototype._getDelegateConfig=function(){var t={};if(this.config)for(var e in this.config)this.constructor.Default[e]!==this.config[e]&&(t[e]=this.config[e]);return t},l._jQueryInterface=function(e){return this.each(function(){var n=t(this).data(s),o="object"===(void 0===e?"undefined":i(e))&&e;if((n||!/dispose|hide/.test(e))&&(n||(n=new l(this,o),t(this).data(s,n)),"string"==typeof e)){if(void 0===n[e])throw new Error('No method named "'+e+'"');n[e]()}})},o(l,null,[{key:"VERSION",get:function(){return"4.0.0-alpha.6"}},{key:"Default",get:function(){return h}},{key:"NAME",get:function(){return e}},{key:"DATA_KEY",get:function(){return s}},{key:"Event",get:function(){return f}},{key:"EVENT_KEY",get:function(){return a}},{key:"DefaultType",get:function(){return c}}]),l}();return t.fn[e]=E._jQueryInterface,t.fn[e].Constructor=E,t.fn[e].noConflict=function(){return t.fn[e]=l,E._jQueryInterface},E}(jQuery));!function(r){var a="popover",l="bs.popover",h="."+l,c=r.fn[a],u=r.extend({},s.Default,{placement:"right",trigger:"click",content:"",template:'<div class="popover" role="tooltip"><h3 class="popover-title"></h3><div class="popover-content"></div></div>'}),d=r.extend({},s.DefaultType,{content:"(string|element|function)"}),f={FADE:"fade",SHOW:"show"},_={TITLE:".popover-title",CONTENT:".popover-content"},g={HIDE:"hide"+h,HIDDEN:"hidden"+h,SHOW:"show"+h,SHOWN:"shown"+h,INSERTED:"inserted"+h,CLICK:"click"+h,FOCUSIN:"focusin"+h,FOCUSOUT:"focusout"+h,MOUSEENTER:"mouseenter"+h,MOUSELEAVE:"mouseleave"+h},p=function(s){function c(){return n(this,c),t(this,s.apply(this,arguments))}return e(c,s),c.prototype.isWithContent=function(){return this.getTitle()||this._getContent()},c.prototype.getTipElement=function(){return this.tip=this.tip||r(this.config.template)[0]},c.prototype.setContent=function(){var t=r(this.getTipElement());this.setElementContent(t.find(_.TITLE),this.getTitle()),this.setElementContent(t.find(_.CONTENT),this._getContent()),t.removeClass(f.FADE+" "+f.SHOW),this.cleanupTether()},c.prototype._getContent=function(){return this.element.getAttribute("data-content")||("function"==typeof this.config.content?this.config.content.call(this.element):this.config.content)},c._jQueryInterface=function(t){return this.each(function(){var e=r(this).data(l),n="object"===(void 0===t?"undefined":i(t))?t:null;if((e||!/destroy|hide/.test(t))&&(e||(e=new c(this,n),r(this).data(l,e)),"string"==typeof t)){if(void 0===e[t])throw new Error('No method named "'+t+'"');e[t]()}})},o(c,null,[{key:"VERSION",get:function(){return"4.0.0-alpha.6"}},{key:"Default",get:function(){return u}},{key:"NAME",get:function(){return a}},{key:"DATA_KEY",get:function(){return l}},{key:"Event",get:function(){return g}},{key:"EVENT_KEY",get:function(){return h}},{key:"DefaultType",get:function(){return d}}]),c}(s);r.fn[a]=p._jQueryInterface,r.fn[a].Constructor=p,r.fn[a].noConflict=function(){return r.fn[a]=c,p._jQueryInterface}}(jQuery)}();*/
