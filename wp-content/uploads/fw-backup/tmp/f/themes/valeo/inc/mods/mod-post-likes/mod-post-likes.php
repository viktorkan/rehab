<?php
if ( ! function_exists( 'valeo_set_post_likes' ) ) :
    /**
     * Likes incrementor
     *
     * @param int $postID ID of the post.
     * @return bool No success if cookies are disabled
     */
    function valeo_set_post_likes($postID) {
        if( empty( $_COOKIE["$postID"] ) ) {

            $count_key = 'valeo_post_likes_count';
            $count = get_post_meta($postID, $count_key, true);
            if ($count == '') {
                $count = 0;
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '1');
            } else {
                $count++;
                update_post_meta($postID, $count_key, $count);
            }
            setcookie( "$postID", "voted", strtotime('+1 day'), COOKIEPATH, COOKIE_DOMAIN, false ); // 86400 = 1 day
            return true;
        }
        return false;
    }
endif;

if ( ! function_exists( 'valeo_get_post_likes' ) ) :
    /**
     * Get likes value
     *
     * @param int $postID ID of the post.
     */
    function valeo_get_post_likes($postID){
        $count_key = 'valeo_post_likes_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return '0';
        }
        return $count;
    }
endif;

if ( ! function_exists( 'valeo_post_likes_scripts' ) ) :
// Add the JS
function valeo_post_likes_scripts() {
    wp_enqueue_script( 'valeo-post-likes', get_template_directory_uri() . '/inc/mods/mod-post-likes/mod-post-likes.js', array('jquery'), '1.0.0', true );
    wp_localize_script( 'valeo-post-likes', 'MyAjax', array(
        // URL to wp-admin/admin-ajax.php to process the request
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        // generate a nonce with a unique ID "myajax-post-comment-nonce"
        // so that you can check it later when an AJAX request is sent
        'security' => wp_create_nonce( 'increment-post-likes' )
    ));
}
endif;
add_action( 'wp_enqueue_scripts', 'valeo_post_likes_scripts' );

if ( ! function_exists( 'valeo_inc_post_like_callback' ) ) :
// The function that handles the AJAX request
function valeo_inc_post_like_callback() {
    check_ajax_referer( 'increment-post-likes', 'security' );
    $pID = intval( $_POST['pID'] );
    valeo_set_post_likes($pID);
    echo valeo_get_post_likes( $pID );

    die(); // this is required to return a proper result
}
endif;
add_action( 'wp_ajax_add_like', 'valeo_inc_post_like_callback' );
add_action( 'wp_ajax_nopriv_add_like', 'valeo_inc_post_like_callback' );

if ( ! function_exists( 'valeo_post_like_button' ) ) :
    /**
     * Print like button
     */
    function valeo_post_like_button( $postID ){
        $output = '';
        if( empty( $_COOKIE["$postID"] ) ) {
            $output = '<span data-id="'.$postID.'"><a href="" title="like me" class="like_button"><i class="fa fa-heart-o"></i></a></span>';
        } else {
            $output = '<i class="fa fa-heart"></i>';
        }
        echo apply_filters( 'valeo_like_button', $output );
    }
endif;
add_action( 'valeo_post_meta', 'valeo_post_like_button', 10, 1 );

if ( ! function_exists( 'valeo_post_like_count' ) ) :
    /**
     * Print like counter value
     */
    function valeo_post_like_count( $postID ){
        echo apply_filters( 'valeo_like_count', '<span class="votes_count_'.$postID.'">'.valeo_get_post_likes($postID).'</span>' );
    }
endif;
add_action( 'valeo_post_meta', 'valeo_post_like_count', 20, 1 );

if ( ! function_exists( 'valeo_post_like_number' ) ) :
	/**
	 * Print like counter value / only number
	 */
	function valeo_post_like_number( $postID ){
		echo apply_filters( 'valeo_like_count', '<span class="votes_count_'.$postID.'">'.valeo_get_post_likes($postID).'</span>' );
	}
endif;
add_action( 'valeo_post_like_number', 'valeo_post_like_number', 20, 1 );