<?php
if ( ! function_exists( 'valeo_is_current_header' ) ) :
function valeo_is_current_header( $current_page_header, $headers_array ) {
    if ( !empty ( $GLOBALS['wp_customize'] ) ) {
        global $wp_customize;
        $post_values = $wp_customize->unsanitized_post_values();
        if( !empty($post_values['main_menu_style']) ) {
            $current_page_header = $post_values['main_menu_style'];
        }
    }

    return $current_page_header && array_key_exists( $current_page_header, $headers_array );
}
endif;

if ( ! function_exists( 'valeo_header_logo_big' ) ) :
function valeo_header_logo_big( $logo_url )
{
    if ( !empty ( $GLOBALS['wp_customize'] ) ) {
        global $wp_customize;
        $post_values = $wp_customize->unsanitized_post_values();
        if( isset($post_values['header_logo_big']) ) {
            $logo_url = $post_values['header_logo_big'];
        }
    }

    return esc_url($logo_url);
}
endif;
add_filter('valeo_header_logo_big', 'valeo_header_logo_big');

if ( ! function_exists( 'valeo_logo_site_name' ) ) :
function valeo_logo_site_name( $site_name, $is_site_name = true )
{
	if ( !empty ( $GLOBALS['wp_customize'] ) ) {
		global $wp_customize;
		$post_values = $wp_customize->unsanitized_post_values();
		if( isset($post_values['blogname']) && $is_site_name ) {
			$site_name = $post_values['blogname'];
		}
		if( isset($post_values['blogdescription']) && $is_site_name ) {
			$site_name = $post_values['blogdescription'];
		}
	}

	return $site_name;
}
endif;
add_filter('valeo_logo_site_name', 'valeo_logo_site_name');

if ( ! function_exists( 'valeo_get_header_styles' ) ) :
/**
 * Forming a Header Array for Customizer
 *
 * Creates the array to fill selects in metabox and theme options.
 *
 * @param	bool	is_metabox
 * @return	array
 */
function valeo_get_header_styles( $is_metabox = false ){
    $headers_array1 = apply_filters('valeo_headers_array1', false);
    $headers_array2 = apply_filters('valeo_headers_array2', false);
    $headers_array3 = apply_filters('valeo_headers_array3', false);
    $headers_array4 = apply_filters('valeo_headers_array4', false);
    $headers_list = array(
        'header1' => 'Default Header',
    );

    for($i = 1; $i <= 4; $i++) {
        if( is_array( ${'headers_array' . $i} ) ) {
            $headers_list += ${'headers_array' . $i};
        }
    }

    if( $is_metabox ) {
        array_unshift( $headers_list, array('value' => 'default', 'label' => 'Default Header') );
    }

    return $headers_list;
}
endif;

if ( ! function_exists( 'valeo_print_header' ) ) :
/**
 * Form function call to print header depending on settings
 *
 * Calls function to print out selected header
 *
 * @param	string	header_id
 * @param   array   theme_options
 */
function valeo_print_header($header_id, $theme_options) {

    if( empty($header_id) || $header_id == 'default' ) {
        $header_id = valeo_set($theme_options, 'default_header_style');
    }

    $header_func = 'valeo_'.$header_id;

    if( function_exists($header_func) ) {
        $header_func($theme_options);
    } else {
        valeo_header1($theme_options);
    }
}
endif;

if ( ! function_exists( 'valeo_header1' ) ) :
/**
 * Add as many header styles as you need. Don't forget to add them to array in valeo_get_header_styles
 *
 * Header: 'Thin' Style
 */
