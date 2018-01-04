<?php
/**
 * The sidebar containing the main widget area
 */

$get_in_heading = '';
if( empty($get_in_heading) ) {
    $get_in_heading = esc_html__( 'Get in touch', 'valeo' );
}

?>
<div class="<?php echo valeo_sidebar_class( "sidebar" ); ?>">
    <div class="sidebar-sticky-off <?php echo valeo_sidebar_class( "container" ); ?>">
    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <div id="secondary" class="secondary">
            <div id="widget-area" class="widget-area" role="complementary">
                <?php dynamic_sidebar( 'sidebar-1' ); ?>
            </div><!-- .widget-area -->
        </div><!-- .secondary -->
    <?php endif; ?>
    </div>
</div>
