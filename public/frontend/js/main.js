!function (t) {
    "use strict"; function e(e) { t(e).length > 0 && t(e).each((function () { var e = t(this).find("a"); t(this).find(e).each((function () { t(this).on("click", (function () { var e = t(this.getAttribute("href")); e.length && (event.preventDefault(), t("html, body").stop().animate({ scrollTop: e.offset().top - 10 }, 1e3)) })) })) })) } if (window.addEventListener("load", (function () { t(".preloader").fadeOut(), new WOW({ boxClass: "wow", animateClass: "animated", offset: 0, mobile: !1, live: !0 }).init() })), t(document).on("click", ".preloaderCls", (function (e) { e.preventDefault(), t(".preloader").hide() })), t.fn.thmobilemenu = function (e) { var a = t.extend({ menuToggleBtn: ".th-menu-toggle", bodyToggleClass: "th-body-visible", subMenuClass: "th-submenu", subMenuParent: "menu-item-has-children", thSubMenuParent: "th-item-has-children", subMenuParentToggle: "th-active", meanExpandClass: "th-mean-expand", appendElement: '<span class="th-mean-expand"></span>', subMenuToggleClass: "th-open", toggleSpeed: 400 }, e); return this.each((function () { var e = t(this); function n() { e.toggleClass(a.bodyToggleClass); var n = "." + a.subMenuClass; t(n).each((function () { t(this).hasClass(a.subMenuToggleClass) && (t(this).removeClass(a.subMenuToggleClass), t(this).css("display", "none"), t(this).parent().removeClass(a.subMenuParentToggle)) })) } e.find("." + a.subMenuParent).each((function () { var e = t(this).find("ul"); e.addClass(a.subMenuClass), e.css("display", "none"), t(this).addClass(a.subMenuParent), t(this).addClass(a.thSubMenuParent), t(this).children("a").append(a.appendElement) })); var o = "." + a.thSubMenuParent + " > a"; t(o).each((function () { t(this).on("click", (function (e) { var n, o; e.preventDefault(), n = t(this).parent(), (o = n.children("ul")).length > 0 && (n.toggleClass(a.subMenuParentToggle), o.slideToggle(a.toggleSpeed), o.toggleClass(a.subMenuToggleClass)) })) })), t(a.menuToggleBtn).each((function () { t(this).on("click", (function () { n() })) })), e.on("click", (function (t) { t.stopPropagation(), n() })), e.find("div").on("click", (function (t) { t.stopPropagation() })) })) }, t(".th-menu-wrapper").thmobilemenu(), t(window).scroll((function () { t(this).scrollTop() > 100 ? (t(".sticky-wrapper").addClass("sticky"), t(".category-menu").addClass("close-category")) : (t(".sticky-wrapper").removeClass("sticky"), t(".category-menu").removeClass("close-category")) })), t(".menu-expand").each((function () { t(this).on("click", (function (e) { e.preventDefault(), t(".category-menu").toggleClass("open-category") })) })), e(".onepage-nav"), e(".scroll-down"), t(".scroll-top").length > 0) { var a = document.querySelector(".scroll-top"), n = document.querySelector(".scroll-top path"), o = n.getTotalLength(); n.style.transition = n.style.WebkitTransition = "none", n.style.strokeDasharray = o + " " + o, n.style.strokeDashoffset = o, n.getBoundingClientRect(), n.style.transition = n.style.WebkitTransition = "stroke-dashoffset 10ms linear"; var s = function () { var e = t(window).scrollTop(), a = t(document).height() - t(window).height(), s = o - e * o / a; n.style.strokeDashoffset = s }; s(), t(window).scroll(s); jQuery(window).on("scroll", (function () { jQuery(this).scrollTop() > 50 ? jQuery(a).addClass("show") : jQuery(a).removeClass("show") })), jQuery(a).on("click", (function (t) { return t.preventDefault(), jQuery("html, body").animate({ scrollTop: 0 }, 750), !1 })) } t("[data-bg-src]").length > 0 && t("[data-bg-src]").each((function () { var e = t(this).attr("data-bg-src"); t(this).css("background-image", "url(" + e + ")"), t(this).removeAttr("data-bg-src").addClass("background-image") })), t("[data-bg-color]").length > 0 && t("[data-bg-color]").each((function () { var e = t(this).attr("data-bg-color"); t(this).css("background-color", e), t(this).removeAttr("data-bg-color") })), t("[data-theme-color]").length > 0 && t("[data-theme-color]").each((function () { var e = t(this).attr("data-theme-color"); t(this).get(0).style.setProperty("--theme-color", e), t(this).removeAttr("data-theme-color") })), t("[data-border]").each((function () { var e = t(this).data("border"); t(this).css("--th-border-color", e) })), t("[data-mask-src]").length > 0 && t("[data-mask-src]").each((function () { var e = t(this).attr("data-mask-src"); t(this).css({ "mask-image": "url(" + e + ")", "-webkit-mask-image": "url(" + e + ")" }), t(this).addClass("bg-mask"), t(this).removeAttr("data-mask-src") })), t(".th-slider").each((function () { var e = t(this), a = t(this).data("slider-options") || {}, n = e.find(".slider-prev"), o = e.find(".slider-next"), s = e.find(".slider-pagination").get(0), i = e.find(".slider-pagination2"), r = e.find(".slider-pagination-progressbar2 .slider-progressbar-fill"), c = { slidesPerView: 1, spaceBetween: a.spaceBetween || 24, loop: !1 !== a.loop, speed: a.speed || 1e3, autoplay: a.autoplay || { delay: 6e3, disableOnInteraction: !1 }, navigation: { prevEl: n.get(0), nextEl: o.get(0) }, pagination: { el: s, type: a.paginationType || "bullets", clickable: !0, renderBullet: function (t, e) { var a = t + 1; return '<span class="' + e + '" aria-label="Go to Slide ' + (a < 10 ? "0" + a : a) + '"></span>' } }, on: { init: function () { d(this), u(this) }, slideChange: function () { d(this), u(this) } } }, l = t.extend({}, c, a); new Swiper(e.get(0), l); function d(t) { var e = t.realIndex + 1, a = t.slides.length; i.html('<span class="current-slide">' + (e < 10 ? "0" + e : e) + '</span> <span class="divider"></span> <span class="total-slides">' + (a < 10 ? "0" + a : a) + "</span>") } function u(t) { var e = (t.realIndex + 1) / t.slides.length * 100; r.css("height", e + "%") } t(".slider-area").length > 0 && t(".slider-area").closest(".container").parent().addClass("arrow-wrap") })), t("[data-ani]").each((function () { var e = t(this).data("ani"); t(this).addClass(e) })), t("[data-ani-delay]").each((function () { var e = t(this).data("ani-delay"); t(this).css("animation-delay", e) })), t("[data-slider-prev], [data-slider-next]").on("click", (function () { var e = t(this).data("slider-prev") || t(this).data("slider-next"), a = t(e); if (a.length) { var n = a[0].swiper; n && (t(this).data("slider-prev") ? n.slidePrev() : (navigator, n.slideNext())) } })), t(window).on("load", (function () { t(".hero-thumb-tab").length && t(".hero-slider4").length && function (e, a) { var n = t(e).find(".tab-btn"), o = t('<span class="indicator"></span>').appendTo(e), s = t(a).map((function () { return this.swiper })).get(); n.on("click", (function (a) { a.preventDefault(); var n = t(this), o = n.index(); n.addClass("active").siblings().removeClass("active"), c(n, t(e)), s.forEach((function (t) { t && t.slideToLoop(o) })) })), s.forEach((function (a) { a && a.on("slideChange", (function () { var o = a.realIndex, s = n.eq(o); s.addClass("active").siblings().removeClass("active"), c(s, t(e)) })) })); var i = s[0]?.realIndex || 0, r = n.eq(i); function c(t, e) { var a = t.position(), n = parseInt(t.css("margin-top"), 10) || 0, s = parseInt(t.css("margin-left"), 10) || 0; o.css("--height-set", t.outerHeight() + "px"), o.css("--width-set", t.outerWidth() + "px"), o.css("--pos-y", a.top + n + "px"), o.css("--pos-x", a.left + s + "px") } r.addClass("active").siblings().removeClass("active"), c(r, t(e)) }(".hero-thumb-tab", ".hero-slider4") })); var i, r, c, l = ".ajax-contact", d = "is-invalid", u = '[name="email"]', h = '[name="name"],[name="email"],[name="subject"],[name="number"],[name="message"]', p = t(".form-messages"); function g() { var e, a = t(l).serialize(); e = function () { var e, a = !0; function n(n) { n = n.split(","); for (var o = 0; o < n.length; o++)e = l + " " + n[o], t(e).val() ? (t(e).removeClass(d), a = !0) : (t(e).addClass(d), a = !1) } n(h), t(u).val() && t(u).val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/) ? (t(u).removeClass(d), a = !0) : (t(u).addClass(d), a = !1); return a }(), e && jQuery.ajax({ url: t(l).attr("action"), data: a, type: "POST" }).done((function (e) { p.removeClass("error"), p.addClass("success"), p.text(e), t(l + ' input:not([type="submit"]),' + l + " textarea").val("") })).fail((function (t) { p.removeClass("success"), p.addClass("error"), "" !== t.responseText ? p.html(t.responseText) : p.html("Oops! An error occured and your message could not be sent.") })) } function f(e, a, n, o) { t(a).on("click", (function (a) { a.preventDefault(), t(e).addClass(o) })), t(e).on("click", (function (a) { a.stopPropagation(), t(e).removeClass(o) })), t(e + " > div").on("click", (function (a) { a.stopPropagation(), t(e).addClass(o) })), t(n).on("click", (function (a) { a.preventDefault(), a.stopPropagation(), t(e).removeClass(o) })) } function m(t) { return parseInt(t, 10) } t(l).on("submit", (function (t) { t.preventDefault(), g() })), i = ".popup-search-box", r = ".searchClose", c = "show", t(".searchBoxToggler").on("click", (function (e) { e.preventDefault(), t(i).addClass(c) })), t(i).on("click", (function (e) { e.stopPropagation(), t(i).removeClass(c) })), t(i).find("form").on("click", (function (e) { e.stopPropagation(), t(i).addClass(c) })), t(r).on("click", (function (e) { e.preventDefault(), e.stopPropagation(), t(i).removeClass(c) })), f(".sidemenu-cart", ".sideMenuToggler", ".sideMenuCls", "show"), f(".sidemenu-info", ".sideMenuInfo", ".sideMenuCls", "show"), t(".popup-image").magnificPopup({ type: "image", mainClass: "mfp-zoom-in", removalDelay: 260, gallery: { enabled: !0 } }), t(".popup-video").magnificPopup({ type: "iframe", mainClass: "mfp-zoom-in" }), t(".popup-content").magnificPopup({ type: "inline", midClick: !0 }), t.fn.sectionPosition = function (e, a) { t(this).each((function () { var n, o, s, i, r, c = t(this); n = Math.floor(c.height() / 2), o = c.attr(e), s = c.attr(a), i = m(t(s).css("padding-top")), r = m(t(s).css("padding-bottom")), "top-half" === o ? (t(s).css("padding-bottom", r + n + "px"), c.css("margin-top", "-" + n + "px")) : "bottom-half" === o && (t(s).css("padding-top", i + n + "px"), c.css("margin-bottom", "-" + n + "px")) })) }; var v = "[data-sec-pos]"; t(v).length && t(v).imagesLoaded((function () { t(v).sectionPosition("data-sec-pos", "data-pos-for") })), t(".filter-active").imagesLoaded((function () { var e = ".filter-active", a = ".filter-menu-active"; if (t(e).length > 0) { var n = t(e).isotope({ itemSelector: ".filter-item", filter: "*", masonry: { columnWidth: 1 } }); t(a).on("click", "button", (function () { var e = t(this).attr("data-filter"); n.isotope({ filter: e }) })), t(a).on("click", "button", (function (e) { e.preventDefault(), t(this).addClass("active"), t(this).siblings(".active").removeClass("active") })) } })), t(".masonary-active, .woocommerce-Reviews .comment-list").imagesLoaded((function () { var e = ".masonary-active, .woocommerce-Reviews .comment-list"; t(e).length > 0 && t(e).isotope({ itemSelector: ".filter-item, .woocommerce-Reviews .comment-list li", filter: "*", masonry: { columnWidth: 1 } }), t('[data-bs-toggle="tab"]').on("shown.bs.tab", (function (a) { t(e).isotope({ filter: "*" }) })) })), t(".counter-number").counterUp({ delay: 10, time: 1e3 }), t.fn.shapeMockup = function () { t(this).each((function () { var e = t(this), a = e.data("top"), n = e.data("right"), o = e.data("bottom"), s = e.data("left"); e.css({ top: a, right: n, bottom: o, left: s }).removeAttr("data-top").removeAttr("data-right").removeAttr("data-bottom").removeAttr("data-left").parent().addClass("shape-mockup-wrap") })) }, t(".shape-mockup") && t(".shape-mockup").shapeMockup(), t(".progress-bar").waypoint((function () { t(".progress-bar").css({ animation: "animate-positive 1.8s", opacity: "1" }) }), { offset: "100%" }), t.fn.countdown = function () { t(this).each((function () { var e = t(this), a = new Date(e.data("offer-date")).getTime(); function n(t) { return e.find(t) } var o = setInterval((function () { var t = (new Date).getTime(), s = a - t, i = Math.floor(s / 864e5), r = Math.floor(s % 864e5 / 36e5), c = Math.floor(s % 36e5 / 6e4), l = Math.floor(s % 6e4 / 1e3); i < 10 && (i = "0" + i), r < 10 && (r = "0" + r), c < 10 && (c = "0" + c), l < 10 && (l = "0" + l), s < 0 ? (clearInterval(o), e.addClass("expired"), e.find(".message").css("display", "block")) : (n(".day").html(i), n(".hour").html(r), n(".minute").html(c), n(".seconds").html(l)) }), 1e3) })) }, t(".counter-list").length && t(".counter-list").countdown(); const y = {}; function b() { const e = t(this), a = e.attr("src"); if (!y[a]) { const e = t.Deferred(); t.get(a, (a => { e.resolve(t(a).find("svg")) })), y[a] = e.promise() } y[a].then((a => { const n = t(a).clone(); e.attr("id") && n.attr("id", e.attr("id")), e.attr("class") && n.attr("class", e.attr("class")), e.attr("style") && n.attr("style", e.attr("style")), e.attr("width") && (n.attr("width", e.attr("width")), e.attr("height") || n.removeAttr("height")), e.attr("height") && (n.attr("height", e.attr("height")), e.attr("width") || n.removeAttr("width")), n.insertAfter(e), e.trigger("svgInlined", n[0]), e.remove() })) } function C(e, a, n, o) { var s = e.text().split(a), i = ""; s.length && (t(s).each((function (t, e) { i += '<span class="' + n + (t + 1) + '">' + e + "</span>" + o })), e.empty().append(i)) } t.fn.inlineSvg = function () { return this.each(b), this }, t(".svg-img").inlineSvg(), document.addEventListener("DOMContentLoaded", (function () { document.querySelectorAll(".circular-progress").forEach((t => { const e = t.querySelector(".circle"), a = t.querySelector(".percentage"), n = parseInt(t.getAttribute("data-target"), 10) || 0; let o = 0; const s = () => { if (o <= n) { const t = 100 - o / 100 * 100; e.style.strokeDashoffset = t, a.textContent = o + "%", o++, requestAnimationFrame(s) } }; s() })) })), t("#ship-to-different-address-checkbox").on("change", (function () { t(this).is(":checked") ? t("#ship-to-different-address").next(".shipping_address").slideDown() : t("#ship-to-different-address").next(".shipping_address").slideUp() })), t(".woocommerce-form-login-toggle a").on("click", (function (e) { e.preventDefault(), t(".woocommerce-form-login").slideToggle() })), t(".woocommerce-form-coupon-toggle a").on("click", (function (e) { e.preventDefault(), t(".woocommerce-form-coupon").slideToggle() })), t(".shipping-calculator-button").on("click", (function (e) { e.preventDefault(), t(this).next(".shipping-calculator-form").slideToggle() })), t('.wc_payment_methods input[type="radio"]:checked').siblings(".payment_box").show(), t('.wc_payment_methods input[type="radio"]').each((function () { t(this).on("change", (function () { t(".payment_box").slideUp(), t(this).siblings(".payment_box").slideDown() })) })), t(".rating-select .stars a").each((function () { t(this).on("click", (function (e) { e.preventDefault(), t(this).siblings().removeClass("active"), t(this).parent().parent().addClass("selected"), t(this).addClass("active") })) })), t(".quantity-plus").each((function () { t(this).on("click", (function (e) { e.preventDefault(); var a = t(this).siblings(".qty-input"), n = parseInt(a.val(), 10); isNaN(n) || a.val(n + 1) })) })), t(".quantity-minus").each((function () { t(this).on("click", (function (e) { e.preventDefault(); var a = t(this).siblings(".qty-input"), n = parseInt(a.val(), 10); !isNaN(n) && n > 1 && a.val(n - 1) })) })), t(".color-switch-btns button").each((function () { const e = t(this), a = e.data("color"); e.css("--theme-color", a), e.on("click", (function () { const e = t(this).data("color"); t("body").css("--theme-color", e) })) })), t(document).on("click", ".switchIcon", (function () { t(".color-scheme-wrap").toggleClass("active") })), t(".secondary-color-switch-btns button").each((function () { const e = t(this), a = e.data("secondary-color"); e.css("--theme-color2", a), e.on("click", (function () { const e = t(this).data("secondary-color"); t(":root").css("--theme-color2", e) })) })); var w = { init: function () { return this.each((function () { C(t(this), "", "char", "") })) }, words: function () { return this.each((function () { C(t(this), " ", "word", " ") })) }, lines: function () { return this.each((function () { var e = "eefec303079ad17405c889e092e105b0"; C(t(this).children("br").replaceWith(e).end(), e, "line", "") })) } }; if (t.fn.lettering = function (e) { return e && w[e] ? w[e].apply(this, [].slice.call(arguments, 1)) : "letters" !== e && e ? (t.error("Method " + e + " does not exist on jQuery.lettering"), this) : w.init.apply(this, [].slice.call(arguments, 0)) }, t(".circle-title-anime").lettering(), t(document).on("mouseover", ".hover-item", (function () { t(this).addClass("item-active").siblings(".hover-item").removeClass("item-active") })), gsap.registerPlugin(ScrollTrigger, ScrollSmoother, ScrollToPlugin), t("#smooth-wrapper").length && t("#smooth-content").length && ScrollSmoother.create({ smooth: .9, effects: !0, smoothTouch: .1, ignoreMobileResize: !1 }), t(".th_fade_anim").length > 0 && gsap.utils.toArray(".th_fade_anim").forEach((t => { let e = t.getAttribute("data-fade-offset") || 40, a = t.getAttribute("data-duration") || .75, n = t.getAttribute("data-fade-from") || "bottom", o = t.getAttribute("data-on-scroll") || 1, s = t.getAttribute("data-delay") || .15, i = { opacity: 0, ease: t.getAttribute("data-ease") || "power2.out", duration: a, delay: s, x: "left" == n ? -e : "right" == n ? e : 0, y: "top" == n ? -e : "bottom" == n ? e : 0 }; 1 == o && (i.scrollTrigger = { trigger: t, start: "top 85%" }), gsap.from(t, i) })), t(".th--hover-item").length) { let e = function (t, e) { let a = new hoverEffect({ parent: t.get(0), intensity: t.data("intensity") || void 0, speedIn: t.data("speedin") || void 0, speedOut: t.data("speedout") || void 0, easing: t.data("easing") || void 0, hover: t.data("hover") || void 0, image1: e.eq(0).attr("src"), image2: e.eq(0).attr("src"), displacementImage: t.data("displacement"), imagesRatio: e[0].height / e[0].width, hover: !1 }); t.closest(".th--hover-item").on("mouseenter", (function () { a.next() })).on("mouseleave", (function () { a.previous() })) }; (function () { t(".th--hover-img").each((function () { let a = t(this), n = a.find("img"), o = n.eq(0); o[0].complete ? e(a, n) : o.on("load", (function () { e(a, n) })) })) })() } gsap.utils.toArray(".th-text-perspective").forEach((t => { const e = parseFloat(t.getAttribute("data-delay") || .5), a = gsap.timeline({ scrollTrigger: { trigger: t, start: "top 85%", duration: 1.5, scrub: !1, markers: !1, toggleActions: "play none none none" } }), n = new SplitText(t, { type: "lines" }); gsap.set(t, { perspective: 400 }), n.split({ type: "lines" }), a.from(n.lines, { duration: 1, delay: e, opacity: 0, rotationX: -80, force3D: !0, transformOrigin: "top center -50", stagger: .1 }) })), gsap.utils.toArray(".th-anim-trigger").forEach((t => { let e = t.querySelector(".th-anim-lr"); e && gsap.to(e, { x: 300, scrollTrigger: { trigger: t, start: "top center", end: "+=2500", scrub: !0 } }) })), gsap.utils.toArray(".th-anim-trigger").forEach((t => { let e = t.querySelector(".th-anim-spin"); e && gsap.to(e, { rotate: 360, ease: "none", scrollTrigger: { trigger: t, start: "top center", end: "+=2000", scrub: !0 } }) })), gsap.utils.toArray(".scroll-to-zoom").forEach((t => { gsap.to(t, { duration: 2, scale: 1, ease: "linear", scrollTrigger: { trigger: t, markers: !1, start: "top bottom", end: "top", scrub: 1 } }) })), t(document).ready((function () { t(".work-process-list li").on("mouseenter", (function () { var e = t(this).index(); t(".work-process-list li").each((function (a) { a <= e && t(this).addClass("dot-active") })) })), t(".work-process-list li").on("mouseleave", (function () { t(".work-process-list li").removeClass("dot-active") })) }))/* 
// Disable Right-Click Inspect & DevTools Shortcuts (Commented out for development - uncomment when ready for production):
,window.addEventListener("contextmenu",(function(t){t.preventDefault()}),!1),document.onkeydown=function(t){return 123!=event.keyCode&&((!t.ctrlKey||!t.shiftKey||t.keyCode!="I".charCodeAt(0))&&((!t.ctrlKey||!t.shiftKey||t.keyCode!="C".charCodeAt(0))&&((!t.ctrlKey||!t.shiftKey||t.keyCode!="J".charCodeAt(0))&&((!t.ctrlKey||t.keyCode!="U".charCodeAt(0))&&void 0))))}
*/
}(jQuery);

