/**
 * Customizer JS file
 * Updating active preview upon url change
 *
 * Modified: Used some functions from Layers Framework
 *
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

( function( exports, $ ) {

    "use strict";

    // Check if customizer exists
    if ( ! wp || ! wp.customize ) return;

    // WordPress Stuff
    var	api = wp.customize;

    // New Customizer Previewer class
    api.LbCustomizer = {

        init: function () {
            // Helper to get current url
            // provide default_url fix for when no query string 'url' exists,
            // which happens when coming from Appearance > Customizer
            if( !wp.customize.previewer ) return;

            var default_url = wp.customize.previewer.previewUrl();
            function valeo_get_customizer_url() {
                if( valeo_get_parameter_by_name('url', window.location) ){
                    return valeo_get_parameter_by_name('url', window.location);
                }
                else {
                    return default_url;
                }
            }

            // Helper to get query stings by param name - like query strings.
            function valeo_get_parameter_by_name(name, url) {
                name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                    results = regex.exec(url);
                return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            // Update the UI when customizer url changes
            // eg when an <a> in the preview window is clicked
            function valeo_update_customizer_interface() {
                // Change the 'X' close button
                $('.customize-controls-close').attr('href', wp.customize.previewer.previewUrl() );
            }
            valeo_update_customizer_interface();

            // Listen for event when customizer url changes
            function valeo_handle_customizer_talkback() {
                valeo_add_history_state();
                valeo_update_customizer_interface();
            }
            wp.customize.previewer.bind('url', valeo_handle_customizer_talkback);

            // Add history state customizer changes
            function valeo_add_history_state(){
                // Update the browser URl so page can be refreshed
                if (window.history.pushState) {
                    // Newer Browsers only (IE10+, Firefox3+, etc)
                    var url = window.location.href.split('?')[0] + "?url=" + wp.customize.previewer.previewUrl();
                    window.history.pushState({}, "", url);
                }
            }

            // Listen for changes in history state - eg push of the next/prev button
            window.addEventListener('popstate', function(e){
                wp.customize.previewer.previewUrl( valeo_get_customizer_url() );
                valeo_update_customizer_interface();
            }, false);

        }
    };

    // On document ready
    $( function() {
        // Initialize Previewer
        api.LbCustomizer.init();
    } );

} )( wp, jQuery );