function valeo_header1( $theme_options ) { ?>
	<?php
	$logo_class  = 'logo ';
	$header_logo = '';
	if ( get_theme_mod( 'header_use_logo' ) ) {
		$logo_class .= 'logo-use-image';
		$header_logo = 'header-logo-image';
	} else {
		$logo_class .= 'logo-use-text';
		$header_logo = 'header-logo-text';
	}

	// define the 'Main Menu' should be wide or not.
	$bootstrap_class = valeo_get_customizer_option('hide_header_social')? 'col-md-12' : 'col-md-9';

	$bootstrap_class_HeaderButtons = 'col-md-3';
	if ( valeo_get_customizer_option('hide_header_social') && !valeo_get_customizer_option('hide_header_search') ) {
		$bootstrap_class               = 'col-md-11';
		$bootstrap_class_HeaderButtons = 'col-md-1';
	}

	$hide_shop_icon = true;
	if ( function_exists( 'valeo_woocommerce_enabled' ) && valeo_woocommerce_enabled() && valeo_get_customizer_option( 'hide_shop_icon' ) == '' ) {
		$hide_shop_icon = false;
	}

	if ( valeo_get_customizer_option('hide_header_social') && valeo_get_customizer_option('hide_header_search') && $hide_shop_icon ) {
		$bootstrap_class_HeaderButtons = 'hidden-md hidden-lg';
	}
	?>

	<!-- tc: valeo_header1 -->
	<div class="header-wrapper" id="header-wrapper">
		<div class="header style1 <?php echo esc_attr( $header_logo ); ?>">

			<div class="header__row1">
				<div class="container">
					<div class="row">

						<?php if ( valeo_get_customizer_option( 'hide_header_contacts' ) == '' ) { ?>

						<!-- Header Contact 1 -->
						<div class="header__contact header__contact1 col-md-4 col-sm-4 col-xs-6">
							<div class="header__contact_wrapper">
								<div class="header__contact_inner">
									<div class="header__contact_content">
										<?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'contact_block_phone' ) ) ); ?>
									</div>
								</div>
							</div>
						</div><!-- .header__contact1 -->

						<!-- Header Contact 2 -->
						<div class="header__contact header__contact2 col-md-4 col-sm-4 col-xs-6 col-md-push-4 col-sm-push-4">
							<div class="header__contact_wrapper">
								<div class="header__contact_inner">
									<div class="header__contact_content">
										<?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'contact_block_email' ) ) ); ?>
									</div>
								</div>
							</div>
						</div><!-- .header__contact2 -->

						<?php } ?>

						<!-- Header Logo -->
						<?php if ( valeo_get_customizer_option( 'hide_header_contacts' ) == '' ) { ?>
						<div class="header__logo col-md-4 col-sm-4 col-xs-12 col-md-pull-4 col-sm-pull-4">
						<?php } else { ?>
						<div class="header__logo col-md-12">
						<?php } ?>
							<div class="header__logo-inner">
								<!-- Logo -->
								<div class="<?php echo esc_attr( $logo_class ); ?>">
									<?php if ( get_theme_mod( 'header_use_logo' ) ) { ?>
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
											<img alt="Logo" class="logo logo_big"
											     src="<?php echo apply_filters( 'valeo_header_logo_big', $theme_options['header_logo_big'] ); ?>"/>
										</a>
									<?php } else { ?>
										<div class="text-logo">
											<div class="blogname">
												<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
													$site_name = apply_filters( "valeo_logo_site_name", get_bloginfo( 'name', 'display' ) );
													if ( ! empty( $site_name ) ) {
														echo valeo_logo_highlight( esc_attr( $site_name ) );
													} ?>
												</a>
											</div>
											<div class="blogdescr">
												<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
													$site_description = apply_filters( "valeo_logo_site_name", get_bloginfo( 'description', 'display' ) );
													if ( ! empty( $site_description ) ) {
														echo valeo_replace_str_blogdescr( esc_attr( $site_description ) );
													} ?>
												</a>
											</div>
										</div>
									<?php } ?>
								</div><!-- .logo-->
							</div><!-- .header__logo-inner -->
						</div><!-- .header__logo -->

					</div>
				</div>
			</div><!-- .header__row1 -->

			<div class="header-sticky-height">
				<div class="header__row2 header-sticky">
					<div class="container">
						<div class="row">

							<!-- Header Menu -->
							<div class="header__menu <?php print $bootstrap_class ?> col-sm-12 hidden-xs">
								<div class="header__menu-inner">

									<!-- Menu Strip -->
									<div class="menu-strip">
										<nav class="main-nav"><?php
											if ( has_nav_menu( 'primary' ) ) {
												wp_nav_menu( array(
													'container'      => false, /* classes for container */
													'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
													'theme_location' => 'primary', /* we have two menus here we use our header menu as primery navigation */
													'depth'          => 0 /* in depth of 3 we'r using dropdown menu */
												) );
												valeo_header_menu_extra();

											} elseif ( wp_get_nav_menu_object( "Main menu" ) ) {
												wp_nav_menu( array(
													'container'  => false, /* classes for container */
													'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
													'menu'       => esc_attr( 'Main menu', 'valeo' ),
													'depth'      => 0 /* in depth of 3 we'r using dropdown menu */
												) );
												valeo_header_menu_extra();

											} else { ?>
												<div class="create-menu"><?php esc_html_e( 'You don\'t have a menu. Please create one ', 'valeo' ); ?>
												<strong><a href="<?php echo esc_url( home_url( '/' ) ) ?>wp-admin/nav-menus.php"><?php esc_html_e( 'HERE', 'valeo' ) ?></a></strong>
												</div><?php
											} ?>
										</nav>
									</div><!-- .menu-strip -->

								</div><!-- .header__menu-inner -->
							</div><!-- .header__menu -->

							<!-- Header Buttons and Social icons -->
							<div class="header__buttons header__social <?php print $bootstrap_class_HeaderButtons ?> hidden-sm col-sm-12">
								<div class="header__social-wrapper">
									<div class="header__social-inner">
										<div class="header-social">
											<ul id="menu-social-menu" class="social-navigation">
												<?php // search icon
												if ( valeo_get_customizer_option( 'hide_header_search' ) == '' ) { ?>
													<li class="button-li">
														<span class="header-button header-button__wrapper">
															<span class="header-button header-button__search"><i class="fa fa-search"></i></span>
														</span>
													</li>
												<?php }
												// Shop icon and dropdown cart
												if ( !$hide_shop_icon ) { ?>
													<li class="button-li">
														<?php echo valeo_woocommerce_cart_dropdown(); ?>
													</li>
												<?php }
												if ( valeo_get_customizer_option( 'hide_header_social' ) == '' ) {
													echo valeo_header_social_links();
												} ?>
												<li class="button-li nav-bar">
														<span class="header-button header-button__wrapper">
															<span class="header-button header-button__menu nav-button"></span>
														</span>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div><!-- .header__buttons -->

						</div><!-- .row -->
					</div><!-- .container -->
				</div><!-- .header__row2 -->
			</div><!-- .header-sticky-height -->

		</div><!-- .header.style1 -->
	</div><!-- .header-wrapper -->

	<?php if ( valeo_get_customizer_option( 'hide_header_search' ) == '' ) { ?>
		<!-- Search Box -->
		<div class="search-box">
			<form class="search-box__form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
				<label class="search-box__label" for="search-box__input"><?php
					esc_html_e( 'Enter search words and press enter', 'valeo' ) ?></label>
				<input class="search-box__input" type="search" id="search-box__input" name="s"
				       placeholder="<?php esc_html_e( 'Type search keyword here...', 'valeo' ) ?>"/>
			</form>
		</div><!-- .search-box -->
	<?php } ?>
	<!-- tc: /valeo_header1 -->
	<?php
}
endif;