/* ==========================================================================
   DoctorsInn Custom Modules (Merged into main.js)
   ========================================================================== */

/* --- Module: home.js --- */
/**
 * Home Page - Course Category Tabs & Sliders
 */
document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.course-category-tabs .tab-btn');
    const tabPanes = document.querySelectorAll('.course-tab-pane');

    function activateCourseCategoryTab(cat) {
        tabButtons.forEach(function (btn) {
            if (btn.getAttribute('data-category') === cat) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        tabPanes.forEach(function (pane) {
            if (pane.id === 'tab-pane-' + cat) {
                pane.classList.add('active');

                setTimeout(function () {
                    const swiperEl = pane.querySelector('.swiper');
                    if (swiperEl && swiperEl.swiper) {
                        swiperEl.swiper.update();
                        swiperEl.swiper.slideTo(0, 0);
                    }
                    window.dispatchEvent(new Event('resize'));
                }, 50);
            } else {
                pane.classList.remove('active');
            }
        });
    }

    tabButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const cat = this.getAttribute('data-category');
            if (cat) {
                activateCourseCategoryTab(cat);
            }
        });
    });

    // Expose globally if needed by any other components
    window.activateCourseCategoryTab = activateCourseCategoryTab;
});

/* --- Module: course-details.js --- */
/**
 * Course Details - WhatsApp Proof Gallery Modal
 */
