(function($){
    "use strict";

    // Small function that improves shoping cart hover behaviour in the menu
    function valeo_show_cart_dropdown() {
        var cart_button = jQuery('.cart__subtotal'),
            cart_dropdown = jQuery('.cart__dropdown_inner').css({display: 'none', opacity: 0});

        cart_button.hover(
            function () {
                cart_dropdown.css({display: 'block'}).stop().animate({opacity: 1});
            },
            function () {
                cart_dropdown.stop().animate({opacity: 0}, function () {
                    cart_dropdown.css({display: 'none'});
                });
            }
        );
        cart_dropdown.hover(
            function () {
                cart_dropdown.css({display: 'block'}).stop().animate({opacity: 1});
            },
            function () {
                cart_dropdown.stop().animate({opacity: 0}, function () {
                    cart_dropdown.css({display: 'none'});
                });
            }
        );
    }

    // Updates the shopping cart in the sidebar, hooks into the added_to_cart event whcih is triggered by woocommerce
    function valeo_update_cart_dropdown() {
        var menu_cart = jQuery('.cart__dropdown'),
            dropdown_cart = menu_cart.find('.cart__dropdown_inner:eq(0)'),
            dropdown_html = dropdown_cart.html(),
            subtotal = jQuery('.cart__subtotal'),
            sidebarWidget = jQuery('.widget_shopping_cart');

        dropdown_cart.load(window.location + ' .cart__dropdown_inner:eq(0) > *', function () {
            dropdown_cart.html(dropdown_html);
            var subtotal_new = dropdown_cart.find('.total');
            subtotal_new.find('strong').remove();
            subtotal.html(subtotal_new.html());

            jQuery('.widget_shopping_cart, .updating').css('opacity', '1'); //woocommerce script has a racing condition in updating opacity to 1 so it doesnt always happen, this fixes the problem

            //if we are on a page without real cart widget show the dropdown widget for a moment as visual feedback
            if (!sidebarWidget.length) {
                var notification = jQuery('<div class="update_succes woocommerce_message">' + menu_cart.data('success') + '</div>').prependTo(dropdown_cart);
                dropdown_cart.css({display: 'block'}).stop().animate({opacity: 1}, function () {
                    notification.delay(500).animate({
                        height: 0,
                        opacity: 0,
                        paddingTop: 0,
                        paddingBottom: 0
                    }, function () {
                        notification.remove();
                    });
                    dropdown_cart.delay(1000).animate({opacity: 0}, function () {
                        dropdown_cart.css({display: 'none'});
                    });
                });
            }
        });
    }

    jQuery(document).ready(function($) {

        valeo_show_cart_dropdown();
        $('body').bind('added_to_cart', valeo_update_cart_dropdown);

    });

})(jQuery);