if ( ! function_exists( 'valeo_header2' ) ) :
/**
 * Add as many header styles as you need. Don't forget to add them to array in valeo_get_header_styles
 *
 * Header: 'Thick' Style
 */
function valeo_header2( $theme_options ) { ?>
	<?php
	$logo_class  = 'logo ';
	$header_logo = '';
	if ( get_theme_mod( 'header_use_logo' ) ) {
		$logo_class .= 'logo-use-image';
		$header_logo = 'header-logo-image';
	} else {
		$logo_class .= 'logo-use-text';
		$header_logo = 'header-logo-text';
	}

	// define the 'Main Menu' should be wide or not.
	$bootstrap_class = valeo_get_customizer_option('hide_header_social')? 'col-md-12' : 'col-md-9';

	$bootstrap_class_HeaderButtons = 'col-md-3';
	if ( valeo_get_customizer_option('hide_header_social') && !valeo_get_customizer_option('hide_header_search') ) {
		$bootstrap_class               = 'col-md-11';
		$bootstrap_class_HeaderButtons = 'col-md-1';
	}

	$hide_shop_icon = true;
	if ( function_exists( 'valeo_woocommerce_enabled' ) && valeo_woocommerce_enabled() && valeo_get_customizer_option( 'hide_shop_icon' ) == '' ) {
		$hide_shop_icon = false;
	}

	if ( valeo_get_customizer_option('hide_header_social') && valeo_get_customizer_option('hide_header_search') && $hide_shop_icon ) {
		$bootstrap_class_HeaderButtons = 'hidden-md hidden-lg';
	}
	?>

	<!-- tc: valeo_header2 -->
	<div class="header-wrapper" id="header-wrapper">
		<div class="header style2 <?php echo esc_attr( $header_logo ); ?>">

			<div class="header__row1">
				<div class="container">
					<div class="row">

						<?php if ( valeo_get_customizer_option( 'hide_header_contacts' ) == '' ) { ?>

						<!-- Header Contact 1 -->
						<div class="header__contact header__contact1 col-md-4 col-sm-4 col-xs-6">
							<div class="header__contact_wrapper">
								<div class="header__contact_inner">
									<div class="header__contact_content">
										<?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'contact_block_phone' ) ) ); ?>
									</div>
								</div>
							</div>
						</div><!-- .header__contact1 -->

						<!-- Header Contact 2 -->
						<div
							class="header__contact header__contact2 col-md-4 col-sm-4 col-xs-6 col-md-push-4 col-sm-push-4">
							<div class="header__contact_wrapper">
								<div class="header__contact_inner">
									<div class="header__contact_content">
										<?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'contact_block_email' ) ) ); ?>
									</div>
								</div>
							</div>
						</div><!-- .header__contact2 -->

						<?php } ?>

						<!-- Header Logo -->
						<?php if ( valeo_get_customizer_option( 'hide_header_contacts' ) == '' ) { ?>
						<div class="header__logo col-md-4 col-sm-4 col-xs-12 col-md-pull-4 col-sm-pull-4">
						<?php } else { ?>
						<div class="header__logo col-md-12">
						<?php } ?>
							<div class="header__logo-inner">
								<!-- Logo -->
								<div class="<?php echo esc_attr( $logo_class ); ?>">
									<?php if ( get_theme_mod( 'header_use_logo' ) ) { ?>
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
											<img alt="Logo" class="logo logo_big" src="<?php echo apply_filters( 'valeo_header_logo_big', $theme_options['header_logo_big'] ); ?>"/>
										</a>
									<?php } else { ?>
										<div class="text-logo">
											<div class="blogname">
												<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
													$site_name = apply_filters( "valeo_logo_site_name", get_bloginfo( 'name', 'display' ) );
													if ( ! empty( $site_name ) ) {
														echo valeo_logo_highlight( esc_attr( $site_name ) );
													} ?>
												</a>
											</div>
											<div class="blogdescr">
												<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
													$site_description = apply_filters( "valeo_logo_site_name", get_bloginfo( 'description', 'display' ) );
													if ( ! empty( $site_description ) ) {
														echo valeo_replace_str_blogdescr( esc_attr( $site_description ) );
													} ?>
												</a>
											</div>
										</div>
									<?php } ?>
								</div><!-- .logo-->
							</div><!-- .header__logo-inner -->
						</div><!-- .header__logo -->

					</div>
				</div>
			</div><!-- .header__row1 -->

			<div class="header-sticky-height">
				<div class="header__row2 header-sticky">
					<div class="container">
						<div class="row">

							<!-- Header Menu -->
							<div class="header__menu <?php print $bootstrap_class ?> col-sm-12 hidden-xs">
								<div class="header__menu-inner">

									<!-- Menu Strip -->
									<div class="menu-strip">
										<nav class="main-nav"><?php
											if ( has_nav_menu( 'primary' ) ) {
												wp_nav_menu( array(
													'container'      => false, /* classes for container */
													'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
													'theme_location' => 'primary', /* we have two menus here we use our header menu as primery navigation */
													'depth'          => 0 /* in depth of 3 we'r using dropdown menu */
												) );
												valeo_header_menu_extra();

											} elseif ( wp_get_nav_menu_object( "Main menu" ) ) {
												wp_nav_menu( array(
													'container'  => false, /* classes for container */
													'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
													'menu'       => esc_attr( 'Main menu', 'valeo' ),
													'depth'      => 0 /* in depth of 3 we'r using dropdown menu */
												) );
												valeo_header_menu_extra();

											} else { ?>
												<div class="create-menu"><?php esc_html_e( 'You don\'t have a menu. Please create one ', 'valeo' ); ?>
												<strong><a href="<?php echo esc_url( home_url( '/' ) ) ?>wp-admin/nav-menus.php"><?php esc_html_e( 'HERE', 'valeo' ) ?></a></strong>
												</div><?php
											} ?>
										</nav>
									</div><!-- .menu-strip -->

								</div><!-- .header__menu-inner -->
							</div><!-- .header__menu -->

							<!-- Header Buttons and Social icons -->
							<div class="header__buttons header__social <?php print $bootstrap_class_HeaderButtons ?> hidden-sm col-sm-12">
								<div class="header__social-wrapper">
									<div class="header__social-inner">
										<div class="header-social">
											<ul id="menu-social-menu" class="social-navigation">
												<?php // search icon
												if ( valeo_get_customizer_option( 'hide_header_search' ) == '' ) { ?>
													<li class="button-li">
														<span class="header-button header-button__wrapper">
															<span class="header-button header-button__search"><i class="fa fa-search"></i></span>
														</span>
													</li>
												<?php }
												// Shop icon and dropdown cart
												if ( !$hide_shop_icon ) { ?>
													<li class="button-li">
														<?php echo valeo_woocommerce_cart_dropdown(); ?>
													</li>
												<?php }
												if ( valeo_get_customizer_option( 'hide_header_social' ) == '' ) {
													echo valeo_header_social_links();
												} ?>
												<li class="button-li nav-bar">
														<span class="header-button header-button__wrapper">
															<span class="header-button header-button__menu nav-button"></span>
														</span>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div><!-- .header__buttons -->

						</div><!-- .row -->
					</div><!-- .container -->
				</div><!-- .header__row2 -->
			</div><!-- .header-sticky-height -->

		</div><!-- .header.style2 -->
	</div><!-- .header-wrapper -->

	<?php if ( valeo_get_customizer_option( 'hide_header_search' ) == '' ) { ?>
		<!-- Search Box -->
		<div class="search-box">
			<form class="search-box__form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>"
			      role="search">
				<label class="search-box__label" for="search-box__input"><?php
					esc_html_e( 'Enter search words and press enter', 'valeo' ) ?></label>
				<input class="search-box__input" type="search" id="search-box__input" name="s"
				       placeholder="<?php esc_html_e( 'Type search keyword here...', 'valeo' ) ?>"/>
			</form>
		</div><!-- .search-box -->
	<?php } ?>
	<!-- tc: /valeo_header2 -->
	<?php
}
endif;

