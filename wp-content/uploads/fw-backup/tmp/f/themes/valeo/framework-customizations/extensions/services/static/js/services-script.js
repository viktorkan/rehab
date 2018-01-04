jQuery(document).ready(function ($) {
    "use strict";
});

jQuery(document).ready(function ($) {
    if ($().mixItUp) {
        $('#Container').mixItUp();
        $('.wrapp-categories-services .categories-item a').click(function (e) {
            e.preventDefault();
        });
    }
});
