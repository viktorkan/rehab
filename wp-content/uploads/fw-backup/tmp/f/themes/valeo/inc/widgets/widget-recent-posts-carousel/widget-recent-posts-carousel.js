// owl carousel - valeo recent post carousel

if (jQuery().owlCarousel) {
    jQuery('.owl-carousel').each(function () {

        var $carousel = jQuery(this);
        var show_description = $carousel.data('show_description') ? $carousel.data('show_description') : false;
        var show_navigation = $carousel.data('show_navigation') ? $carousel.data('show_navigation') : false;
        var autoplay = $carousel.data('autoplay') ? $carousel.data('autoplay') : false;
        var unique_id = $carousel.data('unique_id') ? $carousel.data('unique_id') : '';
        var slider_class = '.owl-recent-post-carousel',
            unique_slider_class = slider_class + unique_id;

        if (!unique_id.length) {
            unique_id = '';
        }

        var loop = true;
        if (jQuery(unique_slider_class).children().length == 1) {
            loop = false;
            autoplay = false;
        }

        var rtl = false;
        if (jQuery('body').hasClass('rtl')) {
            rtl = true;
        }

        // with short description
        if (show_description) {
            jQuery(unique_slider_class).owlCarousel({
                rtl: rtl,
                mouseDrag: false,
                dots: false,
                loop: loop,
                margin: 30,
                autoplay: autoplay,
                nav: show_navigation,
                navText: [
                    "<span class='rp__icon fa fa-caret-left'></span>",
                    "<span class='rp__icon fa fa-caret-right'></span>"
                ],
                responsiveClass: true,
                responsiveBaseElement: unique_slider_class,
                responsive: {
                    0: {
                        items: 1
                    },
                    630: {
                        items: 1
                    },
                    740: {
                        items: 2
                    },
                    970: {
                        items: 3
                    },
                    1170: {
                        items: 3
                    }
                }
            });
            // without description
        } else {
            jQuery(unique_slider_class).owlCarousel({
                rtl: rtl,
                mouseDrag: false,
                dots: false,
                loop: true,
                margin: 10,
                autoplay: autoplay,
                nav: show_navigation,
                navText: [
                    "<span class='rp__icon fa fa-caret-left'></span>",
                    "<span class='rp__icon fa fa-caret-right'></span>"
                ],
                responsiveClass: true,
                responsiveBaseElement: unique_slider_class,
                responsive: {
                    0: {
                        items: 1,
                        loop: true
                    },
                    630: {
                        items: 2,
                        loop: true
                    },
                    740: {
                        items: 3,
                        loop: true
                    },
                    970: {
                        items: 4,
                        loop: true
                    },
                    1170: {
                        items: 5
                    }
                }
            });
        }
    });
}