document.addEventListener('DOMContentLoaded', function () {
    const dataEl = document.getElementById('wa-proofs-data');
    let waProofs = [];
    if (dataEl) {
        try {
            waProofs = JSON.parse(dataEl.textContent);
        } catch (e) {
            waProofs = [];
        }
    }

    let currentWaIndex = 0;
    const modal = document.getElementById('waProofModal');

    function ensureModalInBody() {
        if (modal && modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }
        return modal;
    }

    ensureModalInBody();

    function renderWhatsAppModal() {
        if (!waProofs || waProofs.length === 0) return;
        const data = waProofs[currentWaIndex];
        if (!data) return;

        const nameEl = document.getElementById('waModalStudentName');
        if (nameEl) nameEl.textContent = data.name + ' (' + data.college + ')';

        const selEl = document.getElementById('waModalSelection');
        if (selEl) selEl.textContent = data.selection;

        const scoreEl = document.getElementById('waModalScore');
        if (scoreEl) scoreEl.textContent = data.score;

        const imgEl = document.getElementById('waModalProofImg');
        if (imgEl) {
            imgEl.src = data.img;
            imgEl.alt = data.name + ' WhatsApp Result Proof';
        }

        const linkEl = document.getElementById('waModalFullLink');
        if (linkEl) linkEl.href = data.img;

        const counterEl = document.getElementById('waModalCounter');
        if (counterEl) counterEl.textContent = (currentWaIndex + 1) + ' / ' + waProofs.length;
    }

    function openWhatsAppProofModalByIndex(index) {
        if (waProofs && waProofs.length > 0) {
            if (index >= 0 && index < waProofs.length) {
                currentWaIndex = index;
            }
            renderWhatsAppModal();
        }
        ensureModalInBody();
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeWhatsAppProofModal() {
        if (modal) {
            modal.classList.remove('show');
        }
        document.body.style.overflow = '';
    }

    function navWhatsAppProof(direction) {
        if (!waProofs || waProofs.length === 0) return;
        currentWaIndex = (currentWaIndex + direction + waProofs.length) % waProofs.length;
        renderWhatsAppModal();
    }

    // Bind triggers on proof buttons
    document.querySelectorAll('.whatsapp-proof-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const idx = parseInt(this.getAttribute('data-proof-index') || '0', 10);
            openWhatsAppProofModalByIndex(idx);
        });
    });

    // Close buttons & modal overlay click
    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeWhatsAppProofModal();
            }
        });

        const closeBtns = modal.querySelectorAll('.wa-proof-modal-close, #waProofCloseFooterBtn');
        closeBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                closeWhatsAppProofModal();
            });
        });

        const prevBtn = document.getElementById('waProofNavPrev');
        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                navWhatsAppProof(-1);
            });
        }

        const nextBtn = document.getElementById('waProofNavNext');
        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                navWhatsAppProof(1);
            });
        }
    }

    // Keyboard navigation
    document.addEventListener('keydown', function (e) {
        if (modal && modal.classList.contains('show')) {
            if (e.key === 'Escape') {
                closeWhatsAppProofModal();
            } else if (e.key === 'ArrowLeft') {
                navWhatsAppProof(-1);
            } else if (e.key === 'ArrowRight') {
                navWhatsAppProof(1);
            }
        }
    });

    // Global handles if needed
    window.openWhatsAppProofModalByIndex = openWhatsAppProofModalByIndex;
    window.closeWhatsAppProofModal = closeWhatsAppProofModal;
    window.navWhatsAppProof = navWhatsAppProof;
});