if ( ! function_exists( 'valeo_header3' ) ) :
	/**
	 * Add as many header styles as you need. Don't forget to add them to array in valeo_get_header_styles
	 *
	 * Header: 'Boxed' Style (Homepage Alternate)
	 */
	function valeo_header3( $theme_options ) { ?>
		<?php
		$logo_class  = 'logo ';
		$header_logo = '';
		if ( get_theme_mod( 'header_use_logo' ) ) {
			$logo_class .= 'logo-use-image';
			$header_logo = 'header-logo-image';
		} else {
			$logo_class .= 'logo-use-text';
			$header_logo = 'header-logo-text';
		}

		// define the 'Main Menu' should be wide or not.
		$bootstrap_class = valeo_get_customizer_option('hide_header_social')? 'col-md-12' : 'col-md-9';

		$bootstrap_class_HeaderButtons = 'col-md-3';
		if ( valeo_get_customizer_option('hide_header_social') && !valeo_get_customizer_option('hide_header_search') ) {
			$bootstrap_class               = 'col-md-11';
			$bootstrap_class_HeaderButtons = 'col-md-1';
		}

		$hide_shop_icon = true;
		if ( function_exists( 'valeo_woocommerce_enabled' ) && valeo_woocommerce_enabled() && valeo_get_customizer_option( 'hide_shop_icon' ) == '' ) {
			$hide_shop_icon = false;
		}

		if ( valeo_get_customizer_option('hide_header_social') && valeo_get_customizer_option('hide_header_search') && $hide_shop_icon ) {
			$bootstrap_class_HeaderButtons = 'hidden-md hidden-lg';
		}
		?>

		<!-- tc: valeo_header3 -->
		<div class="header-wrapper" id="header-wrapper">
			<div class="header style3 <?php echo esc_attr( $header_logo ); ?>">

				<div class="header__row1">
					<div class="container">
						<div class="row">

							<?php if ( valeo_get_customizer_option( 'hide_header_contacts' ) == '' ) { ?>

							<!-- Header Contact 1 -->
							<div class="header__contact header__contact1 col-md-4 col-sm-4 col-xs-6">
								<div class="header__contact_wrapper">
									<div class="header__contact_inner">
										<div class="header__contact_content">
											<?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'contact_block_phone' ) ) ); ?>
										</div>
									</div>
								</div>
							</div><!-- .header__contact1 -->

							<!-- Header Contact 2 -->
							<div
								class="header__contact header__contact2 col-md-4 col-sm-4 col-xs-6 col-md-push-4 col-sm-push-4">
								<div class="header__contact_wrapper">
									<div class="header__contact_inner">
										<div class="header__contact_content">
											<?php echo wp_kses_post( valeo_replace_str( valeo_get_customizer_option( 'contact_block_email' ) ) ); ?>
										</div>
									</div>
								</div>
							</div><!-- .header__contact2 -->

							<?php } ?>

							<!-- Header Logo -->
							<?php if ( valeo_get_customizer_option( 'hide_header_contacts' ) == '' ) { ?>
							<div class="header__logo col-md-4 col-sm-4 col-xs-12 col-md-pull-4 col-sm-pull-4">
							<?php } else { ?>
							<div class="header__logo col-md-12">
							<?php } ?>
								<div class="header__logo-inner">
									<!-- Logo -->
									<div class="<?php echo esc_attr( $logo_class ); ?>">
										<?php if ( get_theme_mod( 'header_use_logo' ) ) { ?>
											<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
												<img alt="Logo" class="logo logo_big" src="<?php echo apply_filters( 'valeo_header_logo_big', $theme_options['header_logo_big'] ); ?>"/>
											</a>
										<?php } else { ?>
											<div class="text-logo">
												<div class="blogname">
													<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
														$site_name = apply_filters( "valeo_logo_site_name", get_bloginfo( 'name', 'display' ) );
														if ( ! empty( $site_name ) ) {
															echo valeo_logo_highlight( esc_attr( $site_name ) );
														} ?>
													</a>
												</div>
												<div class="blogdescr">
													<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
														$site_description = apply_filters( "valeo_logo_site_name", get_bloginfo( 'description', 'display' ) );
														if ( ! empty( $site_description ) ) {
															echo valeo_replace_str_blogdescr( esc_attr( $site_description ) );
														} ?>
													</a>
												</div>
											</div>
										<?php } ?>
									</div><!-- .logo-->
								</div><!-- .header__logo-inner -->
							</div><!-- .header__logo -->

						</div>
					</div>
				</div><!-- .header__row1 -->

				<div class="header-sticky-height">
					<div class="header__row2 header-sticky">
						<div class="container">
							<div class="row">

								<!-- Header Menu -->
								<div class="header__menu <?php print $bootstrap_class ?> col-sm-12 hidden-xs">
									<div class="header__menu-inner">

										<!-- Menu Strip -->
										<div class="menu-strip">
											<nav class="main-nav"><?php
												if ( has_nav_menu( 'primary' ) ) {
													wp_nav_menu( array(
														'container'      => false, /* classes for container */
														'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
														'theme_location' => 'primary', /* we have two menus here we use our header menu as primery navigation */
														'depth'          => 0 /* in depth of 3 we'r using dropdown menu */
													) );
													valeo_header_menu_extra();

												} elseif ( wp_get_nav_menu_object( "Main menu" ) ) {
													wp_nav_menu( array(
														'container'  => false, /* classes for container */
														'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
														'menu'       => esc_attr( 'Main menu', 'valeo' ),
														'depth'      => 0 /* in depth of 3 we'r using dropdown menu */
													) );
													valeo_header_menu_extra();

												} else { ?>
													<div class="create-menu"><?php esc_html_e( 'You don\'t have a menu. Please create one ', 'valeo' ); ?>
													<strong><a href="<?php echo esc_url( home_url( '/' ) ) ?>wp-admin/nav-menus.php"><?php esc_html_e( 'HERE', 'valeo' ) ?></a></strong>
													</div><?php
												} ?>
											</nav>
										</div><!-- .menu-strip -->

									</div><!-- .header__menu-inner -->
								</div><!-- .header__menu -->

								<!-- Header Buttons and Social icons -->
								<div class="header__buttons header__social <?php print $bootstrap_class_HeaderButtons ?> hidden-sm col-sm-12">
									<div class="header__social-wrapper">
										<div class="header__social-inner">
											<div class="header-social">
												<ul id="menu-social-menu" class="social-navigation">
													<?php // search icon
													if ( valeo_get_customizer_option( 'hide_header_search' ) == '' ) { ?>
													<li class="button-li">
														<span class="header-button header-button__wrapper">
															<span class="header-button header-button__search"><i class="fa fa-search"></i></span>
														</span>
													</li>
													<?php }
													// Shop icon and dropdown cart
													if ( !$hide_shop_icon ) { ?>
													<li class="button-li">
														<?php echo valeo_woocommerce_cart_dropdown(); ?>
													</li>
													<?php }
													if ( valeo_get_customizer_option( 'hide_header_social' ) == '' ) {
														echo valeo_header_social_links();
													} ?>
													<li class="button-li nav-bar">
														<span class="header-button header-button__wrapper">
															<span class="header-button header-button__menu nav-button"></span>
														</span>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div><!-- .header__buttons -->

							</div><!-- .row -->
						</div><!-- .container -->
					</div><!-- .header__row2 -->
				</div><!-- .header-sticky-height -->

			</div><!-- .header.style3 -->
		</div><!-- .header-wrapper -->

		<?php if ( valeo_get_customizer_option( 'hide_header_search' ) == '' ) { ?>
			<!-- Search Box -->
			<div class="search-box">
				<form class="search-box__form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>"
				      role="search">
					<label class="search-box__label" for="search-box__input"><?php
						esc_html_e( 'Enter search words and press enter', 'valeo' ) ?></label>
					<input class="search-box__input" type="search" id="search-box__input" name="s"
					       placeholder="<?php esc_html_e( 'Type search keyword here...', 'valeo' ) ?>"/>
				</form>
			</div><!-- .search-box -->
		<?php } ?>
		<!-- tc: /valeo_header3 -->
		<?php
	}
endif;

if ( ! function_exists( 'valeo_header_menu_extra' ) ) :
/**
 * Extra menu HTML
 *
 * Header: when you need to insert extra menu items to menu dropdown
 */
function valeo_header_menu_extra() { ?>
	<ul class="menu menu-extra">
		<li id="more-li">
			<a><i class="fa fa-ellipsis-v"></i><!--<span>More</span>--></a>
			<ul id="menu-extra" class="sub-menu"></ul>
		</li>
	</ul>
<?php
}
endif;