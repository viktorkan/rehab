<?php
/**
 * The sidebar containing the main widget area
 */

?>
<div class="<?php echo valeo_sidebar_class( "sidebar", "woocommerce_sidebar" ); ?>">
    <div class="sidebar-sticky-off <?php echo valeo_sidebar_class( "container", "woocommerce_sidebar" ); ?>">
        <?php
        if ( is_active_sidebar( 'woocommerce' )  ) : ?>
            <div id="secondary" class="secondary">
                <div id="widget-area" class="widget-area" role="complementary">
                    <?php dynamic_sidebar( 'woocommerce' ); ?>
                </div><!-- .widget-area -->
            </div><!-- .secondary -->
        <?php endif; ?>
    </div>
</div>