/* --- Module: course-filter.js --- */
/**
 * Course List - Filter by Category
 */
document.addEventListener('DOMContentLoaded', function () {
    const filterBtns = document.querySelectorAll('.course-filter-btn');
    const items = document.querySelectorAll('.course-filter-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');
            items.forEach(item => {
                const itemCat = item.getAttribute('data-category');
                if (filter === 'all' || itemCat === filter) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});

/* --- Module: elibrary.js --- */
/**
 * E-Library - Search, Category Filter & Reset
 */
document.addEventListener('DOMContentLoaded', function () {
    const filterBtns = document.querySelectorAll('.elib-filter-btn');
    const items = document.querySelectorAll('.elib-resource-item');
    const searchInput = document.getElementById('elibSearchInput');
    const searchClear = document.getElementById('elibSearchClear');
    const noResults = document.getElementById('elibNoResults');
    const resetBtn = document.getElementById('elibResetFilterBtn');

    let currentFilter = 'all';

    function applyFilters() {
        const query = (searchInput ? searchInput.value || '' : '').trim().toLowerCase();
        let visibleCount = 0;

        items.forEach(item => {
            const itemCat = (item.getAttribute('data-category') || '').toLowerCase().trim();
            const itemExam = (item.getAttribute('data-exam') || '').toLowerCase().trim();
            const itemTitle = (item.getAttribute('data-title') || '').toLowerCase().trim();
            const itemSubject = (item.getAttribute('data-subject') || '').toLowerCase().trim();

            const filter = currentFilter.toLowerCase().trim();
            const matchesCategory = (filter === 'all') || 
                                    (itemCat === filter) || 
                                    (itemExam === filter);

            const matchesQuery = !query || 
                                 itemTitle.includes(query) || 
                                 itemSubject.includes(query) ||
                                 itemCat.includes(query) ||
                                 itemExam.includes(query);

            if (matchesCategory && matchesQuery) {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        if (noResults) {
            if (visibleCount === 0) {
                noResults.classList.remove('d-none');
            } else {
                noResults.classList.add('d-none');
            }
        }

        if (searchClear) {
            if (query.length > 0) {
                searchClear.classList.remove('d-none');
            } else {
                searchClear.classList.add('d-none');
            }
        }
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter') || 'all';
            applyFilters();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    if (searchClear) {
        searchClear.addEventListener('click', function () {
            searchInput.value = '';
            applyFilters();
            searchInput.focus();
        });
    }

    function resetElibFilters() {
        if (searchInput) searchInput.value = '';
        currentFilter = 'all';
        filterBtns.forEach(b => {
            if (b.getAttribute('data-filter') === 'all') {
                b.classList.add('active');
            } else {
                b.classList.remove('active');
            }
        });
        applyFilters();
    }

    document.querySelectorAll('#elibResetFilterBtn, .elib-reset-all-btn').forEach(btn => {
        btn.addEventListener('click', resetElibFilters);
    });

    window.resetElibFilters = resetElibFilters;
});

/* --- Module: tests-index.js --- */
/**
 * Tests Index - Filter Tests by Category
 */
document.addEventListener('DOMContentLoaded', function () {
    const filterBtns = document.querySelectorAll('.test-filter-btn');
    const items = document.querySelectorAll('.test-filter-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = (this.getAttribute('data-filter') || 'all').toLowerCase().trim();

            items.forEach(item => {
                const itemCat = (item.getAttribute('data-category') || '').toLowerCase().trim();
                if (filter === 'all' || itemCat === filter) {
                    item.classList.remove('d-none');
                } else {
                    item.classList.add('d-none');
                }
            });
        });
    });
});

/* --- Module: take-test.js --- */
/**
 * Take Test - Timer, Question Navigation, Answer Tracking & Submission Modal
 */
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('mcqExamForm');
    if (!form) return;

    const totalQuestions = parseInt(form.getAttribute('data-total-questions') || '0', 10);
    const durationMinutes = parseInt(form.getAttribute('data-duration-minutes') || '15', 10);
    let remainingSeconds = durationMinutes * 60;
    let elapsedSeconds = 0;

    let currentQuestion = 1;
    const timerDisplay = document.getElementById('timerDisplay');
    const timeSpentInput = document.getElementById('timeSpentSeconds');
    const answeredCounter = document.getElementById('answeredCount');
    const currentQText = document.getElementById('currentQText');
    const progressBar = document.getElementById('examProgressBar');

    // Initialize progress bar
    if (progressBar && totalQuestions > 0) {
        progressBar.style.width = Math.round(100 / totalQuestions) + '%';
    }

    // Exit test confirm
    document.querySelectorAll('.btn-back-test, .btn-exit-test, #btnExitTest').forEach(btn => {
        btn.addEventListener('click', function (e) {
            if (!confirm('Leaving now will forfeit your unsaved progress. Are you sure you want to exit the test?')) {
                e.preventDefault();
            }
        });
    });

    // Timer Interval
    const timerInterval = setInterval(function () {
        if (remainingSeconds <= 0) {
            clearInterval(timerInterval);
            if (timerDisplay) timerDisplay.textContent = '00:00';
            alert('Time has expired! Your test is being automatically submitted.');
            submitExam();
            return;
        }

        remainingSeconds--;
        elapsedSeconds++;
        if (timeSpentInput) timeSpentInput.value = elapsedSeconds;

        const mins = Math.floor(remainingSeconds / 60);
        const secs = remainingSeconds % 60;
        if (timerDisplay) {
            timerDisplay.textContent = 
                (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;
        }

        if (remainingSeconds <= 120) {
            const timerBox = document.getElementById('timerBox');
            if (timerBox) timerBox.classList.add('timer-warning');
        }
    }, 1000);

    // Switch active question
    function goToQuestion(targetIndex) {
        if (targetIndex < 1 || targetIndex > totalQuestions) return;

        // Hide previous question
        const currentCard = document.querySelector(`.q-card-item[data-qindex="${currentQuestion}"]`);
        if (currentCard) {
            currentCard.classList.remove('active');
            currentCard.classList.add('d-none');
        }

        // Show target question
        const targetCard = document.querySelector(`.q-card-item[data-qindex="${targetIndex}"]`);
        if (targetCard) {
            targetCard.classList.remove('d-none');
            targetCard.classList.add('active');
        }

        currentQuestion = targetIndex;

        // Update header & progress bar
        if (currentQText) currentQText.textContent = currentQuestion;
        if (progressBar && totalQuestions > 0) {
            const progress = (currentQuestion / totalQuestions) * 100;
            progressBar.style.width = progress + '%';
        }

        // Update palette active states
        document.querySelectorAll('.palette-bubble').forEach(b => {
            const bIdx = parseInt(b.getAttribute('data-qindex'), 10);
            if (bIdx === currentQuestion) {
                b.classList.add('current');
            } else {
                b.classList.remove('current');
            }
        });

        // Smooth scroll to top of questions area on mobile
        const questionArea = document.querySelector('.exam-question-area');
        if (questionArea && window.innerWidth < 992) {
            questionArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Palette Click Navigation
    document.querySelectorAll('.palette-bubble').forEach(b => {
        b.addEventListener('click', function () {
            const targetIdx = parseInt(this.getAttribute('data-qindex'), 10);
            goToQuestion(targetIdx);
        });
    });

    // Next / Prev Buttons
    document.querySelectorAll('.btn-next-q').forEach(btn => {
        btn.addEventListener('click', function () {
            goToQuestion(currentQuestion + 1);
        });
    });

    document.querySelectorAll('.btn-prev-q').forEach(btn => {
        btn.addEventListener('click', function () {
            goToQuestion(currentQuestion - 1);
        });
    });

    // Answer Tracking
    function updateAnsweredCount() {
        const checkedRadios = document.querySelectorAll('.mcq-radio-input:checked');
        const answeredQIds = new Set();

        // Reset all bubbles answered class
        document.querySelectorAll('.palette-bubble').forEach(b => b.classList.remove('answered'));

        checkedRadios.forEach(radio => {
            const qId = radio.getAttribute('name').replace('answers[', '').replace(']', '');
            const qIndex = radio.getAttribute('data-qindex');
            answeredQIds.add(qId);

            const bubble = document.querySelector(`.palette-bubble[data-qindex="${qIndex}"]`);
            if (bubble) bubble.classList.add('answered');
        });

        if (answeredCounter) answeredCounter.textContent = answeredQIds.size;

        const isAllAnswered = answeredQIds.size === totalQuestions;
        const submitTriggers = [
            document.getElementById('btnSubmitExamTrigger'),
            document.getElementById('btnFinishSidebarTrigger')
        ];

        submitTriggers.forEach(btn => {
            if (!btn) return;
            if (isAllAnswered) {
                btn.classList.remove('disabled');
                btn.removeAttribute('disabled');
                btn.removeAttribute('title');
            } else {
                btn.classList.add('disabled');
                btn.setAttribute('disabled', 'disabled');
                const remaining = totalQuestions - answeredQIds.size;
                btn.setAttribute('title', `Answer all questions to finish (${remaining} remaining)`);
            }
        });

        return answeredQIds.size;
    }

    document.querySelectorAll('.mcq-radio-input').forEach(radio => {
        radio.addEventListener('change', function () {
            updateAnsweredCount();
        });
    });

    // Clear Selection
    document.querySelectorAll('.btn-clear-q').forEach(btn => {
        btn.addEventListener('click', function () {
            const qId = this.getAttribute('data-qid');
            document.querySelectorAll(`input[name="answers[${qId}]"]`).forEach(radio => {
                radio.checked = false;
            });
            updateAnsweredCount();
        });
    });

    // Submission Logic & Modal Controls
    function submitExam() {
        clearInterval(timerInterval);
        form.submit();
    }

    const modalEl = document.getElementById('submitConfirmModal');

    // Move modal directly to body so no parent container clips or restricts its backdrop
    if (modalEl && modalEl.parentNode !== document.body) {
        document.body.appendChild(modalEl);
    }

    function openConfirmModal(e) {
        if (e && e.preventDefault) e.preventDefault();

        const answered = updateAnsweredCount();
        const unanswered = Math.max(0, totalQuestions - answered);

        if (unanswered > 0) {
            // Find first unanswered question and jump to it
            for (let i = 1; i <= totalQuestions; i++) {
                const hasAns = document.querySelector(`.mcq-radio-input[data-qindex="${i}"]:checked`);
                if (!hasAns) {
                    goToQuestion(i);
                    alert(`Please answer all questions before submitting. You have ${unanswered} unanswered question(s). Question ${i} has not been answered yet.`);
                    return;
                }
            }
            return;
        }
        
        const answeredEl = document.getElementById('modalStatAnswered');
        if (answeredEl) answeredEl.textContent = answered;

        const unansweredEl = document.getElementById('modalStatUnanswered');
        if (unansweredEl) unansweredEl.textContent = unanswered;

        const timeSpentEl = document.getElementById('modalStatTimeSpent');
        if (timeSpentEl) {
            const mins = Math.floor(elapsedSeconds / 60);
            const secs = elapsedSeconds % 60;
            timeSpentEl.textContent = (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;
        }

        if (modalEl) {
            modalEl.classList.add('show');
            modalEl.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeConfirmModal() {
        if (modalEl) {
            modalEl.classList.remove('show');
            modalEl.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    window.triggerSubmitConfirmation = openConfirmModal;

    const triggerBtn = document.getElementById('btnSubmitExamTrigger');
    if (triggerBtn) {
        triggerBtn.addEventListener('click', openConfirmModal);
    }

    const sidebarTriggerBtn = document.getElementById('btnFinishSidebarTrigger');
    if (sidebarTriggerBtn) {
        sidebarTriggerBtn.addEventListener('click', openConfirmModal);
    }

    const cancelModalBtn = document.getElementById('cancelModalBtn');
    if (cancelModalBtn) {
        cancelModalBtn.addEventListener('click', closeConfirmModal);
    }

    const closeXBtn = document.getElementById('closeModalXBtn');
    if (closeXBtn) {
        closeXBtn.addEventListener('click', closeConfirmModal);
    }

    // Close on clicking backdrop
    if (modalEl) {
        modalEl.addEventListener('click', function (e) {
            if (e.target === modalEl) {
                closeConfirmModal();
            }
        });
    }

    const confirmBtn = document.getElementById('confirmFinalSubmitBtn');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function () {
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
            submitExam();
        });
    }

    // Initialize state on page load
    updateAnsweredCount();
});

/* --- Module: blog-details.js --- */
/**
 * Blog Details - Comment Form Handler
 */
document.addEventListener('DOMContentLoaded', function () {
    const commentForm = document.getElementById('blogCommentForm') || document.querySelector('.blog-comment-form form');
    if (commentForm) {
        commentForm.addEventListener('submit', function (e) {
            e.preventDefault();
            alert('Thank you for your comment! It has been submitted for moderation.');
            this.reset();
        });
    }
});

