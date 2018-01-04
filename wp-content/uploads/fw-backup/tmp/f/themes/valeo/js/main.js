(function($){
    "use strict";

    var $allVideos = jQuery(".entry-content iframe, .video-wrapper iframe, .post__media_wide .container iframe, .post__media iframe, .post__media object, .post__media embed");

    function valeo_get_all_videos() {
        $allVideos.each(function () {
            jQuery(this).attr('data-aspectratio', this.height / this.width).removeAttr('height').removeAttr('width');
        });
    }

    function valeo_resize_all_videos() {
        $allVideos.each(function () {
            var $el = jQuery(this);
            var newWidth = jQuery(this).parent().width();
            $el.width(newWidth).height((newWidth * $el.attr('data-aspectratio')).toFixed());
        });
    }

    // Re-initialize the main navigation when it is updated in Customizer
    $( document ).on( 'customize-preview-menu-refreshed', function( e, params ) {
        if ( 'primary' === params.wpNavMenuArgs.theme_location ) {

            //Hidding menu elements that do not fit in menu width
            window.collect();
            // as variant:
            //$(window).trigger("resize");

        }
    });

    jQuery(document).ready(function($) {

        // Preloader
        $('#status').fadeOut();
        $('#preloader').delay(200).fadeOut(200);

        // apply more softly a menu appear
        $('.main-nav .menu').css('visibility', 'visible');

        /**
         * Hidding menu elements that do not fit in menu width
         */
        // width of element 'li#more-li' (with margins etc.)
        var menuExtraWidth = 18;
        // the same but with no magic number:
        menuExtraWidth = Math.floor($('li#more-li').outerWidth()); //note: .outerWidth(includeMargin = false) by default
        menuExtraWidth = (menuExtraWidth < 18 ) ? 18 : menuExtraWidth;
        // console.log('menuExtraWidth= ' + menuExtraWidth);

        window.collect = function() {
        // function collect() {
            // apply more softly a menu appear
            $('.main-nav .menu').css('visibility', 'visible');
            var fitCount = 0;
            var $menu = $("nav.main-nav > ul").first();
            var menuId = $menu[0].id; // "menu-contract-expand"
            if (!menuId) {
                return;
            }
            var liElementsSelector = "ul#" + menuId + " > li";
            var $liElements = $(liElementsSelector);
            var menuItemsCount = $liElements.length;
            //console.log('menuItemsCount= ' + menuItemsCount);
            var menuWidth = $menu.width();
            if (menuWidth == 0 || menuWidth < 320) {
                return;
            }
            // what 'Extra Menu' (element 'li#more-li') width in percentage?
            var menuExtraWidthPercentage = Math.floor( menuExtraWidth * 100 / menuWidth );
            /* set Main Menu width in % */
            $menu.width((100 - (menuExtraWidthPercentage + 3)) + '%'); // note: magic
            // Get the container width
            menuWidth = Math.round($menu.width()) - 35; // note: magic
            // Calculate how many list-items can be accomodated in that width
            $liElements.each(function(index) {
                var liElem = Math.floor($(this).outerWidth(true));
                if (menuWidth > liElem) { // note: .outerWidth(includeMargin = true)
                    menuWidth -= liElem;
                    fitCount++;
                    $(this).show();
                }
                else {
                    $(this).hide();
                }
            });
            // correct fitCount: it can not be equal to '-1'
            fitCount = (fitCount < 0 ) ? 0 : fitCount;
            //console.log('fitCount= ' + fitCount);
            // we do not need to show #menu-extra?
            if (menuItemsCount <= fitCount) {
                $("#more-li").css('visibility', 'hidden');
                $menu.width('100%');
                return;
            }
            else {
                $("#more-li").css('visibility', 'visible');
            }
            //console.log('Number of items should be putted in Extra Menu: ' + (menuItemsCount - fitCount));
            // Create a new set of list-items more than the fit count
            var $collectedSet = $menu.children(".menu-item:gt(" + (fitCount-1) + ")");
            $collectedSet = $collectedSet.clone();
            // Empty the collection submenu and add the cloned collection set
            $("#menu-extra").empty().append($collectedSet.show());
        }
        collect();
        //call resize handler to build menu right
        $(window).resize(collect);
        // as bad variant:
        //$(window).trigger("resize");

        // Fit video frames to document width
        valeo_get_all_videos();
        valeo_resize_all_videos();

        /*** Navigation in responsive layouts
         --------------------------------------------------- ****/
        var $menu = $('.main-nav > ul').first(),
            optionsList = '<option value="" selected> - - Main Navigation - - </option>';

        if( $menu.length ) {
            $menu.find('li').each(function () {
                var $this = $(this),
                    $anchor = $this.children('a'),
                    depth = $this.parents('ul').length - 1,
                    indent = '';

                if (depth) {
                    while (depth > 0) {
                        indent += ' &nbsp; ';
                        depth--;
                    }
                }

                optionsList += '<option value="' + $anchor.attr('href') + '">' + indent + ' ' + $anchor.text() + '</option>';
            }).end().parent().parent().parent().parent().parent().find('.nav-button').append('<select class="mobile-menu">' + optionsList + '</select><div class="mobile-menu-title"><i class="fa fa-bars"></i></div>');
        } else {
            $('.nav-button').append("Please create menu");
        }

        $('.mobile-menu').on('change', function () {
            window.location = $(this).val();
        });

        // PrettyPhoto
        $("a[data-gal^='prettyPhoto']").prettyPhoto({
            theme: 'dark_square',
            social_tools: false
        });

        // Sticky Top Menu
        if ($().sticky) {
            if ($('body').hasClass('admin-bar')) {
                $('.header-sticky').sticky({topSpacing: 32});
                //sticky-update
                $('.header-sticky').on('sticky-start', function () {
                    $('.header-sticky-height').css('height', $('.header-sticky').outerHeight());
                });
                $('.header-sticky').on('sticky-end', function () {
                    $('.header-sticky-height').css('height', 'auto');
                });
            } else {
                $('.header-sticky').sticky({topSpacing: 0});
                //sticky-update
                $('.header-sticky').on('sticky-start', function () {
                    $('.header-sticky-height').css('height', $('.header-sticky').outerHeight());
                });
                $('.header-sticky').on('sticky-end', function () {
                    $('.header-sticky-height').css('height', 'auto');
                });
            }
        }

        // Menu search
        $('.header-button__search').on('click', function () {
            $('body').toggleClass('search-box--opened');
            $('.search-box__icon').toggleClass('active');
            $('#search-box__input').toggleClass('fadein');
        });
        $('.body-overlay').on('click', function () {
            $('body').removeClass('search-box--opened');
            $('.search-box__icon').removeClass('active');
            $('#search-box__input').removeClass('fadein');
        });
        /*
        $(document).mouseup(function (e) {
            var container = $('.header');
            if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
                $('body').removeClass('search-box--opened');
                $('.search-box__icon').removeClass('active');
                $('#search-box__input').removeClass('fadein');
            }
        });
        */

        // Submit Comment form
        $('a.comment-submit').click(function (event) {
            event.preventDefault();
            $(this).closest('form').submit();
        });

        // Scroll totop button
        var toTop = $('#to-top');
        $(window).scroll(function () {
            if ($(this).scrollTop() > 1) {
                toTop.css({bottom: '0'});
            } else {
                toTop.css({bottom: '-100px'});
            }
        });
        toTop.click(function () {
            $('html, body').animate({scrollTop: '0px'}, 800);
            return false;
        });

        // Post controls
        $('.pctrl-social-btn').click(function () {
            $('.post-controls').toggleClass('active');
        });

        // Unyson Sliders
        if ($().nivoSlider) {
            $('.nivoSlider').each(function () {
                var slider = $(this);
                var autoplay = slider.data('autoplay') ? slider.data('autoplay') : false;
                slider.nivoSlider({
                    effect: 'random',
                    manualAdvance: autoplay,
                });
            });
        }

        // Bootstrap select
        if ($().selectpicker) {

            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
                $('.widget select').selectpicker('mobile');
                $('.orderby').selectpicker('mobile');
                $('#pa_color').selectpicker('mobile');
                $('.mptt-navigation-select').selectpicker('mobile');
                $('.field-select select').selectpicker('mobile');
            }
            else {
                $('.widget select').selectpicker({
                    container: 'body',
                    width: '100%',
                    size: 8
                });
                $('.orderby').selectpicker({
                    container: 'body',
                    width: '100%',
                    size: 8
                });
                $('#pa_color').selectpicker({
                    container: 'body',
                    width: '100%',
                    size: 8
                });
                $('.mptt-navigation-select').selectpicker({
                    container: 'body',
                    width: '100%',
                    size: 8
                });
                $('.field-select select').selectpicker({
                    container: 'body',
                    width: '100%',
                    size: 8
                });
            }

        }

        // Date Time Picker
        $('[id ^= id-date]').each(function(){
            var datePicker = $(this);
            datePicker.datetimepicker({
                pickDate: datePicker.data('pick-date'),
                pickTime: datePicker.data('pick-time'),
                useSeconds: false,
                language: datePicker.data('language'),
                debug: false,
            });
        });

        // footer google map
        if (typeof google === 'object' && typeof google.maps === 'object') {
            if ($('#map-canvas').length) {

                var gmap = $('.footer-google-map');
                var domain = gmap.data('domain') ? gmap.data('domain') : '';
                var gmap_coordinates = gmap.data('center') ? gmap.data('center') : '';
                var marker_coordinates = gmap.data('marker') ? gmap.data('marker') : '';

                var gmap_coordinates_array = gmap_coordinates.split(',');
                var marker_coordinates_array = marker_coordinates.split(',');

                var map;
                var marker;
                var image = domain + '/images/gmap-marker.png'; // marker icon
                google.maps.event.addDomListener(window, 'load', function () {
                    var mapOptions = {
                        scrollwheel: false,
                        zoom: 12,
                        center: new google.maps.LatLng(gmap_coordinates_array[0],gmap_coordinates_array[1]), // map coordinates
                        styles:	[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
                    };

                    map = new google.maps.Map(document.getElementById('map-canvas'),
                        mapOptions);
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(marker_coordinates_array[0],marker_coordinates_array[1]), // marker coordinates
                        map: map,
                        icon: image,
                        title: 'Hello World!'
                    });

                });

                //
                $('.footer-google-map-close').on('click', function () {
                    $('.footer-google-map').toggleClass('active');
                    $('.footer-google-map-close').toggleClass('active');
                });
                $('a[href="#openmap"]').on('click', function () {
                    $('.footer-google-map').toggleClass('active');
                    $('.footer-google-map-close').toggleClass('active');
                });
                $('a[href="#gotomap"]').on('click', function () {
                    $('html,body').animate({scrollTop: $(".footer").offset().top});
                    $('.footer-google-map').toggleClass('active');
                    $('.footer-google-map-close').toggleClass('active');
                });

            } // if length
        } // if object


    });

    $(window).load(function () {

        // Sticky Sidebar
        var stickyParentRow = $(".post-container > .row > .col-sm-8"),
            stickySidebar = $(".sidebar-sticky");

        function detachSidebar() {
            if( 768 > $(window).width() ) {
                stickySidebar.trigger("sticky_kit:detach");
            }
        }

        if( stickyParentRow.length ) {
            stickySidebar.stick_in_parent({
                offset_top: 0,
                parent: ".content-area",
                spacer: false
            }).on("sticky_kit:bottom", function () {
                $(this).parent().css("position", "static")
            }).on("sticky_kit:unbottom", function () {
                $(this).parent().css("position", "relative")
            });
            detachSidebar();
        }

        //Placeholder cleaning
        var $ph = $('input[type="search"], input[type="text"], input[type="url"], input[type="number"], input[type="email"], textarea');
        $ph.each(function() {
            var value = $(this).val();
            $(this).focus(function() {
                if ($(this).val() === value) {
                    $(this).val('');
                }
            });
            $(this).blur(function() {
                if ($(this).val() === '') {
                    $(this).val(value);
                }
            });
        });

        /*$('.owl-widget-single').owlCarousel({
            lazyLoad:true,
            dots:false,
            loop:true,
            margin:0,
            nav:true,
            navText: [
                "<i class='icon-left-open-big'></i>",
                "<i class='icon-right-open-big'></i>"
            ],
            responsiveClass:true,
            responsiveBaseElement:".widget_recent_entries_slider",
            responsive:{
                0:{
                    items:1,
                    loop:true,
                    nav:true
                },
                600:{
                    items:1,
                    loop:true
                },
                900:{
                    items:1
                }
            }
        });*/

        /*$('.owl-widget').owlCarousel({
            dots:false,
            loop:false,
            margin:30,
            nav:true,
            navText: [
                "<i class='icon-left-open-big'></i>",
                "<i class='icon-right-open-big'></i>"
            ],
            responsiveClass:true,
            responsiveBaseElement:".widget_recent_entries_carousel",
            responsive:{
                0:{
                    items:1,
                    loop:true,
                    nav:true
                },
                600:{
                    items:3,
                    loop:true
                },
                900:{
                    items:4
                },
                1900:{
                    items:5
                },
                2500:{
                    items:6
                },
                3200:{
                    items:7
                }
            }
        });*/

        $('.owl-gallery').owlCarousel({
            rtl:true,
            margin:0,
            items:1,
            loop:true,
            nav:true,
            autoHeight : true,
            navText: [
                "<i class='fa fa-caret-left'></i>", // icon-left-open-big
                "<i class='fa fa-caret-right'></i>" // icon-right-open-big
            ],
            responsiveClass:true,
            responsiveBaseElement:".footer",
            responsive:{
                0:{
                    dots:false
                },
                955:{
                    dots:true
                }
            }
        });
    });

    jQuery(window).resize(function($) {

        // Fit video frames to document width
        valeo_resize_all_videos();

    });

    // hide placeholders on focus
    $(function () {
        $('input,textarea').focus(function () {
            $(this).data('placeholder', $(this).attr('placeholder'))
                .attr('placeholder', '');
        }).blur(function () {
            $(this).attr('placeholder', $(this).data('placeholder'));
        });
    });

})(jQuery);

/**
 * Unyson Mega Menu
 */
jQuery(function ($) {

    function hoverIn() {
        var a = $(this);
        var nav = a.closest('.menu');
        var mega = a.find('.mega-menu');
        var offset = rightSide(nav) - leftSide(a);
        mega.width(Math.min(rightSide(nav), columns(mega)*325));
        mega.css('left', Math.min(0, offset - mega.width()));
    }

    function hoverOut() {}

    function columns(mega) {
        var columns = 0;
        mega.children('.mega-menu-row').each(function () {
            columns = Math.max(columns, $(this).children('.mega-menu-col').length);
        });
        return columns;
    }

    function leftSide(elem) {
        return elem.offset().left - 15;
    }

    function rightSide(elem) {
        return elem.offset().left + elem.width();
    }

    $('.menu-strip .menu-item-has-mega-menu').hover(hoverIn, hoverOut);

});