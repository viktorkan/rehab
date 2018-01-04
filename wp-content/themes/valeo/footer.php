<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 */
?>
        <div id="to-top" class="to-top"><i class="fa fa-angle-up"></i></div>
	</div><!-- .site-content -->

    <?php do_action('valeo_after_content'); ?>



</div><!-- .site -->
<?php
if ( valeo_is_frontpage() ) {
	do_action( 'valeo_before_footer' );
}
wp_footer(); ?>

</body>
</html>
