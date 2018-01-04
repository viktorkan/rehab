<?php
if ( ! function_exists( 'valeo_set_post_views' ) ) :
    /**
     * Counter incrementor
     *
     * @param int $postID ID of the post.
     */
function valeo_set_post_views($postID) {
    $count_key = 'valeo_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
endif;
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10);

if ( ! function_exists( 'valeo_track_post_views' ) ) :
    /**
     * Post views tracker
     *
     * @param int $post_id ID of the post.
     */
function valeo_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;
    }
    valeo_set_post_views($post_id);
}
endif;
add_action( 'wp_head', 'valeo_track_post_views');

if ( ! function_exists( 'valeo_get_post_views' ) ) :
    /**
     * Get counter value
     *
     * @param int $postID ID of the post.
     */
function valeo_get_post_views($postID){
    $count_key = 'valeo_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return number_format( $count, 0, ".", "," );
}
endif;

if ( ! function_exists( 'valeo_post_column_views' ) ) :
//Function that Adds a 'Views' Column to your Posts tab in WordPress Dashboard.
function valeo_post_column_views($newcolumn){
    //Retrieves the translated string, if translation exists, and assign it to the 'default' array.
    $newcolumn['post_views'] = esc_html__('Views', 'valeo');
    return $newcolumn;
}
endif;

if ( ! function_exists( 'valeo_post_custom_column_views' ) ) :
//Function that Populates the 'Views' Column with the number of views count.
function valeo_post_custom_column_views($column_name, $id){

    if($column_name === 'post_views'){
        // Display the Post View Count of the current post.
        // get_the_ID() - Returns the numeric ID of the current post.
        echo valeo_get_post_views(get_the_ID());
    }
}
endif;
//Hooks a function to a specific filter action.
//applied to the list of columns to print on the manage posts screen.
add_filter('manage_posts_columns', 'valeo_post_column_views');

//Hooks a function to a specific action.
//allows you to add custom columns to the list post/custom post type pages.
//'10' default: specify the function's priority.
//and '2' is the number of the functions' arguments.
add_action('manage_posts_custom_column', 'valeo_post_custom_column_views',10,2);