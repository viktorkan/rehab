jQuery(document).ready(function($) {
    "use strict";
    $(".like_button").click(function(e){
        var id = $(this).parent().data('id'),
            data = {
            action: 'add_like',
            security : MyAjax.security,
            pID: id
            },
            parent = $(this).parent();

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        var post_result = $.post(MyAjax.ajaxurl, data, function(response) {
            parent.html('<i class="fa fa-heart"></i>');
            $('.votes_count_'+id).html(response);
        }).done(function() {

        }).fail(function(xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
        }).always(function() {
        });

        e.preventDefault();
    });
});